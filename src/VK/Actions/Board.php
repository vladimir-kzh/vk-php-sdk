<?php

namespace VK\Actions;

use VK\Actions\Enums\BoardGetCommentsSort;
use VK\Actions\Enums\BoardGetTopicsOrder;
use VK\Actions\Enums\BoardGetTopicsPreview;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Board {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Board constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of topics on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - array topic_ids: IDs of topics to be returned (100 maximum). By default, all topics are returned. If
     *        this parameter is set, the 'order', 'offset', and 'count' parameters are ignored.
     *      - BoardGetTopicsOrder order: Sort order: '1' — by date updated in reverse chronological order. '2'
     *        — by date created in reverse chronological order. '-1' — by date updated in chronological order. '-2'
     *        — by date created in chronological order. If no sort order is specified, topics are returned in the order
     *        specified by the group administrator. Pinned topics are returned first, regardless of the sorting.
     * @see BoardGetTopicsOrder
     *      - integer offset: Offset needed to return a specific subset of topics.
     *      - integer count: Number of topics to return.
     *      - boolean extended: '1' — to return information about users who created topics or who posted there
     *        last, '0' — to return no additional fields (default)
     *      - BoardGetTopicsPreview preview: '1' — to return the first comment in each topic,, '2' — to return
     *        the last comment in each topic,, '0' — to return no comments. By default: '0'.
     * @see BoardGetTopicsPreview
     *      - integer preview_length: Number of characters after which to truncate the previewed comment. To
     *        preview the full comment, specify '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getTopics(array $params = array()) {
        return $this->http->post('board.getTopics', $params);
    }

    /**
     * Returns a list of comments on a topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *      - boolean need_likes: '1' — to return the 'likes' field, '0' — not to return the 'likes' field
     *        (default)
     *      - integer start_comment_id:
     *      - integer offset: Offset needed to return a specific subset of comments.
     *      - integer count: Number of comments to return.
     *      - boolean extended: '1' — to return information about users who posted comments, '0' — to return no
     *        additional fields (default)
     *      - BoardGetCommentsSort sort: Sort order: 'asc' — by creation date in chronological order, 'desc' —
     *        by creation date in reverse chronological order,
     * @see BoardGetCommentsSort
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('board.getComments', $params);
    }

    /**
     * Creates a new topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - string title: Topic title.
     *      - string text: Text of the topic.
     *      - boolean from_group: For a community: '1' — to post the topic as by the community, '0' — to post
     *        the topic as by the user (default)
     *      - array attachments: List of media objects attached to the topic, in the following format:
     *        "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media object: 'photo' — photo, 'video' —
     *        video, 'audio' — audio, 'doc' — document, '<owner_id>' — ID of the media owner. '<media_id>' — Media
     *        ID. Example: "photo100172_166443618,photo66748_265827614", , "NOTE: If you try to attach more than one
     *        reference, an error will be thrown.",
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function addTopic(array $params = array()) {
        return $this->http->post('board.addTopic', $params);
    }

    /**
     * Adds a comment on a topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: ID of the topic to be commented on.
     *      - string message: (Required if 'attachments' is not set.) Text of the comment.
     *      - array attachments: (Required if 'text' is not set.) List of media objects attached to the comment, in
     *        the following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media object: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, '<owner_id>' — ID of the media owner.
     *        '<media_id>' — Media ID.
     *      - boolean from_group: '1' — to post the comment as by the community, '0' — to post the comment as
     *        by the user (default)
     *      - integer sticker_id: Sticker ID.
     *      - string guid: Unique identifier to avoid repeated comments.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function createComment(array $params = array()) {
        return $this->http->post('board.createComment', $params);
    }

    /**
     * Deletes a topic from a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteTopic(array $params = array()) {
        return $this->http->post('board.deleteTopic', $params);
    }

    /**
     * Edits the title of a topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *      - string title: New title of the topic.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editTopic(array $params = array()) {
        return $this->http->post('board.editTopic', $params);
    }

    /**
     * Edits a comment on a topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *      - integer comment_id: ID of the comment on the topic.
     *      - string message: (Required if 'attachments' is not set). New comment text.
     *      - array attachments: (Required if 'message' is not set.) List of media objects attached to the comment,
     *        in the following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media object: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, '<owner_id>' — ID of the media owner.
     *        '<media_id>' — Media ID. Example: "photo100172_166443618,photo66748_265827614"
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editComment(array $params = array()) {
        return $this->http->post('board.editComment', $params);
    }

    /**
     * Restores a comment deleted from a topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *      - integer comment_id: Comment ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function restoreComment(array $params = array()) {
        return $this->http->post('board.restoreComment', $params);
    }

    /**
     * Deletes a comment on a topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *      - integer comment_id: Comment ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteComment(array $params = array()) {
        return $this->http->post('board.deleteComment', $params);
    }

    /**
     * Re-opens a previously closed topic on a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function openTopic(array $params = array()) {
        return $this->http->post('board.openTopic', $params);
    }

    /**
     * Closes a topic on a community's discussion board so that comments cannot be posted.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function closeTopic(array $params = array()) {
        return $this->http->post('board.closeTopic', $params);
    }

    /**
     * Pins a topic (fixes its place) to the top of a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function fixTopic(array $params = array()) {
        return $this->http->post('board.fixTopic', $params);
    }

    /**
     * Unpins a pinned topic from the top of a community's discussion board.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the discussion board.
     *      - integer topic_id: Topic ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unfixTopic(array $params = array()) {
        return $this->http->post('board.unfixTopic', $params);
    }
}
