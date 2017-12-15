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

        $attributeClasses = [];

        /** @var DOMElement $subnode */
        foreach (iterator_to_array($document->getElementsByTagName('font')) as $subnode) {
            $attributes = $this->transformArrayToCssString($this->extractAndRemoveFontAttributes($subnode));

            if (array_key_exists($attributes, $attributeClasses)) {
                $className = $attributeClasses[$attributes];
            } else {
                $this->cssIndex++;
                $attributeClasses[$attributes] = $className = "heptacom-amp-font-$this->cssIndex";

                $this->styleStorage->addStyle(".$className{ $attributes }");
            }

            $subnode->parentNode->insertBefore(
                $this->generateFontReplacement($document, $subnode->childNodes, $className),
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
    protected function extractAndRemoveFontAttributes($subnode)
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
     * @param DOMNodeList $subnode
     * @param string $class
     * @return mixed
     */
    protected function generateFontReplacement(DOMDocument $document, DOMNodeList $fontChildren, $class)
    {
        /** @var DOMElement $result */
        $result = $document->createElement('span');

        foreach ($fontChildren as $childNode) {
            $result->appendChild($childNode);
        }

        if (!empty($styleProps)) {
            if (empty($prevClass = $result->getAttribute('class'))) {
                $result->setAttribute('class', $class);
            } else {
                $result->setAttribute('class', "$prevClass $class");
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
