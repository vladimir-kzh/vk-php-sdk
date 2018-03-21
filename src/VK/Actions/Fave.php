<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Fave {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Fave constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of users whom the current user has bookmarked.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of users.
     *      - integer count: Number of users to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUsers(array $params = array()) {
        return $this->http->post('fave.getUsers', $params);
    }

    /**
     * Returns a list of photos that the current user has liked.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of photos.
     *      - integer count: Number of photos to return.
     *      - boolean photo_sizes: '1' — to return photo sizes in a [vk.com/dev/photo_sizes|special format].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getPhotos(array $params = array()) {
        return $this->http->post('fave.getPhotos', $params);
    }

    /**
     * Returns a list of wall posts that the current user has liked.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of posts.
     *      - integer count: Number of posts to return.
     *      - boolean extended: '1' — to return additional 'wall', 'profiles', and 'groups' fields. By default:
     *        '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getPosts(array $params = array()) {
        return $this->http->post('fave.getPosts', $params);
    }

    /**
     * Returns a list of videos that the current user has liked.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of videos.
     *      - integer count: Number of videos to return.
     *      - boolean extended: Return an additional information about videos. Also returns all owners profiles and
     *        groups.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getVideos(array $params = array()) {
        return $this->http->post('fave.getVideos', $params);
    }

    /**
     * Returns a list of links that the current user has bookmarked.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of users.
     *      - integer count: Number of results to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLinks(array $params = array()) {
        return $this->http->post('fave.getLinks', $params);
    }

    /**
     * Returns market items bookmarked by current user.
     *
     *
     * @param $params array
     *      - integer count: Number of results to return.
     *      - boolean extended: '1' – to return additional fields 'likes, can_comment, can_repost, photos'. By
     *        default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getMarketItems(array $params = array()) {
        return $this->http->post('fave.getMarketItems', $params);
    }

    /**
     * Adds a profile to user faves.
     *
     *
     * @param $params array
     *      - integer user_id: Profile ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function addUser(array $params = array()) {
        return $this->http->post('fave.addUser', $params);
    }

    /**
     * Removes a profile from user faves.
     *
     *
     * @param $params array
     *      - integer user_id: Profile ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function removeUser(array $params = array()) {
        return $this->http->post('fave.removeUser', $params);
    }

    /**
     * Adds a community to user faves.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function addGroup(array $params = array()) {
        return $this->http->post('fave.addGroup', $params);
    }

    /**
     * Removes a community from user faves.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function removeGroup(array $params = array()) {
        return $this->http->post('fave.removeGroup', $params);
    }

    /**
     * Adds a link to user faves.
     *
     *
     * @param $params array
     *      - string link: Link URL.
     *      - string text: Description text.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function addLink(array $params = array()) {
        return $this->http->post('fave.addLink', $params);
    }

    /**
     * Removes link from the user's faves.
     *
     *
     * @param $params array
     *      - string link_id: Link ID (can be obtained by [vk.com/dev/faves.getLinks|faves.getLinks] method).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function removeLink(array $params = array()) {
        return $this->http->post('fave.removeLink', $params);
    }
}
