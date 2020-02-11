<?php declare(strict_types=1);

namespace HeptacomAmp\Components;

use Google_Client;
use Google_Service_Acceleratedmobilepageurl;
use Google_Service_Acceleratedmobilepageurl_BatchGetAmpUrlsRequest;
use Google_Service_Acceleratedmobilepageurl_BatchGetAmpUrlsResponse;
use InvalidArgumentException;
use Shopware\Components\HttpClient\HttpClientInterface;

class GoogleAMP
{
    /**
     * @var Google_Client
     */
    private $client;

    /**
     * @var HttpClientInterface
     */
    private $guzzle;

    /**
     * @param string $googleApiKey the Google API key
     */
    public function __construct($googleApiKey)
    {
        $this->client = new Google_Client();
        $this->client->setDeveloperKey($googleApiKey);
        $this->client->setApplicationName('Shopware_HEPTACOM_AMP');
        $this->guzzle = Shopware()->Container()->get('http_client');
    }

    /**
     * Sends a request to Google to index the url.
     *
     * @param string $url the url to request an indexing
     */
    public function indexUrl($url)
    {
        if (stripos($url, 'https://') === 0) {
            $url = 'https://cdn.ampproject.org/c/s/' . substr($url, 0, 8);
        } elseif (stripos($url, 'http://') === 0) {
            $url = 'https://cdn.ampproject.org/c/' . substr($url, 0, 7);
        } else {
            throw new InvalidArgumentException();
        }

        $this->guzzle->get($url);
    }

    /**
     * Requests the AMP urls that correspond to the canonicals.
     *
     * @param string[] $urls       the urls to check
     * @param bool     $checkCache true, if the cache should be updated on request
     *
     * @return Google_Service_Acceleratedmobilepageurl_BatchGetAmpUrlsResponse
     */
    public function ampUrlsDoBatchGet(array $urls, $checkCache)
    {
        $batchGet = new Google_Service_Acceleratedmobilepageurl($this->client);
        $param = new Google_Service_Acceleratedmobilepageurl_BatchGetAmpUrlsRequest();
        $param->setLookupStrategy($checkCache ? 'FETCH_LIVE_DOC' : 'IN_INDEX_DOC');
        $param->setUrls($urls);

        return $batchGet->ampUrls->batchGet($param);
    }
}
