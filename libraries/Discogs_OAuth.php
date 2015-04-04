<?php
namespace League\OAuth1\Client\Server;

use League\OAuth1\Client\Credentials\TokenCredentials;
use Guzzle\Service\Client as GuzzleClient;

class Discogs extends Server
{

    protected $userAgent;

    public function __construct($clientCredentials, SignatureInterface $signature = null, $userAgent = null)
    {
        $this->userAgent = $userAgent;
        parent::__construct($clientCredentials, $signature);
    }

    public function createHttpClient()
    {
        $client = new GuzzleClient();
        $this->userAgent and $client->setUserAgent($this->userAgent);

        return $client;
    }

    public function urlTemporaryCredentials()
    {
        return 'http://api.discogs.com/oauth/request_token';
    }

    public function urlAuthorization()
    {
        return 'http://discogs.com/oauth/authorize';
    }

    public function urlTokenCredentials()
    {
        return 'http://api.discogs.com/oauth/access_token';
    }

    public function userDetails($data, TokenCredentials $tokenCredentials) {}
    public function userUid($data, TokenCredentials $tokenCredentials) {}
    public function userEmail($data, TokenCredentials $tokenCredentials) {}
    public function userScreenName($data, TokenCredentials $tokenCredentials) {}
    public function urlUserDetails() {}

}
?>