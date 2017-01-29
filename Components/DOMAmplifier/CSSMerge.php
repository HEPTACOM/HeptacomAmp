<?php

namespace HeptacomAmp\Components\DOMAmplifier;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;

/**
 * Class CSSMerge
 * @package HeptacomAmp\Components\DOMAmplifier
 */
class CSSMerge implements IAmplifyDOM
{
    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    public function amplify(DOMNode $node)
    {
        $cssIndex = 0;
        $css = [];

        $nodes = new DOMNodeRecursiveIterator($node->childNodes);
        foreach ($nodes->getRecursiveIterator() as $subnode) {
            /** @var DOMNode $subnode */

            if ($subnode instanceof DOMElement &&
                $subnode->hasAttributes() &&
                !is_null($styleAttr = $subnode->getAttribute('style'))) {
                $key = 'heptacom-amp-inline-'.++$cssIndex;
                $css[$cssIndex] = ".$key{ $styleAttr }";

                $subnode->removeAttribute('style');

                if (empty($class = $subnode->getAttribute('class'))) {
                    $subnode->setAttribute('class', $key);
                } else {
                    $subnode->setAttribute('class', "$class $key");
                }
            }
        }

        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        foreach ($document->getElementsByTagName('style') as $style) {
            if (!is_null($style->attributes->getNamedItem('amp-custom'))) {
                $style->textContent .= join('', $css);
                break;
            }
        }

        return $node;
    }
}
