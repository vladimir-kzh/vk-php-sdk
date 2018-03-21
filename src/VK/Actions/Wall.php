<?php

namespace VK\Actions;

use VK\Actions\Enums\WallGetCommentsSort;
use VK\Actions\Enums\WallGetFilter;
use VK\Actions\Enums\WallReportCommentReason;
use VK\Actions\Enums\WallReportPostReason;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiBlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiUserDeletedException;
use VK\Exceptions\Api\VKApiWallAccessAddReplyException;
use VK\Exceptions\Api\VKApiWallAccessCommentException;
use VK\Exceptions\Api\VKApiWallAccessPostException;
use VK\Exceptions\Api\VKApiWallAccessRepliesException;
use VK\Exceptions\Api\VKApiWallAddPostException;
use VK\Exceptions\Api\VKApiWallAdsPostLimitReachedException;
use VK\Exceptions\Api\VKApiWallAdsPublishedException;
use VK\Exceptions\Api\VKApiWallLinksForbiddenException;
use VK\Exceptions\Api\VKApiWallTooManyRecipientsException;
use VK\Exceptions\VKClientException;

class Wall {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Wall constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of posts on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the wall. By default, current user ID. Use a
     *        negative value to designate a community ID.
     *      - string domain: User or community short address.
     *      - integer offset: Offset needed to return a specific subset of posts.
     *      - integer count: Number of posts to return (maximum 100).
     *      - WallGetFilter filter: Filter to apply: 'owner' — posts by the wall owner, 'others' — posts by
     *        someone else, 'all' — posts by the wall owner and others (default), 'postponed' — timed posts (only
     *        available for calls with an 'access_token'), 'suggests' — suggested posts on a community wall
     * @see WallGetFilter
     *      - boolean extended: '1' — to return 'wall', 'profiles', and 'groups' fields, '0' — to return no
     *        additional fields (default)
     *      - array fields:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiBlockedException Content blocked
     * @throws VKApiUserDeletedException User was deleted or banned
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('wall.get', $params);
    }

    /**
     * Allows to search posts on user or community walls.
     *
     *
     * @param $params array
     *      - integer owner_id: user or community id. "Remember that for a community 'owner_id' must be negative."
     *      - string domain: user or community screen name.
     *      - string query: search query string.
     *      - boolean owners_only: '1' – returns only page owner's posts.
     *      - integer count: count of posts to return.
     *      - integer offset: Offset needed to return a specific subset of posts.
     *      - boolean extended: show extended post info.
     *      - array fields:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessPostException Access to wall's post denied
     * @throws VKApiUserDeletedException User was deleted or banned
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('wall.search', $params);
    }

    /**
     * Returns a list of posts from user or community walls by their IDs.
     *
     *
     * @param $params array
     *      - array posts: User or community IDs and post IDs, separated by underscores. Use a negative value to
     *        designate a community ID. Example: "93388_21539,93388_20904,2943_4276,-1_1"
     *      - boolean extended: '1' — to return user and community objects needed to display posts, '0' — no
     *        additional fields are returned (default)
     *      - integer copy_history_depth: Sets the number of parent elements to include in the array 'copy_history'
     *        that is returned if the post is a repost from another wall.
     *      - array fields:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('wall.getById', $params);
    }

    /**
     * Adds a new post on a user wall or community wall. Can also be used to publish suggested or scheduled posts.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - boolean friends_only: '1' — post will be available to friends only, '0' — post will be available
     *        to all users (default)
     *      - boolean from_group: For a community: '1' — post will be published by the community, '0' — post
     *        will be published by the user (default)
     *      - string message: (Required if 'attachments' is not set.) Text of the post.
     *      - array attachments: (Required if 'message' is not set.) List of objects attached to the post, in the
     *        following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media attachment: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, 'page' — wiki-page, 'note' — note,
     *        'poll' — poll, 'album' — photo album, '<owner_id>' — ID of the media application owner. '<media_id>'
     *        — Media application ID. Example: "photo100172_166443618,photo66748_265827614", May contain a link to an
     *        external page to include in the post. Example: "photo66748_265827614,http://habrahabr.ru", "NOTE: If more
     *        than one link is being attached, an error will be thrown."
     *      - string services: List of services or websites the update will be exported to, if the user has so
     *        requested. Sample values: 'twitter', 'facebook'.
     *      - boolean signed: Only for posts in communities with 'from_group' set to '1': '1' — post will be
     *        signed with the name of the posting user, '0' — post will not be signed (default)
     *      - integer publish_date: Publication date (in Unix time). If used, posting will be delayed until the set
     *        time.
     *      - number lat: Geographical latitude of a check-in, in degrees (from -90 to 90).
     *      - number long: Geographical longitude of a check-in, in degrees (from -180 to 180).
     *      - integer place_id: ID of the location where the user was tagged.
     *      - integer post_id: Post ID. Used for publishing of scheduled and suggested posts.
     *      - string guid:
     *      - boolean mark_as_ads:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAdsPublishedException Advertisement post was recently added
     * @throws VKApiWallAddPostException Access to adding post denied
     * @throws VKApiWallTooManyRecipientsException Too many recipients
     * @throws VKApiWallLinksForbiddenException Hyperlinks are forbidden
     * @throws VKApiWallAdsPostLimitReachedException Too many ads posts
     *
     */
    public function post(array $params = array()) {
        return $this->http->post('wall.post', $params);
    }

    /**
     * Reposts (copies) an object to a user wall or community wall.
     *
     *
     * @param $params array
     *      - string object: ID of the object to be reposted on the wall. Example: "wall66748_3675"
     *      - string message: Comment to be added along with the reposted object.
     *      - integer group_id: Target community ID when reposting to a community.
     *      - boolean mark_as_ads:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAdsPublishedException Advertisement post was recently added
     * @throws VKApiWallAddPostException Access to adding post denied
     * @throws VKApiWallAdsPostLimitReachedException Too many ads posts
     *
     */
    public function repost(array $params = array()) {
        return $this->http->post('wall.repost', $params);
    }

    /**
     * Returns information about reposts of a post on user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. By default, current user ID. Use a negative value to
     *        designate a community ID.
     *      - integer post_id: Post ID.
     *      - integer offset: Offset needed to return a specific subset of reposts.
     *      - integer count: Number of reposts to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getReposts(array $params = array()) {
        return $this->http->post('wall.getReposts', $params);
    }

    /**
     * Edits a post on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer post_id: Post ID.
     *      - boolean friends_only: (Applies only when editing a scheduled post.), '1' — post will be available
     *        to friends only, '0' — post will be available to all users (default)
     *      - string message: (Required if 'attachments' is not set.) Text of the post.
     *      - array attachments: (Required if 'message' is not set.) List of objects attached to the post, in the
     *        following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media attachment: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, '<owner_id>' — ID of the media
     *        application owner. '<media_id>' — Media application ID. Example:
     *        "photo100172_166443618,photo66748_265827614", May contain a link to an external page to include in the post.
     *        Example: "photo66748_265827614,http://habrahabr.ru", "NOTE: If more than one link is being attached, an
     *        error is thrown."
     *      - string services: (Applies only to a scheduled post.) List of services or websites where status will
     *        be updated, if the user has so requested. Sample values: 'twitter', 'facebook'.
     *      - boolean signed: (Applies only to a post that was created "as community" on a community wall.), '1'
     *        — to add the signature of the user who created the post
     *      - integer publish_date: (Applies only to a scheduled post.) Publication date (in Unix time). If used,
     *        posting will be delayed until the set time.
     *      - number lat: Geographical latitude of the check-in, in degrees (from -90 to 90).
     *      - number long: Geographical longitude of the check-in, in degrees (from -180 to 180).
     *      - integer place_id: ID of the location where the user was tagged.
     *      - boolean mark_as_ads:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAdsPostLimitReachedException Too many ads posts
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('wall.edit', $params);
    }

    /**
     * Deletes a post from a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer post_id: ID of the post to be deleted.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessPostException Access to wall's post denied
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('wall.delete', $params);
    }

    /**
     * Restores a post deleted from a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID from whose wall the post was deleted. Use a negative value
     *        to designate a community ID.
     *      - integer post_id: ID of the post to be restored.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessPostException Access to wall's post denied
     * @throws VKApiWallAddPostException Access to adding post denied
     *
     */
    public function restore(array $params = array()) {
        return $this->http->post('wall.restore', $params);
    }

    /**
     * Pins the post on wall.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the wall. By default, current user ID. Use a
     *        negative value to designate a community ID.
     *      - integer post_id: Post ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function pin(array $params = array()) {
        return $this->http->post('wall.pin', $params);
    }

    /**
     * Unpins the post on wall.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the wall. By default, current user ID. Use a
     *        negative value to designate a community ID.
     *      - integer post_id: Post ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unpin(array $params = array()) {
        return $this->http->post('wall.unpin', $params);
    }

    /**
     * Returns a list of comments on a post on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer post_id: Post ID.
     *      - boolean need_likes: '1' — to return the 'likes' field, '0' — not to return the 'likes' field
     *        (default)
     *      - integer start_comment_id:
     *      - integer offset: Offset needed to return a specific subset of comments.
     *      - integer count: Number of comments to return (maximum 100).
     *      - WallGetCommentsSort sort: Sort order: 'asc' — chronological, 'desc' — reverse chronological
     * @see WallGetCommentsSort
     *      - integer preview_length: Number of characters at which to truncate comments when previewed. By
     *        default, '90'. Specify '0' if you do not want to truncate comments.
     *      - boolean extended:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessRepliesException Access to post comments denied
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('wall.getComments', $params);
    }

    /**
     * Adds a comment to a post on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer post_id: Post ID.
     *      - integer from_group: Group ID.
     *      - string message: (Required if 'attachments' is not set.) Text of the comment.
     *      - integer reply_to_comment: ID of comment to reply.
     *      - array attachments: (Required if 'message' is not set.) List of media objects attached to the comment,
     *        in the following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media ojbect: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, '<owner_id>' — ID of the media owner.
     *        '<media_id>' — Media ID. For example: "photo100172_166443618,photo66748_265827614"
     *      - integer sticker_id: Sticker ID.
     *      - string guid: Unique identifier to avoid repeated comments.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessAddReplyException Access to status replies denied
     *
     */
    public function createComment(array $params = array()) {
        return $this->http->post('wall.createComment', $params);
    }

    /**
     * Edits a comment on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer comment_id: Comment ID.
     *      - string message: New comment text.
     *      - array attachments: List of objects attached to the comment, in the following format: ,
     *        "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media attachment: 'photo' — photo, 'video'
     *        — video, 'audio' — audio, 'doc' — document, '<owner_id>' — ID of the media attachment owner.
     *        '<media_id>' — Media attachment ID. For example: "photo100172_166443618,photo66748_265827614"
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editComment(array $params = array()) {
        return $this->http->post('wall.editComment', $params);
    }

    /**
     * Deletes a comment on a post on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer comment_id: Comment ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessCommentException Access to wall's comment denied
     *
     */
    public function deleteComment(array $params = array()) {
        return $this->http->post('wall.deleteComment', $params);
    }

    /**
     * Restores a comment deleted from a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer comment_id: Comment ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWallAccessCommentException Access to wall's comment denied
     *
     */
    public function restoreComment(array $params = array()) {
        return $this->http->post('wall.restoreComment', $params);
    }

    /**
     * Reports (submits a complaint about) a post on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the wall.
     *      - integer post_id: Post ID.
     *      - WallReportPostReason reason: Reason for the complaint: '0' – spam, '1' – child pornography, '2'
     *        – extremism, '3' – violence, '4' – drug propaganda, '5' – adult material, '6' – insult, abuse
     * @see WallReportPostReason
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function reportPost(array $params = array()) {
        return $this->http->post('wall.reportPost', $params);
    }

    /**
     * Reports (submits a complaint about) a comment on a post on a user wall or community wall.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the wall.
     *      - integer comment_id: Comment ID.
     *      - WallReportCommentReason reason: Reason for the complaint: '0' – spam, '1' – child pornography,
     *        '2' – extremism, '3' – violence, '4' – drug propaganda, '5' – adult material, '6' – insult, abuse
     * @see WallReportCommentReason
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function reportComment(array $params = array()) {
        return $this->http->post('wall.reportComment', $params);
    }
}
