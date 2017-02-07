<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;

/**
 * Class InlineStyleExtractor
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class InlineStyleExtractor implements IAmplifyDOM
{
    /**
     * @var StyleStorage
     */
    private $styleStorage;

    /**
     * StyleExtractor constructor.
     * @param StyleStorage $styleStorage
     */
    public function __construct(StyleStorage $styleStorage)
    {
        $this->styleStorage = $styleStorage;
    }

    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    function amplify(DOMNode $node)
    {
        $cssIndex = 0;

        $nodes = new DOMNodeRecursiveIterator($node->childNodes);
        foreach ($nodes->getRecursiveIterator() as $subnode) {
            if ($subnode instanceof DOMElement &&
                $subnode->hasAttributes() &&
                !empty($styleAttr = $subnode->getAttribute('style'))) {
                $key = "heptacom-amp-inline-{++$cssIndex}";
                $this->styleStorage->addStyle(".$key{ $styleAttr }");

                $subnode->removeAttribute('style');

                if (empty($class = $subnode->getAttribute('class'))) {
                    $subnode->setAttribute('class', $key);
                } else {
                    $subnode->setAttribute('class', "$class $key");
                }
            }
        }

        return $node;
    }
}
