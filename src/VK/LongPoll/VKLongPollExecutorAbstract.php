<?php

namespace VK\LongPoll;

use Http\Client\Exception\TransferException;
use VK\Client\VKHttpClient;
use VK\Exceptions\LongPoll\VKLongPollInformationLostException;
use VK\Exceptions\LongPoll\VKLongPollServerKeyExpiredException;
use VK\Exceptions\LongPoll\VKLongPollServerTsException;
use VK\Exceptions\VKLongPollException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

abstract class VKLongPollExecutorAbstract
{
    protected const PARAM_ACT = 'act';
    protected const PARAM_KEY = 'key';
    protected const PARAM_TS = 'ts';
    protected const PARAM_WAIT = 'wait';
    protected const VALUE_ACT = 'a_check';

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

    protected $httpClient;

    protected $server;
    protected $last_ts = null;
    protected $wait;

    /**
     * CallbackApiLongPollExecutor constructor.
     * @param VKHttpClient $httpClient
     * @param int $wait
     */
    public function __construct(
        VKHttpClient $httpClient,
        int $wait = self::DEFAULT_WAIT
    )
    {
        $this->httpClient = $httpClient;
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

            $events = $this->getEvents($this->server[static::SERVER_URL], $this->server[static::SERVER_KEY], $ts);
            $this->handleEvents($events);
            $this->last_ts = $events[static::EVENTS_TS];

        } catch (VKLongPollServerKeyExpiredException|VKLongPollInformationLostException $e) {

            $this->server = $this->getLongPollServer();

        } catch (VKLongPollServerTsException $e) {

            $this->last_ts = $e->getLastTimestamp();

        }

        return $this->last_ts;
    }

    protected function handleEvents(array $events)
    {
        foreach ($events[static::EVENTS_UPDATES] as $event) {
            $this->handleEvent($event);
        }
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
            if (substr($host, 0, 4) !== 'http') {
                $host = 'https://' . $host;
            }
            $response = $this->httpClient->get($host, $params);
        } catch (TransferException $e) {
            throw new VKClientException($e);
        }

        return $response;
    }
}
