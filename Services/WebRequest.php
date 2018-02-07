<?php

namespace HeptacomAmp\Services;

use Shopware\Components\HttpClient\GuzzleHttpClient;
use Shopware\Components\HttpClient\RequestException;

/**
 * Class WebRequest
 * @package HeptacomAmp\Services
 */
class WebRequest
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleHttpClient;

    /**
     * WebRequest constructor.
     * @param GuzzleHttpClient $guzzleHttpClient
     */
    public function __construct(GuzzleHttpClient $guzzleHttpClient)
    {
        $this->guzzleHttpClient = $guzzleHttpClient;
    }

    /**
     * @param string $url
     * @return int
     */
    public function ping($url)
    {
        try {
            return intval($this->guzzleHttpClient->get($url)->getStatusCode());
        } catch (RequestException $e) {
            return 666;
        }
    }

    /**
     * @param $url
     * @return string
     */
    public function get($url)
    {
        try {
            return $this->guzzleHttpClient->get($url)->getBody()->getContents();
        } catch (RequestException $e) {
            return '';
        }
    }
}
