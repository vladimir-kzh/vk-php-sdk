<?php

namespace VK\Actions;

use VK\Actions\Enums\NewsfeedGetBannedNameCase;
use VK\Actions\Enums\NewsfeedIgnoreItemType;
use VK\Actions\Enums\NewsfeedUnignoreItemType;
use VK\Actions\Enums\NewsfeedUnsubscribeType;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiTooManyListsException;
use VK\Exceptions\VKClientException;

class Newsfeed {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Newsfeed constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns data required to show newsfeed for the current user.
     *
     *
     * @param $params array
     *      - array filters: Filters to apply: 'post' — new wall posts, 'photo' — new photos, 'photo_tag' —
     *        new photo tags, 'wall_photo' — new wall photos, 'friend' — new friends, 'note' — new notes
     *      - boolean return_banned: '1' — to return news items from banned sources
     *      - integer start_time: Earliest timestamp (in Unix time) of a news item to return. By default, 24 hours
     *        ago.
     *      - integer end_time: Latest timestamp (in Unix time) of a news item to return. By default, the current
     *        time.
     *      - integer max_photos: Maximum number of photos to return. By default, '5'.
     *      - array source_ids: Sources to obtain news from, separated by commas. User IDs can be specified in
     *        formats '' or 'u' , where '' is the user's friend ID. Community IDs can be specified in formats '-' or 'g' ,
     *        where '' is the community ID. If the parameter is not set, all of the user's friends and communities are
     *        returned, except for banned sources, which can be obtained with the
     *        [vk.com/dev/newsfeed.getBanned|newsfeed.getBanned] method.
     *      - string start_from: identifier required to get the next page of results. Value for this parameter is
     *        returned in 'next_from' field in a reply.
     *      - integer count: Number of news items to return (default 50, maximum 100). For auto feed, you can use
     *        the 'new_offset' parameter returned by this method.
     *      - array fields: Additional fields of [vk.com/dev/fields|profiles] and
     *        [vk.com/dev/fields_groups|communities] to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('newsfeed.get', $params);
    }

    /**
     * , Returns a list of newsfeeds recommended to the current user.
     *
     *
     * @param $params array
     *      - integer start_time: Earliest timestamp (in Unix time) of a news item to return. By default, 24 hours
     *        ago.
     *      - integer end_time: Latest timestamp (in Unix time) of a news item to return. By default, the current
     *        time.
     *      - integer max_photos: Maximum number of photos to return. By default, '5'.
     *      - string start_from: 'new_from' value obtained in previous call.
     *      - integer count: Number of news items to return.
     *      - array fields: Additional fields of [vk.com/dev/fields|profiles] and
     *        [vk.com/dev/fields_groups|communities] to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getRecommended(array $params = array()) {
        return $this->http->post('newsfeed.getRecommended', $params);
    }

    /**
     * Returns a list of comments in the current user's newsfeed.
     *
     *
     * @param $params array
     *      - integer count: Number of comments to return. For auto feed, you can use the 'new_offset' parameter
     *        returned by this method.
     *      - array filters: Filters to apply: 'post' — new comments on wall posts, 'photo' — new comments on
     *        photos, 'video' — new comments on videos, 'topic' — new comments on discussions, 'note' — new comments
     *        on notes,
     *      - string reposts: Object ID, comments on repost of which shall be returned, e.g. 'wall1_45486'. (If the
     *        parameter is set, the 'filters' parameter is optional.),
     *      - integer start_time: Earliest timestamp (in Unix time) of a comment to return. By default, 24 hours
     *        ago.
     *      - integer end_time: Latest timestamp (in Unix time) of a comment to return. By default, the current
     *        time.
     *      - string start_from: Identificator needed to return the next page with results. Value for this
     *        parameter returns in 'next_from' field.
     *      - array fields: Additional fields of [vk.com/dev/fields|profiles] and
     *        [vk.com/dev/fields_groups|communities] to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('newsfeed.getComments', $params);
    }

    /**
     * Returns a list of posts on user walls in which the current user is mentioned.
     *
     *
     * @param $params array
     *      - integer owner_id: Owner ID.
     *      - integer start_time: Earliest timestamp (in Unix time) of a post to return. By default, 24 hours ago.
     *      - integer end_time: Latest timestamp (in Unix time) of a post to return. By default, the current time.
     *      - integer offset: Offset needed to return a specific subset of posts.
     *      - integer count: Number of posts to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getMentions(array $params = array()) {
        return $this->http->post('newsfeed.getMentions', $params);
    }

    /**
     * Returns a list of users and communities banned from the current user's newsfeed.
     *
     *
     * @param $params array
     *      - boolean extended: '1' — return extra information about users and communities
     *      - array fields: Profile fields to return.
     *      - NewsfeedGetBannedNameCase name_case: Case for declension of user name and surname: 'nom' —
     *        nominative (default), 'gen' — genitive , 'dat' — dative, 'acc' — accusative , 'ins' — instrumental ,
     *        'abl' — prepositional
     * @see NewsfeedGetBannedNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getBanned(array $params = array()) {
        return $this->http->post('newsfeed.getBanned', $params);
    }

    /**
     * Prevents news from specified users and communities from appearing in the current user's newsfeed.
     *
     *
     * @param $params array
     *      - array user_ids:
     *      - array group_ids:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function addBan(array $params = array()) {
        return $this->http->post('newsfeed.addBan', $params);
    }

    /**
     * Allows news from previously banned users and communities to be shown in the current user's newsfeed.
     *
     *
     * @param $params array
     *      - array user_ids:
     *      - array group_ids:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteBan(array $params = array()) {
        return $this->http->post('newsfeed.deleteBan', $params);
    }

    /**
     * Hides an item from the newsfeed.
     *
     *
     * @param $params array
     *      - NewsfeedIgnoreItemType type: Item type. Possible values: *'wall' – post on the wall,, *'tag' –
     *        tag on a photo,, *'profilephoto' – profile photo,, *'video' – video,, *'audio' – audio.
     * @see NewsfeedIgnoreItemType
     *      - integer owner_id: Item owner's identifier (user or community), "Note that community id must be
     *        negative. 'owner_id=1' – user , 'owner_id=-1' – community "
     *      - integer item_id: Item identifier
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function ignoreItem(array $params = array()) {
        return $this->http->post('newsfeed.ignoreItem', $params);
    }

    /**
     * Returns a hidden item to the newsfeed.
     *
     *
     * @param $params array
     *      - NewsfeedUnignoreItemType type: Item type. Possible values: *'wall' – post on the wall,, *'tag' –
     *        tag on a photo,, *'profilephoto' – profile photo,, *'video' – video,, *'audio' – audio.
     * @see NewsfeedUnignoreItemType
     *      - integer owner_id: Item owner's identifier (user or community), "Note that community id must be
     *        negative. 'owner_id=1' – user , 'owner_id=-1' – community "
     *      - integer item_id: Item identifier
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unignoreItem(array $params = array()) {
        return $this->http->post('newsfeed.unignoreItem', $params);
    }

    /**
     * Returns search results by statuses.
     *
     *
     * @param $params array
     *      - string q: Search query string (e.g., 'New Year').
     *      - boolean extended: '1' — to return additional information about the user or community that placed
     *        the post.
     *      - integer count: Number of posts to return.
     *      - number latitude: Geographical latitude point (in degrees, -90 to 90) within which to search.
     *      - number longitude: Geographical longitude point (in degrees, -180 to 180) within which to search.
     *      - integer start_time: Earliest timestamp (in Unix time) of a news item to return. By default, 24 hours
     *        ago.
     *      - integer end_time: Latest timestamp (in Unix time) of a news item to return. By default, the current
     *        time.
     *      - string start_from:
     *      - array fields: Additional fields of [vk.com/dev/fields|profiles] and
     *        [vk.com/dev/fields_groups|communities] to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('newsfeed.search', $params);
    }

    /**
     * Returns a list of newsfeeds followed by the current user.
     *
     *
     * @param $params array
     *      - array list_ids: numeric list identifiers.
     *      - boolean extended: Return additional list info
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLists(array $params = array()) {
        return $this->http->post('newsfeed.getLists', $params);
    }

    /**
     * Creates and edits user newsfeed lists
     *
     *
     * @param $params array
     *      - integer list_id: numeric list identifier (if not sent, will be set automatically).
     *      - string title: list name.
     *      - array source_ids: users and communities identifiers to be added to the list. Community identifiers
     *        must be negative numbers.
     *      - boolean no_reposts: reposts display on and off ('1' is for off).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiTooManyListsException Too many feed lists
     *
     */
    public function saveList(array $params = array()) {
        return $this->http->post('newsfeed.saveList', $params);
    }

    /**
     *
     *
     *
     * @param $params array
     *      - integer list_id:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteList(array $params = array()) {
        return $this->http->post('newsfeed.deleteList', $params);
    }

    /**
     * Unsubscribes the current user from specified newsfeeds.
     *
     *
     * @param $params array
     *      - NewsfeedUnsubscribeType type: Type of object from which to unsubscribe: 'note' — note, 'photo' —
     *        photo, 'post' — post on user wall or community wall, 'topic' — topic, 'video' — video
     * @see NewsfeedUnsubscribeType
     *      - integer owner_id: Object owner ID.
     *      - integer item_id: Object ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unsubscribe(array $params = array()) {
        return $this->http->post('newsfeed.unsubscribe', $params);
    }

    /**
     * Returns communities and users that current user is suggested to follow.
     *
     *
     * @param $params array
     *      - integer offset: offset required to choose a particular subset of communities or users.
     *      - integer count: amount of communities or users to return.
     *      - boolean shuffle: shuffle the returned list or not.
     *      - array fields: list of extra fields to be returned. See available fields for [vk.com/dev/fields|users]
     *        and [vk.com/dev/fields_groups|communities].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getSuggestedSources(array $params = array()) {
        return $this->http->post('newsfeed.getSuggestedSources', $params);
    }
}
