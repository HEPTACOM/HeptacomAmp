<?php

namespace HeptacomAmp\Components;

use Google_Client;
use Google_Service_Acceleratedmobilepageurl;
use Google_Service_Acceleratedmobilepageurl_BatchGetAmpUrlsRequest;
use Google_Service_Acceleratedmobilepageurl_BatchGetAmpUrlsResponse;
/**
 * Class GoogleAMP
 * @package HeptacomAmp\Components
 */
class GoogleAMP
{
    /**
     * @var Google_Client
     */
    private $client;

    /**
     * GoogleAMP constructor.
     * @param string $googleApiKey The Google API key.
     */
    public function __construct($googleApiKey)
    {
        $this->client = new Google_Client();
        $this->client->setDeveloperKey($googleApiKey);
        $this->client->setApplicationName('Shopware_HEPTACOM_AMP');
    }

    /**
     * Requests the AMP urls that correspond to the canonicals.
     * @param string[] $urls The urls to check.
     * @param boolean  $checkCache True, if the cache should be updated on request.
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
