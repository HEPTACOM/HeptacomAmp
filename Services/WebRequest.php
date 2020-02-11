<?php declare(strict_types=1);

namespace HeptacomAmp\Services;

use Shopware\Components\HttpClient\GuzzleFactory;
use Shopware\Components\HttpClient\GuzzleHttpClient;
use Shopware\Components\HttpClient\RequestException;

class WebRequest
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleHttpClient;

    /**
     * @param GuzzleHttpClient $guzzleFactory
     */
    public function __construct(GuzzleFactory $guzzleFactory)
    {
        $this->guzzleHttpClient = $guzzleFactory->createClient();
    }

    /**
     * @param string $url
     *
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
     * @param mixed $url
     *
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
