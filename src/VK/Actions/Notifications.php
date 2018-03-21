<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Notifications {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Notifications constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of notifications about other users' feedback to the current user's wall posts.
     *
     *
     * @param $params array
     *      - integer count: Number of notifications to return.
     *      - string start_from:
     *      - array filters: Type of notifications to return: 'wall' — wall posts, 'mentions' — mentions in
     *        wall posts, comments, or topics, 'comments' — comments to wall posts, photos, and videos, 'likes' —
     *        likes, 'reposted' — wall posts that are copied from the current user's wall, 'followers' — new
     *        followers, 'friends' — accepted friend requests
     *      - integer start_time: Earliest timestamp (in Unix time) of a notification to return. By default, 24
     *        hours ago.
     *      - integer end_time: Latest timestamp (in Unix time) of a notification to return. By default, the
     *        current time.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('notifications.get', $params);
    }

    /**
     * Resets the counter of new notifications about other users' feedback to the current user's wall posts.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function markAsViewed(array $params = array()) {
        return $this->http->post('notifications.markAsViewed', $params);
    }
}
