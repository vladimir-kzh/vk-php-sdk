<?php

namespace VK\Actions;

use VK\Actions\Enums\GroupsBanUserReason;
use VK\Actions\Enums\GroupsCreateSubtype;
use VK\Actions\Enums\GroupsCreateType;
use VK\Actions\Enums\GroupsEditAccess;
use VK\Actions\Enums\GroupsEditAgeLimits;
use VK\Actions\Enums\GroupsEditAudio;
use VK\Actions\Enums\GroupsEditDocs;
use VK\Actions\Enums\GroupsEditManagerRole;
use VK\Actions\Enums\GroupsEditMarketCurrency;
use VK\Actions\Enums\GroupsEditPhotos;
use VK\Actions\Enums\GroupsEditSubject;
use VK\Actions\Enums\GroupsEditTopics;
use VK\Actions\Enums\GroupsEditVideo;
use VK\Actions\Enums\GroupsEditWall;
use VK\Actions\Enums\GroupsEditWiki;
use VK\Actions\Enums\GroupsGetInvitedUsersNameCase;
use VK\Actions\Enums\GroupsGetMembersFilter;
use VK\Actions\Enums\GroupsGetMembersSort;
use VK\Actions\Enums\GroupsSearchSort;
use VK\Actions\Enums\GroupsSearchType;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessGroupsException;
use VK\Exceptions\Api\VKApiCommunitiesCatalogDisabledException;
use VK\Exceptions\Api\VKApiCommunitiesCategoriesDisabledException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiGroupChangeCreatorException;
use VK\Exceptions\Api\VKApiGroupNotInClubException;
use VK\Exceptions\Api\VKApiGroupTooManyOfficersException;
use VK\Exceptions\Api\VKApiInvalidAddressException;
use VK\Exceptions\Api\VKApiLimitsException;
use VK\Exceptions\Api\VKApiNotFoundException;
use VK\Exceptions\Api\VKApiParamGroupIdException;
use VK\Exceptions\VKClientException;

class Groups {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Groups constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns information specifying whether a user is a member of a community.
     *
     *
     * @param $params array
     *      - string group_id: ID or screen name of the community.
     *      - integer user_id: User ID.
     *      - array user_ids: User IDs.
     *      - boolean extended: '1' — to return an extended response with additional fields. By default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function isMember(array $params = array()) {
        return $this->http->post('groups.isMember', $params);
    }

    /**
     * Returns information about communities by their IDs.
     *
     *
     * @param $params array
     *      - array group_ids: IDs or screen names of communities.
     *      - string group_id: ID or screen name of the community.
     *      - array fields: Group fields to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('groups.getById', $params);
    }

    /**
     * Returns a list of the communities to which a user belongs.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - boolean extended: '1' — to return complete information about a user's communities, '0' — to
     *        return a list of community IDs without any additional fields (default),
     *      - array filter: Types of communities to return: 'admin' — to return communities administered by the
     *        user , 'editor' — to return communities where the user is an administrator or editor, 'moder' — to
     *        return communities where the user is an administrator, editor, or moderator, 'groups' — to return only
     *        groups, 'publics' — to return only public pages, 'events' — to return only events
     *      - array fields: Profile fields to return.
     *      - integer offset: Offset needed to return a specific subset of communities.
     *      - integer count: Number of communities to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessGroupsException Access to the groups list is denied due to the user's privacy settings
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('groups.get', $params);
    }

    /**
     * Returns a list of community members.
     *
     *
     * @param $params array
     *      - string group_id: ID or screen name of the community.
     *      - GroupsGetMembersSort sort: Sort order. Available values: 'id_asc', 'id_desc', 'time_asc',
     *        'time_desc'. 'time_asc' and 'time_desc' are availavle only if the method is called by the group's
     *        'moderator'.
     * @see GroupsGetMembersSort
     *      - integer offset: Offset needed to return a specific subset of community members.
     *      - integer count: Number of community members to return.
     *      - array fields: List of additional fields to be returned. Available values: 'sex, bdate, city, country,
     *        photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, online,
     *        online_mobile, lists, domain, has_mobile, contacts, connections, site, education, universities, schools,
     *        can_post, can_see_all_posts, can_see_audio, can_write_private_message, status, last_seen, common_count,
     *        relation, relatives, counters'.
     *      - GroupsGetMembersFilter filter: *'friends' – only friends in this community will be returned,,
     *        *'unsure' – only those who pressed 'I may attend' will be returned (if it's an event).
     * @see GroupsGetMembersFilter
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamGroupIdException Invalid group id
     *
     */
    public function getMembers(array $params = array()) {
        return $this->http->post('groups.getMembers', $params);
    }

