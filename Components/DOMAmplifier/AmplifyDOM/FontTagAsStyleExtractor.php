<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;
use HeptacomAmp\Components\DOMAmplifier\StyleStorage;

/*
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class FontTagAsStyleExtractor implements IAmplifyDOM
{
    const CLASS_ATTRIBUTE_KEY = 'class';

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

    public function __construct(StyleStorage $styleStorage)
    {
        $this->styleStorage = $styleStorage;
    }

    /**
     * Process and ⚡lifies the given node.
     *
     * @param DOMNode $node the node to ⚡lify
     *
     * @return DOMNode the ⚡lified node
     */
    public function amplify(DOMNode $node)
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
                ++$this->cssIndex;
                $this->generatedClasses[$props] = $key = "kskamp-font-$this->cssIndex";
                $this->styleStorage->addStyle(".$key{ $props }", 'fontTag');
            }

            if (empty($class = $result->getAttribute(self::CLASS_ATTRIBUTE_KEY))) {
                $result->setAttribute(self::CLASS_ATTRIBUTE_KEY, $key);
            } else {
                $result->setAttribute(self::CLASS_ATTRIBUTE_KEY, "$class $key");
            }
        }

        return $result;
    }

    /**
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

    /**
     * @param int $number
     *
     * @return string
     */
    private static function fontSizeNumberToFontSize($number)
    {
        $number = min(max((int) $number, 1), 7);

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
}
