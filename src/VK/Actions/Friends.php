<?php

namespace VK\Actions;

use VK\Actions\Enums\FriendsGetAvailableForCallNameCase;
use VK\Actions\Enums\FriendsGetNameCase;
use VK\Actions\Enums\FriendsGetOrder;
use VK\Actions\Enums\FriendsGetRequestsSort;
use VK\Actions\Enums\FriendsGetSuggestionsNameCase;
use VK\Actions\Enums\FriendsSearchNameCase;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiFriendsAddEnemyException;
use VK\Exceptions\Api\VKApiFriendsAddInEnemyException;
use VK\Exceptions\Api\VKApiFriendsAddYourselfException;
use VK\Exceptions\Api\VKApiFriendsListIdException;
use VK\Exceptions\Api\VKApiFriendsListLimitException;
use VK\Exceptions\VKClientException;

class Friends {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Friends constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of user IDs or detailed information about a user's friends.
     *
     *
     * @param $params array
     *      - integer user_id: User ID. By default, the current user ID.
     *      - FriendsGetOrder order: Sort order: , 'name' — by name (enabled only if the 'fields' parameter is
     *        used), 'hints' — by rating, similar to how friends are sorted in My friends section, , This parameter is
     *        available only for [vk.com/dev/standalone|desktop applications].
     * @see FriendsGetOrder
     *      - integer list_id: ID of the friend list returned by the [vk.com/dev/friends.getLists|friends.getLists]
     *        method to be used as the source. This parameter is taken into account only when the uid parameter is set to
     *        the current user ID. This parameter is available only for [vk.com/dev/standalone|desktop applications].
     *      - integer count: Number of friends to return.
     *      - integer offset: Offset needed to return a specific subset of friends.
     *      - array fields: Profile fields to return. Sample values: 'uid', 'first_name', 'last_name', 'nickname',
     *        'sex', 'bdate' (birthdate), 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'domain',
     *        'has_mobile', 'rate', 'contacts', 'education'.
     *      - FriendsGetNameCase name_case: Case for declension of user name and surname: , 'nom' — nominative
     *        (default) , 'gen' — genitive , 'dat' — dative , 'acc' — accusative , 'ins' — instrumental , 'abl'
     *        — prepositional
     * @see FriendsGetNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('friends.get', $params);
    }

    /**
     * Returns a list of user IDs of a user's friends who are online.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - integer list_id: Friend list ID. If this parameter is not set, information about all online friends
     *        is returned.
     *      - boolean online_mobile: '1' — to return an additional 'online_mobile' field, '0' — (default),
     *      - string order: Sort order: 'random' — random order
     *      - integer count: Number of friends to return.
     *      - integer offset: Offset needed to return a specific subset of friends.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getOnline(array $params = array()) {
        return $this->http->post('friends.getOnline', $params);
    }

    /**
     * Returns a list of user IDs of the mutual friends of two users.
     *
     *
     * @param $params array
     *      - integer source_uid: ID of the user whose friends will be checked against the friends of the user
     *        specified in 'target_uid'.
     *      - integer target_uid: ID of the user whose friends will be checked against the friends of the user
     *        specified in 'source_uid'.
     *      - array target_uids: IDs of the users whose friends will be checked against the friends of the user
     *        specified in 'source_uid'.
     *      - string order: Sort order: 'random' — random order
     *      - integer count: Number of mutual friends to return.
     *      - integer offset: Offset needed to return a specific subset of mutual friends.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getMutual(array $params = array()) {
        return $this->http->post('friends.getMutual', $params);
    }

    /**
     * Returns a list of user IDs of the current user's recently added friends.
     *
     *
     * @param $params array
     *      - integer count: Number of recently added friends to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getRecent(array $params = array()) {
        return $this->http->post('friends.getRecent', $params);
    }

    /**
     * Returns information about the current user's incoming and outgoing friend requests.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of friend requests.
     *      - integer count: Number of friend requests to return (default 100, maximum 1000).
     *      - boolean extended: '1' — to return response messages from users who have sent a friend request or,
     *        if 'suggested' is set to '1', to return a list of suggested friends
     *      - boolean need_mutual: '1' — to return a list of mutual friends (up to 20), if any
     *      - boolean out: '1' — to return outgoing requests, '0' — to return incoming requests (default)
     *      - FriendsGetRequestsSort sort: Sort order: '1' — by number of mutual friends, '0' — by date
     * @see FriendsGetRequestsSort
     *      - boolean suggested: '1' — to return a list of suggested friends, '0' — to return friend requests
     *        (default)
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getRequests(array $params = array()) {
        return $this->http->post('friends.getRequests', $params);
    }

    /**
     * Approves or creates a friend request.
     *
     *
     * @param $params array
     *      - integer user_id: ID of the user whose friend request will be approved or to whom a friend request
     *        will be sent.
     *      - string text: Text of the message (up to 500 characters) for the friend request, if any.
     *      - boolean follow: '1' to pass an incoming request to followers list.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiFriendsAddInEnemyException Cannot add this user to friends as they have put you on their blacklist
     * @throws VKApiFriendsAddEnemyException Cannot add this user to friends as you put him on blacklist
     * @throws VKApiFriendsAddYourselfException Cannot add user himself as friend
     *
     */
    public function add(array $params = array()) {
        return $this->http->post('friends.add', $params);
    }

    /**
     * Edits the friend lists of the selected user.
     *
     *
     * @param $params array
     *      - integer user_id: ID of the user whose friend list is to be edited.
     *      - array list_ids: IDs of the friend lists to which to add the user.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('friends.edit', $params);
    }

    /**
     * Declines a friend request or deletes a user from the current user's friend list.
     *
     *
     * @param $params array
     *      - integer user_id: ID of the user whose friend request is to be declined or who is to be deleted from
     *        the current user's friend list.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('friends.delete', $params);
    }

    /**
     * Returns a list of the user's friend lists.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - boolean return_system: '1' — to return system friend lists. By default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLists(array $params = array()) {
        return $this->http->post('friends.getLists', $params);
    }

    /**
     * Creates a new friend list for the current user.
     *
     *
     * @param $params array
     *      - string name: Name of the friend list.
     *      - array user_ids: IDs of users to be added to the friend list.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiFriendsListLimitException Reached the maximum number of lists
     *
     */
    public function addList(array $params = array()) {
        return $this->http->post('friends.addList', $params);
    }

    /**
     * Edits a friend list of the current user.
     *
     *
     * @param $params array
     *      - string name: Name of the friend list.
     *      - integer list_id: Friend list ID.
     *      - array user_ids: IDs of users in the friend list.
     *      - array add_user_ids: (Applies if 'user_ids' parameter is not set.), User IDs to add to the friend
     *        list.
     *      - array delete_user_ids: (Applies if 'user_ids' parameter is not set.), User IDs to delete from the
     *        friend list.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiFriendsListIdException Invalid list id
     *
     */
    public function editList(array $params = array()) {
        return $this->http->post('friends.editList', $params);
    }

    /**
     * Deletes a friend list of the current user.
     *
     *
     * @param $params array
     *      - integer list_id: ID of the friend list to delete.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiFriendsListIdException Invalid list id
     *
     */
    public function deleteList(array $params = array()) {
        return $this->http->post('friends.deleteList', $params);
    }

    /**
     * Returns a list of IDs of the current user's friends who installed the application.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAppUsers(array $params = array()) {
        return $this->http->post('friends.getAppUsers', $params);
    }

    /**
     * Returns a list of the current user's friends whose phone numbers, validated or specified in a profile, are in a
     * given list.
     *
     *
     * @param $params array
     *      - array phones: List of phone numbers in MSISDN format (maximum 1000). Example:
     *        "+79219876543,+79111234567"
     *      - array fields: Profile fields to return. Sample values: 'nickname', 'screen_name', 'sex', 'bdate'
     *        (birthdate), 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'has_mobile', 'rate',
     *        'contacts', 'education', 'online, counters'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getByPhones(array $params = array()) {
        return $this->http->post('friends.getByPhones', $params);
    }

    /**
     * Marks all incoming friend requests as viewed.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteAllRequests(array $params = array()) {
        return $this->http->post('friends.deleteAllRequests', $params);
    }

    /**
     * Returns a list of profiles of users whom the current user may know.
     *
     *
     * @param $params array
     *      - array filter: Types of potential friends to return: 'mutual' — users with many mutual friends ,
     *        'contacts' — users found with the [vk.com/dev/account.importContacts|account.importContacts] method ,
     *        'mutual_contacts' — users who imported the same contacts as the current user with the
     *        [vk.com/dev/account.importContacts|account.importContacts] method
     *      - integer count: Number of suggestions to return.
     *      - integer offset: Offset needed to return a specific subset of suggestions.
     *      - array fields: Profile fields to return. Sample values: 'nickname', 'screen_name', 'sex', 'bdate'
     *        (birthdate), 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'has_mobile', 'rate',
     *        'contacts', 'education', 'online', 'counters'.
     *      - FriendsGetSuggestionsNameCase name_case: Case for declension of user name and surname: , 'nom' —
     *        nominative (default) , 'gen' — genitive , 'dat' — dative , 'acc' — accusative , 'ins' — instrumental
     *        , 'abl' — prepositional
     * @see FriendsGetSuggestionsNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getSuggestions(array $params = array()) {
        return $this->http->post('friends.getSuggestions', $params);
    }

    /**
     * Checks the current user's friendship status with other specified users.
     *
     *
     * @param $params array
     *      - array user_ids: IDs of the users whose friendship status to check.
     *      - boolean need_sign: '1' — to return 'sign' field. 'sign' is
     *        md5("{id}_{user_id}_{friends_status}_{application_secret}"), where id is current user ID. This field allows
     *        to check that data has not been modified by the client. By default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function areFriends(array $params = array()) {
        return $this->http->post('friends.areFriends', $params);
    }

    /**
     * Returns a list of friends who can be called by the current user.
     *
     *
     * @param $params array
     *      - array fields: Profile fields to return. Sample values: 'uid', 'first_name', 'last_name', 'nickname',
     *        'sex', 'bdate' (birthdate), 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'domain',
     *        'has_mobile', 'rate', 'contacts', 'education'.
     *      - FriendsGetAvailableForCallNameCase name_case: Case for declension of user name and surname: , 'nom'
     *        — nominative (default) , 'gen' — genitive , 'dat' — dative , 'acc' — accusative , 'ins' —
     *        instrumental , 'abl' — prepositional
     * @see FriendsGetAvailableForCallNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAvailableForCall(array $params = array()) {
        return $this->http->post('friends.getAvailableForCall', $params);
    }

    /**
     * Returns a list of friends matching the search criteria.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - string q: Search query string (e.g., 'Vasya Babich').
     *      - array fields: Profile fields to return. Sample values: 'nickname', 'screen_name', 'sex', 'bdate'
     *        (birthdate), 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'has_mobile', 'rate',
     *        'contacts', 'education', 'online',
     *      - FriendsSearchNameCase name_case: Case for declension of user name and surname: 'nom' — nominative
     *        (default), 'gen' — genitive , 'dat' — dative, 'acc' — accusative , 'ins' — instrumental , 'abl' —
     *        prepositional
     * @see FriendsSearchNameCase
     *      - integer offset: Offset needed to return a specific subset of friends.
     *      - integer count: Number of friends to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('friends.search', $params);
    }
}
