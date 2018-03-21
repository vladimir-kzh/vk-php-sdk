<?php

namespace VK\Actions;

use VK\Actions\Enums\MarketGetCommentsSort;
use VK\Actions\Enums\MarketReportCommentReason;
use VK\Actions\Enums\MarketReportReason;
use VK\Actions\Enums\MarketSearchRev;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessMarketException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiMarketAlbumNotFoundException;
use VK\Exceptions\Api\VKApiMarketCommentsClosedException;
use VK\Exceptions\Api\VKApiMarketItemAlreadyAddedException;
use VK\Exceptions\Api\VKApiMarketItemNotFoundException;
use VK\Exceptions\Api\VKApiMarketRestoreTooLateException;
use VK\Exceptions\Api\VKApiMarketTooManyAlbumsException;
use VK\Exceptions\Api\VKApiMarketTooManyItemsException;
use VK\Exceptions\Api\VKApiMarketTooManyItemsInAlbumException;
use VK\Exceptions\VKClientException;

class Market {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Market constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns items list for a community.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community, "Note that community id in the 'owner_id' parameter
     *        should be negative number. For example 'owner_id'=-1 matches the [vk.com/apiclub|VK API] community "
     *      - integer count: Number of items to return.
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - boolean extended: '1' – method will return additional fields: 'likes, can_comment, car_repost,
     *        photos'. These parameters are not returned by default.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('market.get', $params);
    }

    /**
     * Returns information about market items by their ids.
     *
     *
     * @param $params array
     *      - array item_ids: Comma-separated ids list: {user id}_{item id}. If an item belongs to a community
     *        -{community id} is used. " 'Videos' value example: , '-4363_136089719,13245770_137352259'"
     *      - boolean extended: '1' – to return additional fields: 'likes, can_comment, car_repost, photos'. By
     *        default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('market.getById', $params);
    }

    /**
     * Searches market items in a community's catalog
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an items owner community.
     *      - string q: Search query, for example "pink slippers".
     *      - integer price_from: Minimum item price value.
     *      - integer price_to: Maximum item price value.
     *      - array tags: Comma-separated tag IDs list.
     *      - MarketSearchRev rev: '0' — do not use reverse order, '1' — use reverse order
     * @see MarketSearchRev
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of items to return.
     *      - boolean extended: '1' – to return additional fields: 'likes, can_comment, car_repost, photos'. By
     *        default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('market.search', $params);
    }

    /**
     * Returns community's collections list.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an items owner community.
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of items to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAlbums(array $params = array()) {
        return $this->http->post('market.getAlbums', $params);
    }

    /**
     * Returns items album's data
     *
     *
     * @param $params array
     *      - integer owner_id: identifier of an album owner community, "Note that community id in the 'owner_id'
     *        parameter should be negative number. For example 'owner_id'=-1 matches the [vk.com/apiclub|VK API] community
     *        "
     *      - array album_ids: collections identifiers to obtain data from
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAlbumById(array $params = array()) {
        return $this->http->post('market.getAlbumById', $params);
    }

    /**
     * Creates a new comment for an item.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Item ID.
     *      - string message: Comment text (required if 'attachments' parameter is not specified)
     *      - array attachments: Comma-separated list of objects attached to a comment. The field is submitted the
     *        following way: , "'<owner_id>_<media_id>,<owner_id>_<media_id>'", , '' - media attachment type: "'photo' -
     *        photo, 'video' - video, 'audio' - audio, 'doc' - document", , '<owner_id>' - media owner id, '<media_id>' -
     *        media attachment id, , For example: "photo100172_166443618,photo66748_265827614",
     *      - boolean from_group: '1' - comment will be published on behalf of a community, '0' - on behalf of a
     *        user (by default).
     *      - integer reply_to_comment: ID of a comment to reply with current comment to.
     *      - integer sticker_id: Sticker ID.
     *      - string guid: Random value to avoid resending one comment.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function createComment(array $params = array()) {
        return $this->http->post('market.createComment', $params);
    }

    /**
     * Returns comments list for an item.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community
     *      - integer item_id: Item ID.
     *      - boolean need_likes: '1' — to return likes info.
     *      - integer start_comment_id: ID of a comment to start a list from (details below).
     *      - integer count: Number of results to return.
     *      - MarketGetCommentsSort sort: Sort order ('asc' — from old to new, 'desc' — from new to old)
     * @see MarketGetCommentsSort
     *      - boolean extended: '1' — comments will be returned as numbered objects, in addition lists of
     *        'profiles' and 'groups' objects will be returned.
     *      - array fields: List of additional profile fields to return. See the [vk.com/dev/fields|details]
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMarketCommentsClosedException Comments for this market are closed
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('market.getComments', $params);
    }

    /**
     * Deletes an item's comment
     *
     *
     * @param $params array
     *      - integer owner_id: identifier of an item owner community, "Note that community id in the 'owner_id'
     *        parameter should be negative number. For example 'owner_id'=-1 matches the [vk.com/apiclub|VK API] community
     *        "
     *      - integer comment_id: comment id
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteComment(array $params = array()) {
        return $this->http->post('market.deleteComment', $params);
    }

    /**
     * Restores a recently deleted comment
     *
     *
     * @param $params array
     *      - integer owner_id: identifier of an item owner community, "Note that community id in the 'owner_id'
     *        parameter should be negative number. For example 'owner_id'=-1 matches the [vk.com/apiclub|VK API] community
     *        "
     *      - integer comment_id: deleted comment id
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function restoreComment(array $params = array()) {
        return $this->http->post('market.restoreComment', $params);
    }

    /**
     * Chages item comment's text
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer comment_id: Comment ID.
     *      - string message: New comment text (required if 'attachments' are not specified), , 2048 symbols
     *        maximum.
     *      - array attachments: Comma-separated list of objects attached to a comment. The field is submitted the
     *        following way: , "'<owner_id>_<media_id>,<owner_id>_<media_id>'", , '' - media attachment type: "'photo' -
     *        photo, 'video' - video, 'audio' - audio, 'doc' - document", , '<owner_id>' - media owner id, '<media_id>' -
     *        media attachment id, , For example: "photo100172_166443618,photo66748_265827614",
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editComment(array $params = array()) {
        return $this->http->post('market.editComment', $params);
    }

    /**
     * Sends a complaint to the item's comment.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer comment_id: Comment ID.
     *      - MarketReportCommentReason reason: Complaint reason. Possible values: *'0' — spam,, *'1' — child
     *        porn,, *'2' — extremism,, *'3' — violence,, *'4' — drugs propaganda,, *'5' — adult materials,, *'6'
     *        — insult.
     * @see MarketReportCommentReason
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function reportComment(array $params = array()) {
        return $this->http->post('market.reportComment', $params);
    }

    /**
     * Returns a list of market categories.
     *
     *
     * @param $params array
     *      - integer count: Number of results to return.
     *      - integer offset: Offset needed to return a specific subset of results.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCategories(array $params = array()) {
        return $this->http->post('market.getCategories', $params);
    }

    /**
     * Sends a complaint to the item.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Item ID.
     *      - MarketReportReason reason: Complaint reason. Possible values: *'0' — spam,, *'1' — child porn,,
     *        *'2' — extremism,, *'3' — violence,, *'4' — drugs propaganda,, *'5' — adult materials,, *'6' —
     *        insult.
     * @see MarketReportReason
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function report(array $params = array()) {
        return $this->http->post('market.report', $params);
    }

    /**
     * Ads a new item to the market.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - string name: Item name.
     *      - string description: Item description.
     *      - integer category_id: Item category ID.
     *      - number price: Item price.
     *      - boolean deleted: Item status ('1' — deleted, '0' — not deleted).
     *      - integer main_photo_id: Cover photo ID.
     *      - array photo_ids: IDs of additional photos.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMarketException Access denied
     * @throws VKApiMarketTooManyItemsException Too many items
     *
     */
    public function add(array $params = array()) {
        return $this->http->post('market.add', $params);
    }

    /**
     * Edits an item.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Item ID.
     *      - string name: Item name.
     *      - string description: Item description.
     *      - integer category_id: Item category ID.
     *      - number price: Item price.
     *      - boolean deleted: Item status ('1' — deleted, '0' — not deleted).
     *      - integer main_photo_id: Cover photo ID.
     *      - array photo_ids: IDs of additional photos.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMarketException Access denied
     * @throws VKApiMarketItemNotFoundException Item not found
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('market.edit', $params);
    }

    /**
     * Deletes an item.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Item ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMarketException Access denied
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('market.delete', $params);
    }

    /**
     * Restores recently deleted item
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Deleted item ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMarketException Access denied
     * @throws VKApiMarketRestoreTooLateException Too late for restore
     *
     */
    public function restore(array $params = array()) {
        return $this->http->post('market.restore', $params);
    }

    /**
     * Changes item place in a collection.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer album_id: ID of a collection to reorder items in. Set 0 to reorder full items list.
     *      - integer item_id: Item ID.
     *      - integer before: ID of an item to place current item before it.
     *      - integer after: ID of an item to place current item after it.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMarketException Access denied
     * @throws VKApiMarketAlbumNotFoundException Album not found
     * @throws VKApiMarketItemNotFoundException Item not found
     *
     */
    public function reorderItems(array $params = array()) {
        return $this->http->post('market.reorderItems', $params);
    }

    /**
     * Reorders the collections list.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer album_id: Collection ID.
     *      - integer before: ID of a collection to place current collection before it.
     *      - integer after: ID of a collection to place current collection after it.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMarketException Access denied
     * @throws VKApiMarketAlbumNotFoundException Album not found
     *
     */
    public function reorderAlbums(array $params = array()) {
        return $this->http->post('market.reorderAlbums', $params);
    }

    /**
     * Creates new collection of items
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - string title: Collection title.
     *      - integer photo_id: Cover photo ID.
     *      - boolean main_album: Set as main ('1' – set, '0' – no).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMarketTooManyAlbumsException Too many albums
     *
     */
    public function addAlbum(array $params = array()) {
        return $this->http->post('market.addAlbum', $params);
    }

    /**
     * Edits a collection of items
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an collection owner community.
     *      - integer album_id: Collection ID.
     *      - string title: Collection title.
     *      - integer photo_id: Cover photo id
     *      - boolean main_album: Set as main ('1' – set, '0' – no).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMarketAlbumNotFoundException Album not found
     *
     */
    public function editAlbum(array $params = array()) {
        return $this->http->post('market.editAlbum', $params);
    }

    /**
     * Deletes a collection of items.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an collection owner community.
     *      - integer album_id: Collection ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMarketAlbumNotFoundException Album not found
     *
     */
    public function deleteAlbum(array $params = array()) {
        return $this->http->post('market.deleteAlbum', $params);
    }

    /**
     * Removes an item from one or multiple collections.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Item ID.
     *      - array album_ids: Collections IDs to remove item from.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMarketAlbumNotFoundException Album not found
     * @throws VKApiMarketItemNotFoundException Item not found
     *
     */
    public function removeFromAlbum(array $params = array()) {
        return $this->http->post('market.removeFromAlbum', $params);
    }

    /**
     * Adds an item to one or multiple collections.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of an item owner community.
     *      - integer item_id: Item ID.
     *      - array album_ids: Collections IDs to add item to.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMarketAlbumNotFoundException Album not found
     * @throws VKApiMarketItemNotFoundException Item not found
     * @throws VKApiMarketTooManyItemsInAlbumException Too many items in album
     * @throws VKApiMarketItemAlreadyAddedException Item already added to album
     *
     */
    public function addToAlbum(array $params = array()) {
        return $this->http->post('market.addToAlbum', $params);
    }
}
