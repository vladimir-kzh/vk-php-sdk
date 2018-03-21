<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Streaming {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Streaming constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Allows to receive data for the connection to Streaming API.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getServerUrl(array $params = array()) {
        return $this->http->post('streaming.getServerUrl', $params);
    }
}
