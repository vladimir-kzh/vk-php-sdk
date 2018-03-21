<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiLimitsException;
use VK\Exceptions\VKClientException;

class Storage {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Storage constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a value of variable with the name set by key parameter.
     *
     *
     * @param $params array
     *      - string key:
     *      - array keys:
     *      - integer user_id:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('storage.get', $params);
    }

    /**
     * Saves a value of variable with the name set by 'key' parameter.
     *
     *
     * @param $params array
     *      - string key:
     *      - string value:
     *      - integer user_id:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function set(array $params = array()) {
        return $this->http->post('storage.set', $params);
    }

    /**
     * Returns the names of all variables.
     *
     *
     * @param $params array
     *      - integer user_id: user id, whose variables names are returned if they were requested with a server
     *        method.
     *      - integer count: amount of variable names the info needs to be collected from.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getKeys(array $params = array()) {
        return $this->http->post('storage.getKeys', $params);
    }
}
