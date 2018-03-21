<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiStatusNoAudioException;
use VK\Exceptions\VKClientException;

class Status {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Status constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns data required to show the status of a user or community.
     *
     *
     * @param $params array
     *      - integer user_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer group_id:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('status.get', $params);
    }

    /**
     * Sets a new status for the current user.
     *
     *
     * @param $params array
     *      - string text: Text of the new status.
     *      - integer group_id: Identifier of a community to set a status in. If left blank the status is set to
     *        current user.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiStatusNoAudioException User disabled track name broadcast
     *
     */
    public function set(array $params = array()) {
        return $this->http->post('status.set', $params);
    }
}
