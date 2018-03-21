<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Widgets {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Widgets constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Gets a list of comments for the page added through the [vk.com/dev/Comments|Comments widget].
     *
     *
     * @param $params array
     *      - integer widget_api_id:
     *      - string url:
     *      - string page_id:
     *      - string order:
     *      - array fields:
     *      - integer count:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('widgets.getComments', $params);
    }

    /**
     * Gets a list of application/site pages where the [vk.com/dev/Comments|Comments widget] or [vk.com/dev/Like|Like
     * widget] is installed.
     *
     *
     * @param $params array
     *      - integer widget_api_id:
     *      - string order:
     *      - string period:
     *      - integer count:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getPages(array $params = array()) {
        return $this->http->post('widgets.getPages', $params);
    }
}