    /**
     * With this method you can join the group or public page, and also confirm your participation in an event.
     *
     *
     * @param $params array
     *      - integer group_id: ID or screen name of the community.
     *      - string not_sure: Optional parameter which is taken into account when 'gid' belongs to the event: '1'
     *        — Perhaps I will attend, '0' — I will be there for sure (default), ,
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function join(array $params = array()) {
        return $this->http->post('groups.join', $params);
    }

    /**
     * With this method you can leave a group, public page, or event.
     *
     *
     * @param $params array
     *      - integer group_id: ID or screen name of the community.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function leave(array $params = array()) {
        return $this->http->post('groups.leave', $params);
    }

    /**
     * Returns a list of communities matching the search criteria.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - GroupsSearchType type: Community type. Possible values: 'group, page, event.'
     * @see GroupsSearchType
     *      - integer country_id: Country ID.
     *      - integer city_id: City ID. If this parameter is transmitted, country_id is ignored.
     *      - boolean future: '1' — to return only upcoming events. Works with the 'type' = 'event' only.
     *      - boolean market: '1' — to return communities with enabled market only.
     *      - GroupsSearchSort sort: Sort order. Possible values: *'0' — default sorting (similar the full
     *        version of the site),, *'1' — by growth speed,, *'2'— by the "day attendance/members number" ratio,,
     *        *'3' — by the "Likes number/members number" ratio,, *'4' — by the "comments number/members number"
     *        ratio,, *'5' — by the "boards entries number/members number" ratio.
     * @see GroupsSearchSort
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of communities to return. "Note that you can not receive more than first
     *        thousand of results, regardless of 'count' and 'offset' values."
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('groups.search', $params);
    }

    /**
     * Returns communities list for a catalog category.
     *
     *
     * @param $params array
     *      - integer category_id: Category id received from
     *        [vk.com/dev/groups.getCatalogInfo|groups.getCatalogInfo].
     *      - integer subcategory_id: Subcategory id received from
     *        [vk.com/dev/groups.getCatalogInfo|groups.getCatalogInfo].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiCommunitiesCatalogDisabledException Catalog is not available for this user
     * @throws VKApiCommunitiesCategoriesDisabledException Catalog categories are not available for this user
     *
     */
    public function getCatalog(array $params = array()) {
        return $this->http->post('groups.getCatalog', $params);
    }

