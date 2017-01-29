<?php

namespace HeptacomAmp\Components\DOMAmplifier;

use DOMAttr;
use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\Helper\DOMNodeRecursiveIterator;

/**
 * Class ComponentInjection
 * @package HeptacomAmp\Components\DOMAmplifier
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
        'amp-access-laterpay' => 'amp-access-laterpay',
        'amp-access' => 'amp-access',
        'amp-accordion' => 'amp-accordion',
        'amp-ad' => 'amp-ad',
        'amp-analytics' => 'amp-analytics',
        'amp-anim' => 'amp-anim',
        'amp-animation' => 'amp-animation',
        'amp-apester-media' => 'amp-apester-media',
        'amp-app-banner' => 'amp-app-banner',
        'amp-audio' => 'amp-audio',
        'amp-bind' => 'amp-bind',
        'amp-brid-player' => 'amp-brid-player',
        'amp-brightcove' => 'amp-brightcove',
        'amp-carousel' => 'amp-carousel',
        'amp-dailymotion' => 'amp-dailymotion',
        'amp-dynamic-css-classes' => 'amp-dynamic-css-classes',
        'amp-experiment' => 'amp-experiment',
        'amp-facebook' => 'amp-facebook',
        'amp-fit-text' => 'amp-fit-text',
        'amp-font' => 'amp-font',
        'amp-form' => 'amp-form',
        'amp-fx-flying-carpet' => 'amp-fx-flying-carpet',
        'amp-gfycat' => 'amp-gfycat',
        'amp-google-vrview-image' => 'amp-google-vrview-image',
        'amp-hulu' => 'amp-hulu',
        'amp-iframe' => 'amp-iframe',
        'amp-image-lightbox' => 'amp-image-lightbox',
        'amp-instagram' => 'amp-instagram',
        'amp-install-serviceworker' => 'amp-install-serviceworker',
        'amp-jwplayer' => 'amp-jwplayer',
        'amp-kaltura-player' => 'amp-kaltura-player',
        'amp-lightbox' => 'amp-lightbox',
        'amp-list' => 'amp-list',
        'amp-live-list' => 'amp-live-list',
        'amp-mustache' => 'amp-mustache',
        'amp-o2-player' => 'amp-o2-player',
        'amp-ooyala-player' => 'amp-ooyala-player',
        'amp-pinterest' => 'amp-pinterest',
        'amp-playbuzz' => 'amp-playbuzz',
        'amp-reach-player' => 'amp-reach-player',
        'amp-reddit' => 'amp-reddit',
        'amp-selector' => 'amp-selector',
        'amp-share-tracking' => 'amp-share-tracking',
        'amp-sidebar' => 'amp-sidebar',
        'amp-social-share' => 'amp-social-share',
        'amp-soundcloud' => 'amp-soundcloud',
        'amp-springboard-player' => 'amp-springboard-player',
        'amp-sticky-ad' => 'amp-sticky-ad',
        'amp-twitter' => 'amp-twitter',
        'amp-user-notification' => 'amp-user-notification',
        'amp-video' => 'amp-video',
        'amp-vimeo' => 'amp-vimeo',
        'amp-vine' => 'amp-vine',
        'amp-viz-vega' => 'amp-viz-vega',
        'amp-youtube' => 'amp-youtube',
        /** Additional filter **/
        'form' => 'amp-form',
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
                $comps[] = static::$components[strtolower($subnode->nodeName)];
            }
        }

        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        /** @var DOMNode $head */
        foreach ($document->getElementsByTagName('head') as $head) {
            foreach (array_unique($comps) as $comp) {
                $compScript = $document->createElement('script');

                $compScript->setAttributeNode(new DOMAttr('async'));
                $compScript->setAttributeNode(new DOMAttr('custom-element', $comp));
                $compScript->setAttributeNode(new DOMAttr('src', "https://cdn.ampproject.org/v0/{$comp}-latest.js"));

                $head->appendChild($compScript);
            }

            break;
        }

        return $node;
    }
}
