<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;

/*
 * Class FontTagAsStyleExtractor
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class FontTagAsStyleExtractor implements IAmplifyDOM
{
    /**
     * @var StyleStorage
     */
    private $styleStorage;

    /**
     * @var int
     */
    private $cssIndex = 0;

    /**
     * @var array
     */
    private $generatedClasses = [];

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
        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        /** @var DOMElement $subnode */
        foreach (iterator_to_array($document->getElementsByTagName('font')) as $subnode) {
            $subnode->parentNode->insertBefore(
                $this->generateFontReplacement(
                    $document, $subnode->childNodes, $this->extractAndRemoveFontAttributes($subnode)
                ),
                $subnode
            );
            $subnode->parentNode->removeChild($subnode);
        }

        return $node;
    }

    /**
     * @param int $number
     * @return string
     */
    private static function fontSizeNumberToFontSize($number)
    {
        $number = min(max((int)$number, 1), 7);
        
        $numbers = [
            1 => 'x-small',
            2 => 'small',
            3 => 'medium',
            4 => 'large',
            5 => 'x-large',
            6 => 'xx-large',
            7 => '4em',
        ];

        return $numbers[$number];
    }

    /**
     * @param DOMElement $subnode
     * @return array
     */
    protected function extractAndRemoveFontAttributes(DOMElement $subnode)
    {
        $result = [];

        if (($faceAttr = $subnode->getAttributeNode('face')) !== false) {
            $result['font-family'] = "\"$faceAttr->value\"";
            $subnode->removeAttributeNode($faceAttr);
        }

        if (($sizeAttr = $subnode->getAttributeNode('size')) !== false) {
            $result['font-size'] = static::fontSizeNumberToFontSize($sizeAttr->value);
            $subnode->removeAttributeNode($sizeAttr);
        }

        if (($colorAttr = $subnode->getAttributeNode('color')) !== false) {
            $result['color'] = $colorAttr->value;
            $subnode->removeAttributeNode($colorAttr);
        }

        return $result;
    }

    /**
     * @param DOMDocument $document
     * @param DOMNodeList $fontChildren
     * @param array $styleProps
     * @return mixed
     */
    protected function generateFontReplacement(DOMDocument $document, DOMNodeList $fontChildren, array $styleProps)
    {
        /** @var DOMElement $result */
        $result = $document->createElement('span');

        foreach ($fontChildren as $childNode) {
            $result->appendChild($childNode);
        }

        if (!empty($styleProps)) {
            $props = $this->transformArrayToCssString($styleProps);
            if (array_key_exists($props, $this->generatedClasses)) {
                $key = $this->generatedClasses[$props];
            } else {
                $this->cssIndex++;
                $this->generatedClasses[$props] = $key = "heptacom-amp-font-$this->cssIndex";
                $this->styleStorage->addStyle(".$key{ $props }");
            }

            if (empty($class = $result->getAttribute('class'))) {
                $result->setAttribute('class', $key);
            } else {
                $result->setAttribute('class', "$class $key");
            }
        }

        return $result;
    }

    /**
     * @param array $styleProps
     * @return string
     */
    protected function transformArrayToCssString(array $styleProps)
    {
        $result = '';

        foreach ($styleProps as $propName => $propValue) {
            $result .= "$propName: $propValue;";
        }

        return $result;
    }
}
