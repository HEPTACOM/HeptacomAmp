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
    const CLASS_ATTRIBUTE_KEY = 'class';

    const STYLE_ATTRIBUTE_KEY = 'style';

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
                !empty($styleAttr = $subnode->getAttribute(self::STYLE_ATTRIBUTE_KEY))) {
                $cssIndex++;
                $key = "heptacom-amp-inline-$cssIndex";

                $this->styleStorage->addStyle(".$key{ $styleAttr }");

                $subnode->removeAttribute(self::STYLE_ATTRIBUTE_KEY);

                if (empty($class = $subnode->getAttribute(self::CLASS_ATTRIBUTE_KEY))) {
                    $subnode->setAttribute(self::CLASS_ATTRIBUTE_KEY, $key);
                } else {
                    $subnode->setAttribute(self::CLASS_ATTRIBUTE_KEY, "$class $key");
                }
            }
        }

        return $node;
    }
}
