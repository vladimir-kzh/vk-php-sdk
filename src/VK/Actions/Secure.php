<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessMenuException;
use VK\Exceptions\Api\VKApiAppsAlreadyUnlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiInsufficientFundsException;
use VK\Exceptions\Api\VKApiMobileNotActivatedException;
use VK\Exceptions\VKClientException;

class Secure {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Secure constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns payment balance of the application in hundredth of a vote.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAppBalance(array $params = array()) {
        return $this->http->post('secure.getAppBalance', $params);
    }

    /**
     * Shows history of votes transaction between users and the application.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getTransactionsHistory(array $params = array()) {
        return $this->http->post('secure.getTransactionsHistory', $params);
    }

    /**
     * Shows a list of SMS notifications sent by the application using
     * [vk.com/dev/secure.sendSMSNotification|secure.sendSMSNotification] method.
     *
     *
     * @param $params array
     *      - integer user_id:
     *      - integer date_from: filter by start date. It is set as UNIX-time.
     *      - integer date_to: filter by end date. It is set as UNIX-time.
     *      - integer limit: number of returned posts. By default — 1000.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getSMSHistory(array $params = array()) {
        return $this->http->post('secure.getSMSHistory', $params);
    }

    /**
     * Sends 'SMS' notification to a user's mobile device.
     *
     *
     * @param $params array
     *      - integer user_id: ID of the user to whom SMS notification is sent. The user shall allow the
     *        application to send him/her notifications (, +1).
     *      - string message: 'SMS' text to be sent in 'UTF-8' encoding. Only Latin letters and numbers are
     *        allowed. Maximum size is '160' characters.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiInsufficientFundsException Application has insufficient funds
     * @throws VKApiMobileNotActivatedException The mobile number of the user is unknown
     *
     */
    public function sendSMSNotification(array $params = array()) {
        return $this->http->post('secure.sendSMSNotification', $params);
    }

    /**
     * Sends notification to the user.
     *
     *
     * @param $params array
     *      - array user_ids:
     *      - integer user_id:
     *      - string message: notification text which should be sent in 'UTF-8' encoding ('254' characters
     *        maximum).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function sendNotification(array $params = array()) {
        return $this->http->post('secure.sendNotification', $params);
    }

    /**
     * Sets a counter which is shown to the user in bold in the left menu.
     *
     *
     * @param $params array
     *      - array counters:
     *      - integer user_id:
     *      - integer counter: counter value.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessMenuException Access to the menu of the user denied
     *
     */
    public function setCounter(array $params = array()) {
        return $this->http->post('secure.setCounter', $params);
    }

    /**
     * Sets user game level in the application which can be seen by his/her friends.
     *
     *
     * @param $params array
     *      - array levels:
     *      - integer user_id:
     *      - integer level: level value.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setUserLevel(array $params = array()) {
        return $this->http->post('secure.setUserLevel', $params);
    }

    /**
     * Returns one of the previously set game levels of one or more users in the application.
     *
     *
     * @param $params array
     *      - array user_ids:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUserLevel(array $params = array()) {
        return $this->http->post('secure.getUserLevel', $params);
    }

    /**
     * Adds user activity information to an application
     *
     *
     * @param $params array
     *      - integer user_id: ID of a user to save the data
     *      - integer activity_id: there are 2 default activities: , * 1 – level. Works similar to ,, * 2 –
     *        points, saves points amount, Any other value is for saving completed missions
     *      - integer value: depends on activity_id: * 1 – number, current level number,, * 2 – number, current
     *        user's points amount, , Any other value is ignored
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAppsAlreadyUnlockedException This achievement is already unlocked
     *
     */
    public function addAppEvent(array $params = array()) {
        return $this->http->post('secure.addAppEvent', $params);
    }

    /**
     * Checks the user authentication in 'IFrame' and 'Flash' apps using the 'access_token' parameter.
     *
     *
     * @param $params array
     *      - string token: client 'access_token'
     *      - string ip: user 'ip address'. Note that user may access using the 'ipv6' address, in this case it is
     *        required to transmit the 'ipv6' address. If not transmitted, the address will not be checked.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function checkToken(array $params = array()) {
        return $this->http->post('secure.checkToken', $params);
    }
}
