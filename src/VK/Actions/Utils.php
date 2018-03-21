<?php

namespace VK\Actions;

use VK\Actions\Enums\UtilsGetLinkStatsInterval;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Utils {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Utils constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Checks whether a link is blocked in VK.
     *
     *
     * @param $params array
     *      - string url: Link to check (e.g., 'http://google.com').
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function checkLink(array $params = array()) {
        return $this->http->post('utils.checkLink', $params);
    }

    /**
     * Deletes shortened link from user's list.
     *
     *
     * @param $params array
     *      - string key: Link key (characters after vk.cc/).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteFromLastShortened(array $params = array()) {
        return $this->http->post('utils.deleteFromLastShortened', $params);
    }

    /**
     * Returns a list of user's shortened links.
     *
     *
     * @param $params array
     *      - integer count: Number of links to return.
     *      - integer offset: Offset needed to return a specific subset of links.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLastShortenedLinks(array $params = array()) {
        return $this->http->post('utils.getLastShortenedLinks', $params);
    }

    /**
     * Returns stats data for shortened link.
     *
     *
     * @param $params array
     *      - string key: Link key (characters after vk.cc/).
     *      - string access_key: Access key for private link stats.
     *      - UtilsGetLinkStatsInterval interval: Interval.
     * @see UtilsGetLinkStatsInterval
     *      - integer intervals_count: Number of intervals to return.
     *      - boolean extended: 1 — to return extended stats data (sex, age, geo). 0 — to return views number
     *        only.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLinkStats(array $params = array()) {
        return $this->http->post('utils.getLinkStats', $params);
    }

    /**
     * Allows to receive a link shortened via vk.cc.
     *
     *
     * @param $params array
     *      - string url: URL to be shortened.
     *      - boolean private: 1 — private stats, 0 — public stats.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getShortLink(array $params = array()) {
        return $this->http->post('utils.getShortLink', $params);
    }

    /**
     * Detects a type of object (e.g., user, community, application) and its ID by screen name.
     *
     *
     * @param $params array
     *      - string screen_name: Screen name of the user, community (e.g., 'apiclub,' 'andrew', or
     *        'rules_of_war'), or application.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function resolveScreenName(array $params = array()) {
        return $this->http->post('utils.resolveScreenName', $params);
    }

    /**
     * Returns the current time of the VK server.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getServerTime(array $params = array()) {
        return $this->http->post('utils.getServerTime', $params);
    }
}
