<?php

namespace VK\Actions;

use VK\Actions\Enums\AccountLookupContactsService;
use VK\Actions\Enums\AccountSaveProfileInfoBdateVisibility;
use VK\Actions\Enums\AccountSaveProfileInfoRelation;
use VK\Actions\Enums\AccountSaveProfileInfoSex;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessMenuException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiInvalidAddressException;
use VK\Exceptions\VKClientException;

class Account {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Account constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns non-null values of user counters.
     *
     *
     * @param $params array
     *      - array filter: Counters to be returned.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCounters(array $params = array()) {
        return $this->http->post('account.getCounters', $params);
    }

    /**
     * Sets an application screen name (up to 17 characters), that is shown to the user in the left menu.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - string name: Application screen name.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMenuException Access to the menu of the user denied
     *
     */
    public function setNameInMenu(array $params = array()) {
        return $this->http->post('account.setNameInMenu', $params);
    }

    /**
     * Marks the current user as online for 15 minutes.
     *
     *
     * @param $params array
     *      - boolean voip: '1' if videocalls are available for current device.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setOnline(array $params = array()) {
        return $this->http->post('account.setOnline', $params);
    }

    /**
     * Marks a current user as offline.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setOffline(array $params = array()) {
        return $this->http->post('account.setOffline', $params);
    }

    /**
     * Allows to search the VK users using phone numbers, e-mail addresses and user IDs on other services.
     *
     *
     * @param $params array
     *      - array contacts: List of contacts separated with commas
     *      - AccountLookupContactsService service: String identifier of a service which contacts are used for
     *        searching. Possible values: , * email, * phone, * twitter, * facebook, * odnoklassniki, * instagram, *
     *        google
     * @see AccountLookupContactsService
     *      - string mycontact: Contact of a current user on a specified service
     *      - boolean return_all: '1' – also return contacts found using this service before, '0' – return only
     *        contacts found using 'contacts' field.
     *      - array fields: Profile fields to return. Possible values: 'nickname, domain, sex, bdate, city,
     *        country, timezone, photo_50, photo_100, photo_200_orig, has_mobile, contacts, education, online, relation,
     *        last_seen, status, can_write_private_message, can_see_all_posts, can_post, universities'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function lookupContacts(array $params = array()) {
        return $this->http->post('account.lookupContacts', $params);
    }

    /**
     * Subscribes an iOS/Android/Windows Phone-based device to receive push notifications
     *
     *
     * @param $params array
     *      - string token: Device token used to send notifications. (for mpns, the token shall be URL for sending
     *        of notifications)
     *      - string device_model: String name of device model.
     *      - integer device_year: Device year.
     *      - string device_id: Unique device ID.
     *      - string system_version: String version of device operating system.
     *      - string settings: Push settings in a [vk.com/dev/push_settings|special format].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function registerDevice(array $params = array()) {
        return $this->http->post('account.registerDevice', $params);
    }

    /**
     * Unsubscribes a device from push notifications.
     *
     *
     * @param $params array
     *      - string device_id: Unique device ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unregisterDevice(array $params = array()) {
        return $this->http->post('account.unregisterDevice', $params);
    }

    /**
     * Mutes push notifications for the set period of time.
     *
     *
     * @param $params array
     *      - string device_id: Unique device ID.
     *      - integer time: Time in seconds for what notifications should be disabled. '-1' to disable forever.
     *      - integer peer_id: Destination ID. "For user: 'User ID', e.g. '12345'. For chat: '2000000000' + 'Chat
     *        ID', e.g. '2000000001'. For community: '- Community ID', e.g. '-12345'. "
     *      - integer sound: '1' — to enable sound in this dialog, '0' — to disable sound. Only if 'peer_id'
     *        contains user or community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setSilenceMode(array $params = array()) {
        return $this->http->post('account.setSilenceMode', $params);
    }

    /**
     * Gets settings of push notifications.
     *
     *
     * @param $params array
     *      - string device_id: Unique device ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getPushSettings(array $params = array()) {
        return $this->http->post('account.getPushSettings', $params);
    }

    /**
     * Change push settings.
     *
     *
     * @param $params array
     *      - string device_id: Unique device ID.
     *      - string settings: Push settings in a [vk.com/dev/push_settings|special format].
     *      - string key: Notification key.
     *      - array value: New value for the key in a [vk.com/dev/push_settings|special format].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setPushSettings(array $params = array()) {
        return $this->http->post('account.setPushSettings', $params);
    }

    /**
     * Gets settings of the user in this application.
     *
     *
     * @param $params array
     *      - integer user_id: User ID whose settings information shall be got. By default: current user.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAppPermissions(array $params = array()) {
        return $this->http->post('account.getAppPermissions', $params);
    }

    /**
     * Returns a list of active ads (offers) which executed by the user will bring him/her respective number of votes
     * to his balance in the application.
     *
     *
     * @param $params array
     *      - integer count: Number of results to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getActiveOffers(array $params = array()) {
        return $this->http->post('account.getActiveOffers', $params);
    }

    /**
     * Adds user to the banlist.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function banUser(array $params = array()) {
        return $this->http->post('account.banUser', $params);
    }

    /**
     * Deletes user from the blacklist.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function unbanUser(array $params = array()) {
        return $this->http->post('account.unbanUser', $params);
    }

    /**
     * Returns a user's blacklist.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of results to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getBanned(array $params = array()) {
        return $this->http->post('account.getBanned', $params);
    }

    /**
     * Returns current account info.
     *
     *
     * @param $params array
     *      - array fields: Fields to return. Possible values: *'country' — user country,, *'https_required' —
     *        is "HTTPS only" option enabled,, *'own_posts_default' — is "Show my posts only" option is enabled,,
     *        *'no_wall_replies' — are wall replies disabled or not,, *'intro' — is intro passed by user or not,,
     *        *'lang' — user language. By default: all.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getInfo(array $params = array()) {
        return $this->http->post('account.getInfo', $params);
    }

    /**
     * Allows to edit the current account info.
     *
     *
     * @param $params array
     *      - string name: Setting name.
     *      - string value: Setting value.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setInfo(array $params = array()) {
        return $this->http->post('account.setInfo', $params);
    }

    /**
     * Changes a user password after access is successfully restored with the [vk.com/dev/auth.restore|auth.restore]
     * method.
     *
     *
     * @param $params array
     *      - string restore_sid: Session id received after the [vk.com/dev/auth.restore|auth.restore] method is
     *        executed. (If the password is changed right after the access was restored)
     *      - string change_password_hash: Hash received after a successful OAuth authorization with a code got by
     *        SMS. (If the password is changed right after the access was restored)
     *      - string old_password: Current user password.
     *      - string new_password: New password that will be set as a current
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function changePassword(array $params = array()) {
        return $this->http->post('account.changePassword', $params);
    }

    /**
     * Returns the current account info.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getProfileInfo(array $params = array()) {
        return $this->http->post('account.getProfileInfo', $params);
    }

    /**
     * Edits current profile info.
     *
     *
     * @param $params array
     *      - string first_name: User first name.
     *      - string last_name: User last name.
     *      - string maiden_name: User maiden name (female only)
     *      - string screen_name: User screen name.
     *      - integer cancel_request_id: ID of the name change request to be canceled. If this parameter is sent,
     *        all the others are ignored.
     *      - AccountSaveProfileInfoSex sex: User sex. Possible values: , * '1' – female,, * '2' – male.
     * @see AccountSaveProfileInfoSex
     *      - AccountSaveProfileInfoRelation relation: User relationship status. Possible values: , * '1' –
     *        single,, * '2' – in a relationship,, * '3' – engaged,, * '4' – married,, * '5' – it's complicated,,
     *        * '6' – actively searching,, * '7' – in love,, * '0' – not specified.
     * @see AccountSaveProfileInfoRelation
     *      - integer relation_partner_id: ID of the relationship partner.
     *      - string bdate: User birth date, format: DD.MM.YYYY.
     *      - AccountSaveProfileInfoBdateVisibility bdate_visibility: Birth date visibility. Returned values: , *
     *        '1' – show birth date,, * '2' – show only month and day,, * '0' – hide birth date.
     * @see AccountSaveProfileInfoBdateVisibility
     *      - string home_town: User home town.
     *      - integer country_id: User country.
     *      - integer city_id: User city.
     *      - string status: Status text.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiInvalidAddressException Invalid screen name
     *
     */
    public function saveProfileInfo(array $params = array()) {
        return $this->http->post('account.saveProfileInfo', $params);
    }
}
