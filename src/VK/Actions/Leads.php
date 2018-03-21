<?php

namespace VK\Actions;

use VK\Actions\Enums\LeadsGetUsersStatus;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiActionFailedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiLimitsException;
use VK\Exceptions\Api\VKApiParamException;
use VK\Exceptions\Api\VKApiVotesException;
use VK\Exceptions\VKClientException;

class Leads {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Leads constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Completes the lead started by user.
     *
     *
     * @param $params array
     *      - string vk_sid: Session obtained as GET parameter when session started.
     *      - string secret: Secret key from the lead testing interface.
     *      - string comment: Comment text.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     * @throws VKApiVotesException Not enough votes
     *
     */
    public function complete(array $params = array()) {
        return $this->http->post('leads.complete', $params);
    }

    /**
     * Creates new session for the user passing the offer.
     *
     *
     * @param $params array
     *      - integer lead_id: Lead ID.
     *      - string secret: Secret key from the lead testing interface.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function start(array $params = array()) {
        return $this->http->post('leads.start', $params);
    }

    /**
     * Returns lead stats data.
     *
     *
     * @param $params array
     *      - integer lead_id: Lead ID.
     *      - string secret: Secret key obtained from the lead testing interface.
     *      - string date_start: Day to start stats from (YYYY_MM_DD, e.g.2011-09-17).
     *      - string date_end: Day to finish stats (YYYY_MM_DD, e.g.2011-09-17).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getStats(array $params = array()) {
        return $this->http->post('leads.getStats', $params);
    }

    /**
     * Returns a list of last user actions for the offer.
     *
     *
     * @param $params array
     *      - integer offer_id: Offer ID.
     *      - string secret: Secret key obtained in the lead testing interface.
     *      - integer offset: Offset needed to return a specific subset of results.
     *      - integer count: Number of results to return.
     *      - LeadsGetUsersStatus status: Action type. Possible values: *'0' — start,, *'1' — finish,, *'2' —
     *        blocking users,, *'3' — start in a test mode,, *'4' — finish in a test mode.
     * @see LeadsGetUsersStatus
     *      - boolean reverse: Sort order. Possible values: *'1' — chronological,, *'0' — reverse
     *        chronological.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUsers(array $params = array()) {
        return $this->http->post('leads.getUsers', $params);
    }

    /**
     * Checks if the user can start the lead.
     *
     *
     * @param $params array
     *      - integer lead_id: Lead ID.
     *      - integer test_result: Value to be return in 'result' field when test mode is used.
     *      - integer age: User age.
     *      - string country: User country code.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiActionFailedException Unable to process action
     *
     */
    public function checkUser(array $params = array()) {
        return $this->http->post('leads.checkUser', $params);
    }

    /**
     * Counts the metric event.
     *
     *
     * @param $params array
     *      - string data: Metric data obtained in the lead interface.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamException One of the parameters specified was missing or invalid
     *
     */
    public function metricHit(array $params = array()) {
        return $this->http->post('leads.metricHit', $params);
    }
}
