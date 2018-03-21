<?php

namespace VK\Actions;

use VK\Actions\Enums\OrdersChangeStateAction;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiActionFailedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiLimitsException;
use VK\Exceptions\Api\VKApiParamException;
use VK\Exceptions\VKClientException;

class Orders {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Orders constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of orders.
     *
     *
     * @param $params array
     *      - integer count: number of returned orders.
     *      - boolean test_mode: if this parameter is set to 1, this method returns a list of test mode orders. By
     *        default — 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('orders.get', $params);
    }

    /**
     * Returns information about orders by their IDs.
     *
     *
     * @param $params array
     *      - integer order_id: order ID.
     *      - array order_ids: order IDs (when information about several orders is requested).
     *      - boolean test_mode: if this parameter is set to 1, this method returns a list of test mode orders. By
     *        default — 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('orders.getById', $params);
    }

    /**
     * Changes order status.
     *
     *
     * @param $params array
     *      - integer order_id: order ID.
     *      - OrdersChangeStateAction action: action to be done with the order. Available actions: *cancel — to
     *        cancel unconfirmed order. *charge — to confirm unconfirmed order. Applies only if processing of
     *        [vk.com/dev/payments_status|order_change_state] notification failed. *refund — to cancel confirmed order.
     * @see OrdersChangeStateAction
     *      - integer app_order_id: internal ID of the order in the application.
     *      - boolean test_mode: if this parameter is set to 1, this method returns a list of test mode orders. By
     *        default — 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     * @throws VKApiActionFailedException Unable to process action
     *
     */
    public function changeState(array $params = array()) {
        return $this->http->post('orders.changeState', $params);
    }

    /**
     *
     *
     *
     * @param $params array
     *      - integer user_id:
     *      - array votes:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamException One of the parameters specified was missing or invalid
     *
     */
    public function getAmount(array $params = array()) {
        return $this->http->post('orders.getAmount', $params);
    }
}
