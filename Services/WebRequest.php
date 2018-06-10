<?php

namespace HeptacomAmp\Services;

use Shopware\Components\HttpClient\GuzzleFactory;
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
     * @param GuzzleHttpClient $guzzleFactory
     */
    public function __construct(GuzzleFactory $guzzleFactory)
    {
        $this->guzzleHttpClient = $guzzleFactory->createClient();
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
        $request = $this->guzzleHttpClient->createRequest('GET', $url, [
            'verify' => false,
        ]);
        return $this->guzzleHttpClient->send($request)->getBody()->getContents();
    }
}