    /**
     * Returns categories list for communities catalog
     *
     *
     * @param $params array
     *      - boolean extended: 1 – to return communities count and three communities for preview. By default: 0.
     *      - boolean subcategories: 1 – to return subcategories info. By default: 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCatalogInfo(array $params = array()) {
        return $this->http->post('groups.getCatalogInfo', $params);
    }

    /**
     * Returns a list of invitations to join communities and events.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of invitations.
     *      - integer count: Number of invitations to return.
     *      - boolean extended: '1' — to return additional [vk.com/dev/fields_groups|fields] for communities..
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getInvites(array $params = array()) {
        return $this->http->post('groups.getInvites', $params);
    }

    /**
     * Returns invited users list of a community
     *
     *
     * @param $params array
     *      - integer group_id: Group ID to return invited users for.
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of results to return.
     *      - array fields: List of additional fields to be returned. Available values: 'sex, bdate, city, country,
     *        photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, online,
     *        online_mobile, lists, domain, has_mobile, contacts, connections, site, education, universities, schools,
     *        can_post, can_see_all_posts, can_see_audio, can_write_private_message, status, last_seen, common_count,
     *        relation, relatives, counters'.
     *      - GroupsGetInvitedUsersNameCase name_case: Case for declension of user name and surname. Possible
     *        values: *'nom' — nominative (default),, *'gen' — genitive,, *'dat' — dative,, *'acc' — accusative, ,
     *        *'ins' — instrumental,, *'abl' — prepositional.
     * @see GroupsGetInvitedUsersNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getInvitedUsers(array $params = array()) {
        return $this->http->post('groups.getInvitedUsers', $params);
    }

    /**
     * Adds a user to a community blacklist.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer user_id: User ID.
     *      - integer end_date: Date (in Unix time) when the user will be removed from the blacklist.
     *      - GroupsBanUserReason reason: Reason for ban: '1' — spam, '2' — verbal abuse, '3' — strong
     *        language, '4' — irrelevant messages, '0' — other (default)
     * @see GroupsBanUserReason
     *      - string comment: Text of comment to ban.
     *      - boolean comment_visible: '1' — text of comment will be visible to the user,, '0' — text of
     *        comment will be invisible to the user. By default: '0'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function banUser(array $params = array()) {
        return $this->http->post('groups.banUser', $params);
    }

    /**
     * Removes a user from a community blacklist.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unbanUser(array $params = array()) {
        return $this->http->post('groups.unbanUser', $params);
    }

    /**
     * Returns a list of users on a community blacklist.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer offset: Offset needed to return a specific subset of users.
     *      - integer count: Number of users to return.
     *      - array fields:
     *      - integer user_id:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiNotFoundException Not found
     *
     */
    public function getBanned(array $params = array()) {
        return $this->http->post('groups.getBanned', $params);
    }

