<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMDocument;
use DOMElement;
use DOMNode;
use HeptacomAmp\Components\DOMAmplifier\IAmplifyDOM;

/*
 * Class ConvertIframeToYoutube
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
class ConvertIframeToYoutube implements IAmplifyDOM
{
    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    function amplify(DOMNode $node)
    {
        /** @var DOMDocument $document */
        $document = $node instanceof DOMDocument ? $node : $node->ownerDocument;

        /** @var DOMElement $iframe */
        foreach (iterator_to_array($document->getElementsByTagName('iframe')) as $iframe) {
            $url = parse_url($iframe->getAttribute('src'));

            if (stripos($url['host'], 'youtube.com') !== false) {
                $path = explode('/', $url['path']);
                $youtubeId = ($embedKey = array_search('embed', $path)) !== false ? $path[$embedKey + 1] : null;

                if (!is_null($youtubeId)) {
                    parse_str($url['query'], $queryParams);
                    $iframe->parentNode->insertBefore(
                        $this->generateIframeReplacement($document, $youtubeId, $iframe, $queryParams),
                        $iframe
                    );
                    $iframe->parentNode->removeChild($iframe);
                }
            }
        }

        return $node;
    }

    /**
     * @param DOMDocument $document
     * @param string $youtubeId
     * @param DOMElement $iframe
     * @return mixed
     */
    protected function generateIframeReplacement(DOMDocument $document, $youtubeId, DOMElement $iframe, array $iframeQueryParams)
    {
        /** @var DOMElement $result */
        $result = $document->createElement('amp-youtube');

        $result->setAttribute('data-videoid', $youtubeId);
        $result->setAttribute('layout', 'responsive');
        $result->setAttribute('width',  $iframe->hasAttribute('width') ? $iframe->getAttribute('width') : 480);
        $result->setAttribute('height',  $iframe->hasAttribute('height') ? $iframe->getAttribute('height') : 270);
        if (array_key_exists('autoplay', $iframeQueryParams)) {
            $result->setAttribute('autoplay', '');
        }

        $youtubeQueryParams = [
            'cc_load_policy',
            'color',
            'controls',
            'disablekb',
            'enablejsapi',
            'hl',
            'list',
            'listType',
            'loop',
            'rel',
            'showinfo',
            'start',
        ];

        foreach ($youtubeQueryParams as $queryParam) {
            if (array_key_exists($queryParam, $iframeQueryParams)) {
                $result->setAttribute('data-param-'.$queryParam, $iframeQueryParams[$queryParam]);
            }
        }

        return $result;
    }
}
