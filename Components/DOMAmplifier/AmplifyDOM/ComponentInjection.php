<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMAttr;
use DOMDocument;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

/**
 * Class ComponentInjection
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class ComponentInjection implements IAmplifyDOM
{
    /**
     * @var string[]
     */
    private static $components = [
        /*
        built-ins:
        'amp-pixel' => 'amp-pixel',
        'amp-img' => 'amp-img',
        */
        'amp-access-laterpay' => [
            'component' => 'amp-access-laterpay',
            'version' => '0.1',
        ],
        'amp-access' => [
            'component' => 'amp-access',
            'version' => '0.1',
        ],
        'amp-accordion' => [
            'component' => 'amp-accordion',
            'version' => '0.1',
        ],
        'amp-ad' => [
            'component' => 'amp-ad',
            'version' => '0.1',
        ],
        'amp-analytics' => [
            'component' => 'amp-analytics',
            'version' => '0.1',
        ],
        'amp-anim' => [
            'component' => 'amp-anim',
            'version' => '0.1',
        ],
        'amp-animation' => [
            'component' => 'amp-animation',
            'version' => '0.1',
        ],
        'amp-apester-media' => [
            'component' => 'amp-apester-media',
            'version' => '0.1',
        ],
        'amp-app-banner' => [
            'component' => 'amp-app-banner',
            'version' => '0.1',
        ],
        'amp-audio' => [
            'component' => 'amp-audio',
            'version' => '0.1',
        ],
        'amp-bind' => [
            'amp-bind',
        ],
        'amp-brid-player' => [
            'component' => 'amp-brid-player',
            'version' => '0.1',
        ],
        'amp-brightcove' => [
            'component' => 'amp-brightcove',
            'version' => '0.1',
        ],
        'amp-carousel' => [
            'component' => 'amp-carousel',
            'version' => '0.1',
        ],
        'amp-dailymotion' => [
            'component' => 'amp-dailymotion',
            'version' => '0.1',
        ],
        'amp-dynamic-css-classes' => [
            'component' => 'amp-dynamic-css-classes',
            'version' => '0.1',
        ],
        'amp-experiment' => [
            'component' => 'amp-experiment',
            'version' => '0.1',
        ],
        'amp-facebook' => [
            'amp-facebook',
        ],
        'amp-fit-text' => [
            'component' => 'amp-fit-text',
            'version' => '0.1',
        ],
        'amp-font' => [
            'component' => 'amp-font',
            'version' => '0.1',
        ],
        'amp-form' => [
            'component' => 'amp-form',
            'version' => '0.1',
        ],
        'amp-fx-flying-carpet' => [
            'component' => 'amp-fx-flying-carpet',
            'version' => '0.1',
        ],
        'amp-gfycat' => [
            'component' => 'amp-gfycat',
            'version' => '0.1',
        ],
        'amp-google-vrview-image' => [
            'component' => 'amp-google-vrview-image',
            'version' => '0.1',
        ],
        'amp-hulu' => [
            'component' => 'amp-hulu',
            'version' => '0.1',
        ],
        'amp-iframe' => [
            'component' => 'amp-iframe',
            'version' => '0.1',
        ],
        'amp-image-lightbox' => [
            'component' => 'amp-image-lightbox',
            'version' => '0.1',
        ],
        'amp-instagram' => [
            'component' => 'amp-instagram',
            'version' => '0.1',
        ],
        'amp-install-serviceworker' => [
            'component' => 'amp-install-serviceworker',
            'version' => '0.1',
        ],
        'amp-jwplayer' => [
            'component' => 'amp-jwplayer',
            'version' => '0.1',
        ],
        'amp-kaltura-player' => [
            'component' => 'amp-kaltura-player',
            'version' => '0.1',
        ],
        'amp-lightbox' => [
            'component' => 'amp-lightbox',
            'version' => '0.1',
        ],
        'amp-list' => [
            'component' => 'amp-list',
            'version' => '0.1',
        ],
        'amp-live-list' => [
            'component' => 'amp-live-list',
            'version' => '0.1',
        ],
        'amp-mustache' => [
            'component' => 'amp-mustache',
            'version' => '0.1',
        ],
        'amp-o2-player' => [
            'component' => 'amp-o2-player',
            'version' => '0.1',
        ],
        'amp-ooyala-player' => [
            'component' => 'amp-ooyala-player',
            'version' => '0.1',
        ],
        'amp-pinterest' => [
            'component' => 'amp-pinterest',
            'version' => '0.1',
        ],
        'amp-playbuzz' => [
            'component' => 'amp-playbuzz',
            'version' => '0.1',
        ],
        'amp-reach-player' => [
            'component' => 'amp-reach-player',
            'version' => '0.1',
        ],
        'amp-reddit' => [
            'component' => 'amp-reddit',
            'version' => '0.1',
        ],
        'amp-selector' => [
            'component' => 'amp-selector',
            'version' => '0.1',
        ],
        'amp-share-tracking' => [
            'component' => 'amp-share-tracking',
            'version' => '0.1',
        ],
        'amp-sidebar' => [
            'component' => 'amp-sidebar',
            'version' => '0.1',
        ],
        'amp-social-share' => [
            'component' => 'amp-social-share',
            'version' => '0.1',
        ],
        'amp-soundcloud' => [
            'component' => 'amp-soundcloud',
            'version' => '0.1',
        ],
        'amp-springboard-player' => [
            'component' => 'amp-springboard-player',
            'version' => '0.1',
        ],
        'amp-sticky-ad' => [
            'component' => 'amp-sticky-ad',
            'version' => '0.1',
        ],
        'amp-twitter' => [
            'component' => 'amp-twitter',
            'version' => '0.1',
        ],
        'amp-user-notification' => [
            'component' => 'amp-user-notification',
            'version' => '0.1',
        ],
        'amp-video' => [
            'component' => 'amp-video',
            'version' => '0.1',
        ],
        'amp-vimeo' => [
            'component' => 'amp-vimeo',
            'version' => '0.1',
        ],
        'amp-vine' => [
            'component' => 'amp-vine',
            'version' => '0.1',
        ],
        'amp-viz-vega' => [
            'component' => 'amp-viz-vega',
            'version' => '0.1',
        ],
        'amp-youtube' => [
            'component' => 'amp-youtube',
            'version' => '0.1',
        ],
        /** Additional filter **/
        'form' => [
            'component' => 'amp-form',
            'version' => '0.1',
        ],
    ];

    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    public function amplify(DOMNode $node)
    {
        $comps = [];

        $nodes = new DOMNodeRecursiveIterator($node->childNodes);
        foreach ($nodes->getRecursiveIterator() as $subnode) {
            /** @var DOMNode $subnode */

            if (array_key_exists(strtolower($subnode->nodeName), static::$components)) {
                $comps[] = strtolower($subnode->nodeName);
            }
        }

        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        /** @var DOMNode $head */
        foreach ($document->getElementsByTagName('head') as $head) {
            $boilerplateStyle = $document->createElement('style', "body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}");
            $boilerplateStyle->setAttributeNode(new DOMAttr('amp-boilerplate'));
            $head->appendChild($boilerplateStyle);

            $boilerplateNoscript = $document->createElement('noscript');
            $boilerplateNoscriptStyle = $document->createElement('style', "body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}");
            $boilerplateNoscriptStyle->setAttributeNode(new DOMAttr('amp-boilerplate'));
            $boilerplateNoscript->appendChild($boilerplateNoscriptStyle);
            $head->appendChild($boilerplateNoscript);

            foreach (array_unique($comps) as $comp) {
                $compScript = $document->createElement('script');

                $compScript->setAttributeNode(new DOMAttr('async'));
                $compScript->setAttributeNode(new DOMAttr('custom-element', static::$components[$comp]['component']));
                $compScript->setAttributeNode(new DOMAttr(
                    'src',
                    "https://cdn.ampproject.org/v0/" . static::$components[$comp]['component'] . "-" . static::$components[$comp]['version'] . ".js"
                ));

                $head->appendChild($compScript);
            }

            break;
        }

        return $node;
    }
}