    /**
     * Creates a new community.
     *
     *
     * @param $params array
     *      - string title: Community title.
     *      - string description: Community description (ignored for 'type' = 'public').
     *      - GroupsCreateType type: Community type. Possible values: *'group' – group,, *'event' – event,,
     *        *'public' – public page
     * @see GroupsCreateType
     *      - integer public_category: Category ID (for 'type' = 'public' only).
     *      - GroupsCreateSubtype subtype: Public page subtype. Possible values: *'1' – place or small business,,
     *        *'2' – company, organization or website,, *'3' – famous person or group of people,, *'4' – product or
     *        work of art.
     * @see GroupsCreateSubtype
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function create(array $params = array()) {
        return $this->http->post('groups.create', $params);
    }

    /**
     * Edits a community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - string title: Community title.
     *      - string description: Community description.
     *      - string screen_name: Community screen name.
     *      - GroupsEditAccess access: Community type. Possible values: *'0' – open,, *'1' – closed,, *'2' –
     *        private.
     * @see GroupsEditAccess
     *      - string website: Website that will be displayed in the community information field.
     *      - GroupsEditSubject subject: Community subject. Possible values: , *'1' – auto/moto,, *'2' –
     *        activity holidays,, *'3' – business,, *'4' – pets,, *'5' – health,, *'6' – dating and communication,
     *        , *'7' – games,, *'8' – IT (computers and software),, *'9' – cinema,, *'10' – beauty and fashion,,
     *        *'11' – cooking,, *'12' – art and culture,, *'13' – literature,, *'14' – mobile services and
     *        internet,, *'15' – music,, *'16' – science and technology,, *'17' – real estate,, *'18' – news and
     *        media,, *'19' – security,, *'20' – education,, *'21' – home and renovations,, *'22' – politics,,
     *        *'23' – food,, *'24' – industry,, *'25' – travel,, *'26' – work,, *'27' – entertainment,, *'28'
     *        – religion,, *'29' – family,, *'30' – sports,, *'31' – insurance,, *'32' – television,, *'33' –
     *        goods and services,, *'34' – hobbies,, *'35' – finance,, *'36' – photo,, *'37' – esoterics,, *'38'
     *        – electronics and appliances,, *'39' – erotic,, *'40' – humor,, *'41' – society, humanities,, *'42'
     *        – design and graphics.
     * @see GroupsEditSubject
     *      - string email: Organizer email (for events).
     *      - string phone: Organizer phone number (for events).
     *      - string rss: RSS feed address for import (available only to communities with special permission.
     *        Contact vk.com/support to get it.
     *      - integer event_start_date: Event start date in Unixtime format.
     *      - integer event_finish_date: Event finish date in Unixtime format.
     *      - integer event_group_id: Organizer community ID (for events only).
     *      - integer public_category: Public page category ID.
     *      - integer public_subcategory: Public page subcategory ID.
     *      - string public_date: Founding date of a company or organization owning the community in "dd.mm.YYYY"
     *        format.
     *      - GroupsEditWall wall: Wall settings. Possible values: *'0' – disabled,, *'1' – open,, *'2' –
     *        limited (groups and events only),, *'3' – closed (groups and events only).
     * @see GroupsEditWall
     *      - GroupsEditTopics topics: Board topics settings. Possbile values: , *'0' – disabled,, *'1' –
     *        open,, *'2' – limited (for groups and events only).
     * @see GroupsEditTopics
     *      - GroupsEditPhotos photos: Photos settings. Possible values: *'0' – disabled,, *'1' – open,, *'2'
     *        – limited (for groups and events only).
     * @see GroupsEditPhotos
     *      - GroupsEditVideo video: Video settings. Possible values: *'0' – disabled,, *'1' – open,, *'2' –
     *        limited (for groups and events only).
     * @see GroupsEditVideo
     *      - GroupsEditAudio audio: Audio settings. Possible values: *'0' – disabled,, *'1' – open,, *'2' –
     *        limited (for groups and events only).
     * @see GroupsEditAudio
     *      - boolean links: Links settings (for public pages only). Possible values: *'0' – disabled,, *'1' –
     *        enabled.
     *      - boolean events: Events settings (for public pages only). Possible values: *'0' – disabled,, *'1'
     *        – enabled.
     *      - boolean places: Places settings (for public pages only). Possible values: *'0' – disabled,, *'1'
     *        – enabled.
     *      - boolean contacts: Contacts settings (for public pages only). Possible values: *'0' – disabled,,
     *        *'1' – enabled.
     *      - GroupsEditDocs docs: Documents settings. Possible values: *'0' – disabled,, *'1' – open,, *'2'
     *        – limited (for groups and events only).
     * @see GroupsEditDocs
     *      - GroupsEditWiki wiki: Wiki pages settings. Possible values: *'0' – disabled,, *'1' – open,, *'2'
     *        – limited (for groups and events only).
     * @see GroupsEditWiki
     *      - boolean messages: Community messages. Possible values: *'0' — disabled,, *'1' — enabled.
     *      - GroupsEditAgeLimits age_limits: Community age limits. Possible values: *'1' — no limits,, *'2' —
     *        16+,, *'3' — 18+.
     * @see GroupsEditAgeLimits
     *      - boolean market: Market settings. Possible values: *'0' – disabled,, *'1' – enabled.
     *      - boolean market_comments: market comments settings. Possible values: *'0' – disabled,, *'1' –
     *        enabled.
     *      - array market_country: Market delivery countries.
     *      - array market_city: Market delivery cities (if only one country is specified).
     *      - GroupsEditMarketCurrency market_currency: Market currency settings. Possbile values: , *'643' –
     *        Russian rubles,, *'980' – Ukrainian hryvnia,, *'398' – Kazakh tenge,, *'978' – Euro,, *'840' – US
     *        dollars
     * @see GroupsEditMarketCurrency
     *      - integer market_contact: Seller contact for market. Set '0' for community messages.
     *      - integer market_wiki: ID of a wiki page with market description.
     *      - boolean obscene_filter: Obscene expressions filter in comments. Possible values: , *'0' –
     *        disabled,, *'1' – enabled.
     *      - boolean obscene_stopwords: Stopwords filter in comments. Possible values: , *'0' – disabled,, *'1'
     *        – enabled.
     *      - array obscene_words: Keywords for stopwords filter.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiInvalidAddressException Invalid screen name
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('groups.edit', $params);
    }

    /**
     * Edits the place in community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - string title: Place title.
     *      - string address: Place address.
     *      - integer country_id: Country ID.
     *      - integer city_id: City ID.
     *      - number latitude: Geographical latitude.
     *      - number longitude: Geographical longitude.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editPlace(array $params = array()) {
        return $this->http->post('groups.editPlace', $params);
    }

    /**
     * Returns community settings.
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
    public function getSettings(array $params = array()) {
        return $this->http->post('groups.getSettings', $params);
    }

    /**
     * Returns a list of requests to the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of results to return.
     *      - array fields: Profile fields to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getRequests(array $params = array()) {
        return $this->http->post('groups.getRequests', $params);
    }

    /**
     * Allows to add, remove or edit the community manager.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer user_id: User ID.
     *      - GroupsEditManagerRole role: Manager role. Possible values: *'moderator',, *'editor',,
     *        *'administrator'.
     * @see GroupsEditManagerRole
     *      - boolean is_contact: '1' — to show the manager in Contacts block of the community.
     *      - string contact_position: Position to show in Contacts block.
     *      - string contact_phone: Contact phone.
     *      - string contact_email: Contact e-mail.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiGroupChangeCreatorException Cannot edit creator role
     * @throws VKApiGroupNotInClubException User should be in club
     * @throws VKApiGroupTooManyOfficersException Too many officers in club
     *
     */
    public function editManager(array $params = array()) {
        return $this->http->post('groups.editManager', $params);
    }

