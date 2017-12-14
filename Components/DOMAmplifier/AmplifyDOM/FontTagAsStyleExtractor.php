<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
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

        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        /** @var DOMElement $subnode */
        foreach ($document->getElementsByTagName('font') as $subnode) {
            $styleProps = [];

            if (!is_null($faceAttr = $subnode->getAttributeNode('face'))) {
                $styleProps['font-family'] = $faceAttr->value;
                $subnode->removeAttributeNode($faceAttr);
            }
            if (!is_null($sizeAttr = $subnode->getAttributeNode('size'))) {
                $styleProps['font-size'] = static::fontSizeNumberToFontSize($sizeAttr->value);
                $subnode->removeAttributeNode($sizeAttr);
            }
            if (!is_null($colorAttr = $subnode->getAttributeNode('color'))) {
                $styleProps['color'] = $colorAttr->value;
                $subnode->removeAttributeNode($colorAttr);
            }

            $span = $document->createElement('span');

            foreach ($subnode->childNodes as $childNode) {
                $span->appendChild($childNode);
            }

            if (!empty($styleProps)) {
                $cssIndex++;
                $key = "heptacom-amp-font-$cssIndex";

                $style = ".$key{ ";
                foreach ($styleProps as $propName => $propValue) {
                    $style .= "$propName: $propValue;";
                }
                $style .= " }";

                $this->styleStorage->addStyle($style);

                if (empty($class = $span->getAttribute('class'))) {
                    $span->setAttribute('class', $key);
                } else {
                    $span->setAttribute('class', "$class $key");
                }
            }

            $subnode->parentNode->insertBefore($span, $subnode);
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
}
