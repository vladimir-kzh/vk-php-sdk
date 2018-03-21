<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiWallAccessPostException;
use VK\Exceptions\VKClientException;

class Stats {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Stats constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns statistics of a community or an application.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer app_id: Application ID.
     *      - string date_from: Latest datestamp (in Unix time) of statistics to return.
     *      - string date_to: End datestamp (in Unix time) of statistics to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('stats.get', $params);
    }

    /**
     *
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function trackVisitor(array $params = array()) {
        return $this->http->post('stats.trackVisitor', $params);
    }

    /**
     * Returns stats for a wall post.
     *
     *
     * @param $params array
     *      - integer owner_id: post owner community id. Specify with "-" sign.
     *      - integer post_id: wall post id. Note that stats are available only for '300' last (newest) posts on a
     *        community wall.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessPostException Access to wall's post denied
     *
     */
    public function getPostReach(array $params = array()) {
        return $this->http->post('stats.getPostReach', $params);
    }
}