    /**
     * Allows to invite friends to the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function invite(array $params = array()) {
        return $this->http->post('groups.invite', $params);
    }

    /**
     * Allows to add a link to the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - string link: Link URL.
     *      - string text: Description text for the link.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function addLink(array $params = array()) {
        return $this->http->post('groups.addLink', $params);
    }

    /**
     * Allows to delete a link from the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer link_id: Link ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteLink(array $params = array()) {
        return $this->http->post('groups.deleteLink', $params);
    }

    /**
     * Allows to edit a link in the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer link_id: Link ID.
     *      - string text: New description text for the link.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editLink(array $params = array()) {
        return $this->http->post('groups.editLink', $params);
    }

    /**
     * Allows to reorder links in the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer link_id: Link ID.
     *      - integer after: ID of the link after which to place the link with 'link_id'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function reorderLink(array $params = array()) {
        return $this->http->post('groups.reorderLink', $params);
    }

    /**
     * Removes a user from the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function removeUser(array $params = array()) {
        return $this->http->post('groups.removeUser', $params);
    }

    /**
     * Allows to approve join request to the community.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function approveRequest(array $params = array()) {
        return $this->http->post('groups.approveRequest', $params);
    }

    /**
     * Returns Callback API confirmation code for the community.
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
    public function getCallbackConfirmationCode(array $params = array()) {
        return $this->http->post('groups.getCallbackConfirmationCode', $params);
    }

    /**
     * Returns [vk.com/dev/callback_api|Callback API] notifications settings.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer server_id: Server ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCallbackSettings(array $params = array()) {
        return $this->http->post('groups.getCallbackSettings', $params);
    }

    /**
     * Allow to set notifications settings for group.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - integer server_id: Server ID.
     *      - boolean message_new: A new incoming message has been received ('0' — disabled, '1' — enabled).
     *      - boolean message_reply: A new outcoming message has been received ('0' — disabled, '1' — enabled).
     *      - boolean message_allow: Allowed messages notifications ('0' — disabled, '1' — enabled).
     *      - boolean message_deny: Denied messages notifications ('0' — disabled, '1' — enabled).
     *      - boolean photo_new: New photos notifications ('0' — disabled, '1' — enabled).
     *      - boolean audio_new: New audios notifications ('0' — disabled, '1' — enabled).
     *      - boolean video_new: New videos notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_new: New wall replies notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_edit: Wall replies edited notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_delete: A wall comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_restore: A wall comment has been restored ('0' — disabled, '1' — enabled).
     *      - boolean wall_post_new: New wall posts notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_repost: New wall posts notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_new: New board posts notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_edit: Board posts edited notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_restore: Board posts restored notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_delete: Board posts deleted notifications ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_new: New comment to photo notifications ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_edit: A photo comment has been edited ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_delete: A photo comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_restore: A photo comment has been restored ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_new: New comment to video notifications ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_edit: A video comment has been edited ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_delete: A video comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_restore: A video comment has been restored ('0' — disabled, '1' — enabled).
     *      - boolean market_comment_new: New comment to market item notifications ('0' — disabled, '1' —
     *        enabled).
     *      - boolean market_comment_edit: A market comment has been edited ('0' — disabled, '1' — enabled).
     *      - boolean market_comment_delete: A market comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean market_comment_restore: A market comment has been restored ('0' — disabled, '1' —
     *        enabled).
     *      - boolean poll_vote_new: A vote in a public poll has been added ('0' — disabled, '1' — enabled).
     *      - boolean group_join: Joined community notifications ('0' — disabled, '1' — enabled).
     *      - boolean group_leave: Left community notifications ('0' — disabled, '1' — enabled).
     *      - boolean user_block: User added to community blacklist
     *      - boolean user_unblock: User removed from community blacklist
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setCallbackSettings(array $params = array()) {
        return $this->http->post('groups.setCallbackSettings', $params);
    }

    /**
     * Returns the data needed to query a Long Poll server for events
     *
     *
     * @param $params array
     *      - integer group_id: Community ID
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLongPollServer(array $params = array()) {
        return $this->http->post('groups.getLongPollServer', $params);
    }

    /**
     * Returns Long Poll notification settings
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
    public function getLongPollSettings(array $params = array()) {
        return $this->http->post('groups.getLongPollSettings', $params);
    }

    /**
     * Sets Long Poll notification settings
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - boolean enabled: Enable Bots Long Poll ('0' — disabled, '1' — enabled).
     *      - boolean message_new: A new incoming message has been received ('0' — disabled, '1' — enabled).
     *      - boolean message_reply: A new outcoming message has been received ('0' — disabled, '1' — enabled).
     *      - boolean message_edit: A message has been edited ('0' — disabled, '1' — enabled).
     *      - boolean message_allow: Allowed messages notifications ('0' — disabled, '1' — enabled).
     *      - boolean message_deny: Denied messages notifications ('0' — disabled, '1' — enabled).
     *      - boolean photo_new: New photos notifications ('0' — disabled, '1' — enabled).
     *      - boolean audio_new: New audios notifications ('0' — disabled, '1' — enabled).
     *      - boolean video_new: New videos notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_new: New wall replies notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_edit: Wall replies edited notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_delete: A wall comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean wall_reply_restore: A wall comment has been restored ('0' — disabled, '1' — enabled).
     *      - boolean wall_post_new: New wall posts notifications ('0' — disabled, '1' — enabled).
     *      - boolean wall_repost: New wall posts notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_new: New board posts notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_edit: Board posts edited notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_restore: Board posts restored notifications ('0' — disabled, '1' — enabled).
     *      - boolean board_post_delete: Board posts deleted notifications ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_new: New comment to photo notifications ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_edit: A photo comment has been edited ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_delete: A photo comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean photo_comment_restore: A photo comment has been restored ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_new: New comment to video notifications ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_edit: A video comment has been edited ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_delete: A video comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean video_comment_restore: A video comment has been restored ('0' — disabled, '1' — enabled).
     *      - boolean market_comment_new: New comment to market item notifications ('0' — disabled, '1' —
     *        enabled).
     *      - boolean market_comment_edit: A market comment has been edited ('0' — disabled, '1' — enabled).
     *      - boolean market_comment_delete: A market comment has been deleted ('0' — disabled, '1' — enabled).
     *      - boolean market_comment_restore: A market comment has been restored ('0' — disabled, '1' —
     *        enabled).
     *      - boolean poll_vote_new: A vote in a public poll has been added ('0' — disabled, '1' — enabled).
     *      - boolean group_join: Joined community notifications ('0' — disabled, '1' — enabled).
     *      - boolean group_leave: Left community notifications ('0' — disabled, '1' — enabled).
     *      - boolean user_block: User added to community blacklist
     *      - boolean user_unblock: User removed from community blacklist
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setLongPollSettings(array $params = array()) {
        return $this->http->post('groups.setLongPollSettings', $params);
    }
}
