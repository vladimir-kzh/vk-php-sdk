<?php

namespace VK\Actions;

use VK\Actions\Enums\StoriesGetPhotoUploadServerLinkText;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiBlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiIncorrectReplyPrivacyException;
use VK\Exceptions\Api\VKApiMessagesUserBlockedException;
use VK\Exceptions\Api\VKApiStoryExpiredException;
use VK\Exceptions\VKClientException;

class Stories {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Stories constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Allows to hide stories from chosen sources from current user's feed.
     *
     *
     * @param $params array
     *      - array owners_ids: List of sources IDs
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function banOwner(array $params = array()) {
        return $this->http->post('stories.banOwner', $params);
    }

    /**
     * Allows to delete story.
     *
     *
     * @param $params array
     *      - integer owner_id: Story owner's ID. Current user id is used by default.
     *      - integer story_id: Story ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('stories.delete', $params);
    }

    /**
     * Returns stories available for current user.
     *
     *
     * @param $params array
     *      - integer owner_id: Owner ID.
     *      - boolean extended: '1' — to return additional fields for users and communities. Default value is 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('stories.get', $params);
    }

    /**
     * Returns list of sources hidden from current user's feed.
     *
     *
     * @param $params array
     *      - array fields: Additional fields to return
     *      - boolean extended: '1' — to return additional fields for users and communities. Default value is 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getBanned(array $params = array()) {
        return $this->http->post('stories.getBanned', $params);
    }

    /**
     * Returns story by its ID.
     *
     *
     * @param $params array
     *      - array stories: Stories IDs separated by commas. Use format {owner_id}+'_'+{story_id}, for example,
     *        12345_54331.
     *      - boolean extended: '1' — to return additional fields for users and communities. Default value is 0.
     *      - array fields: Additional fields to return
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiStoryExpiredException Story has already expired
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('stories.getById', $params);
    }

    /**
     * Returns URL for uploading a story with photo.
     *
     *
     * @param $params array
     *      - boolean add_to_news: 1 — to add the story to friend's feed.
     *      - array user_ids: List of users IDs who can see the story.
     *      - string reply_to_story: ID of the story to reply with the current.
     *      - StoriesGetPhotoUploadServerLinkText link_text: Link text (for community's stories only).
     * @see StoriesGetPhotoUploadServerLinkText
     *      - string link_url: Link URL. Internal links on https://vk.com only.
     *      - integer group_id: ID of the community to upload the story (should be verified or with the "fire"
     *        icon).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiBlockedException Content blocked
     * @throws VKApiMessagesUserBlockedException Can't send messages for users from blacklist
     * @throws VKApiIncorrectReplyPrivacyException Incorrect reply privacy
     *
     */
    public function getPhotoUploadServer(array $params = array()) {
        return $this->http->post('stories.getPhotoUploadServer', $params);
    }

    /**
     * Returns replies to the story.
     *
     *
     * @param $params array
     *      - integer owner_id: Story owner ID.
     *      - integer story_id: Story ID.
     *      - string access_key: Access key for the private object.
     *      - boolean extended: '1' — to return additional fields for users and communities. Default value is 0.
     *      - array fields: Additional fields to return
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getReplies(array $params = array()) {
        return $this->http->post('stories.getReplies', $params);
    }

    /**
     * Returns stories available for current user.
     *
     *
     * @param $params array
     *      - integer owner_id: Story owner ID.
     *      - integer story_id: Story ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getStats(array $params = array()) {
        return $this->http->post('stories.getStats', $params);
    }

    /**
     * Allows to receive URL for uploading story with video.
     *
     *
     * @param $params array
     *      - boolean add_to_news: 1 — to add the story to friend's feed.
     *      - array user_ids: List of users IDs who can see the story.
     *      - string reply_to_story: ID of the story to reply with the current.
     *      - string link_text: Link text (for community's stories only).
     *      - string link_url: Link URL. Internal links on https://vk.com only.
     *      - integer group_id: ID of the community to upload the story (should be verified or with the "fire"
     *        icon).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiBlockedException Content blocked
     * @throws VKApiMessagesUserBlockedException Can't send messages for users from blacklist
     * @throws VKApiIncorrectReplyPrivacyException Incorrect reply privacy
     *
     */
    public function getVideoUploadServer(array $params = array()) {
        return $this->http->post('stories.getVideoUploadServer', $params);
    }

    /**
     * Returns a list of story viewers.
     *
     *
     * @param $params array
     *      - integer owner_id: Story owner ID.
     *      - integer story_id: Story ID.
     *      - count: Maximum number of results.
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - boolean extended: '1' — to return detailed information about photos
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiStoryExpiredException Story has already expired
     *
     */
    public function getViewers(array $params = array()) {
        return $this->http->post('stories.getViewers', $params);
    }

    /**
     * Hides all replies in the last 24 hours from the user to current user's stories.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user whose replies should be hidden.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function hideAllReplies(array $params = array()) {
        return $this->http->post('stories.hideAllReplies', $params);
    }

    /**
     * Hides the reply to the current user's story.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user whose replies should be hidden.
     *      - integer story_id: Story ID.
     *      - string access_key: Access key for the private object.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function hideReply(array $params = array()) {
        return $this->http->post('stories.hideReply', $params);
    }

    /**
     * Allows to show stories from hidden sources in current user's feed.
     *
     *
     * @param $params array
     *      - array owners_ids: List of hidden sources to show stories from.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unbanOwner(array $params = array()) {
        return $this->http->post('stories.unbanOwner', $params);
    }
}
