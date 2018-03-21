<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Search {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Search constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Allows the programmer to do a quick search for any substring.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - integer offset: Offset for querying specific result subset
     *      - integer limit: Maximum number of results to return.
     *      - array filters:
     *      - boolean search_global:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getHints(array $params = array()) {
        return $this->http->post('search.getHints', $params);
    }
}
