<?php

namespace VK\LongPoll;

use VK\Exceptions\LongPoll\VKLongPollInformationLostException;
use VK\Exceptions\LongPoll\VKLongPollServerKeyExpiredException;
use VK\Exceptions\LongPoll\VKLongPollServerTsException;
use VK\Exceptions\VKLongPollException;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;
use VK\TransportClient\Curl\CurlHttpClient;
use VK\TransportClient\TransportClientResponse;
use VK\TransportClient\TransportRequestException;

abstract class VKLongPollExecutorAbstract
{
    protected const PARAM_ACT = 'act';
    protected const PARAM_KEY = 'key';
    protected const PARAM_TS = 'ts';
    protected const PARAM_WAIT = 'wait';
    protected const VALUE_ACT = 'a_check';

    protected const EVENTS_FAILED = 'failed';
    protected const EVENTS_TS = 'ts';
    protected const EVENTS_UPDATES = 'updates';

    protected const SERVER_TIMESTAMP = 'ts';
    protected const SERVER_URL = 'url';
    protected const SERVER_KEY = 'key';

    protected const ERROR_CODE_INCORRECT_TS_VALUE = 1;
    protected const ERROR_CODE_TOKEN_EXPIRED = 2;
    protected const ERROR_CODE_INFORMATION_LOST = 3;
    protected const ERROR_CODE_INVALID_VERSION = 4;

    protected const CONNECTION_TIMEOUT = 10;
    protected const HTTP_STATUS_CODE_OK = 200;
    protected const DEFAULT_WAIT = 10;

    protected $api_client;
    protected $access_token;
    protected $http_client;
    protected $server;
    protected $last_ts = null;
    protected $wait;

    /**
     * CallbackApiLongPollExecutor constructor.
     * @param VKApiClient $api_client
     * @param string $access_token
     * @param int $wait
     */
    public function __construct(
        VKApiClient $api_client,
        string $access_token,
        int $wait = self::DEFAULT_WAIT
    )
    {
        $this->api_client = $api_client;
        $this->http_client = new CurlHttpClient(static::CONNECTION_TIMEOUT);
        $this->access_token = $access_token;
        $this->wait = $wait;
    }

    /**
     * Starts listening to LongPoll events.
     *
     * @param int|null $ts
     *
     * @return null
     * @throws VKLongPollServerTsException
     * @throws VKApiException
     * @throws VKClientException
     */
    public function listen(?int $ts = null)
    {
        if ($this->server === null) {
            $this->server = $this->getLongPollServer();
        }

        if ($this->last_ts === null) {
            $this->last_ts = $this->server[static::SERVER_TIMESTAMP];
        }

        if ($ts === null) {
            $ts = $this->last_ts;
        }

        try {

            $response = $this->getEvents($this->server[static::SERVER_URL], $this->server[static::SERVER_KEY], $ts);
            foreach ($response[static::EVENTS_UPDATES] as $event) {
                $this->handleEvent($event);
            }
            $this->last_ts = $response[static::EVENTS_TS];

        } catch (VKLongPollServerKeyExpiredException|VKLongPollInformationLostException $e) {

            $this->server = $this->getLongPollServer();

        } catch (VKLongPollServerTsException $e) {

            $this->last_ts = $e->getLastTimestamp();

        }

        return $this->last_ts;
    }

    /**
     * @param $event
     * @return void
     */
    abstract protected function handleEvent($event);

    /**
     * Get long poll server
     *
     * @return array
     * @throws VKApiException
     * @throws VKClientException
     */
    abstract protected function getLongPollServer(): array;

    /**
     * Retrieves events from long poll server starting from the specified timestamp.
     *
     * @param string $host
     * @param string $key
     * @param int $ts
     * @return mixed
     * @throws VKLongPollException
     * @throws VKClientException
     */
    public function getEvents(string $host, string $key, int $ts)
    {
        $params = array(
            static::PARAM_KEY => $key,
            static::PARAM_TS => $ts,
            static::PARAM_WAIT => $this->wait,
            static::PARAM_ACT => static::VALUE_ACT
        );

        try {
            $response = $this->http_client->get($host, $params);
        } catch (TransportRequestException $e) {
            throw new VKClientException($e);
        }

        return $this->parseResponse($response);
    }

    /**
     * Decodes the LongPoll response and checks its status code and whether it has a failed key.
     *
     * @param TransportClientResponse $response
     * @return mixed
     * @throws VKLongPollException
     */
    private function parseResponse(TransportClientResponse $response)
    {
        $this->checkHttpStatus($response);

        $body = $response->getBody();
        $decode_body = $this->decodeBody($body);

        if (isset($decode_body[static::EVENTS_FAILED])) {
            throw VKLongPollException::make($decode_body);
        }

        return $decode_body;
    }

    /**
     * Decodes body.
     *
     * @param string $body
     * @return mixed
     */
    protected function decodeBody(string $body)
    {
        $decoded_body = json_decode($body, true);

        if ($decoded_body === null || !is_array($decoded_body)) {
            $decoded_body = [];
        }

        return $decoded_body;
    }

    /**
     * Check http status of response
     *
     * @param TransportClientResponse $response
     * @throws VKClientException
     */
    protected function checkHttpStatus(TransportClientResponse $response)
    {
        if ($response->getHttpStatus() != static::HTTP_STATUS_CODE_OK) {
            throw new VKClientException('Invalid http status: ' . $response->getHttpStatus());
        }
    }
}
