<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

/**
 * Class InlineStyleExtractor
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class InlineStyleExtractor implements IAmplifyDOM
{
    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    function amplify(DOMNode $node)
    {
        $cssIndex = 0;

        $styles = [];

        $nodes = new DOMNodeRecursiveIterator($node->childNodes);
        foreach ($nodes->getRecursiveIterator() as $subnode) {
            if ($subnode instanceof DOMElement &&
                $subnode->hasAttributes() &&
                !empty($styleAttr = $subnode->getAttribute('style'))) {
                $cssIndex++;
                $key = "heptacom-amp-inline-$cssIndex";
                $styles[] = ".$key{ $styleAttr }";

                $subnode->removeAttribute('style');

                if (empty($class = $subnode->getAttribute('class'))) {
                    $subnode->setAttribute('class', $key);
                } else {
                    $subnode->setAttribute('class', "$class $key");
                }
            }
        }

        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;
        $styleTags = $document->getElementsByTagName('style');
        $tag = null;

        foreach ($styleTags as $styleTag) {
            /** @var DOMElement $styleTag */
            if ($styleTag->hasAttribute('amp-custom')) {
                $tag = $styleTag;
                break;
            }
        }

        if (is_null($tag)) {
            foreach ($document->getElementsByTagName('head') as $head) {
                /** @var DOMElement $head */
                $tag = $document->createElement('style');
                $tag->setAttributeNode($document->createAttribute('amp-custom'));
                $head->appendChild($tag);

                break;
            }

            $tag->textContent = '';
        }

        $tag->textContent = $tag->textContent.join($styles);

        return $node;
    }
}
