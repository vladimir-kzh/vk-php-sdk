<?php

namespace VK\LongPoll;

use VK\CallbackApi\VKCallbackApiHandler;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class VKCallbackApiLongPollExecutor extends VKLongPollExecutorAbstract
{
    protected const PARAM_GROUP_ID = 'group_id';

    protected const EVENT_TYPE = 'type';
    protected const EVENT_OBJECT = 'object';

    protected $groupID;
    protected $handler;

    /**
     * VKCallbackApiLongPollExecutor constructor.
     * @param VKHttpClient $httpClient
     * @param VKCallbackApiHandler $handler
     * @param int $groupID
     * @param int $wait
     */
    public function __construct(
        VKHttpClient $httpClient,
        VKCallbackApiHandler $handler,
        int $groupID,
        int $wait = self::DEFAULT_WAIT
    )
    {
        $this->handler = $handler;
        $this->groupID = $groupID;
        parent::__construct($httpClient, $wait);
    }

    /**
     * @param $event
     */
    protected function handleEvent($event)
    {
        $this->handler->parseObject($this->groupID, null, $event[static::EVENT_TYPE], $event[static::EVENT_OBJECT]);
    }

    /**
     * Get long poll server
     *
     * @return array
     * @throws VKApiException
     * @throws VKClientException
     */
    protected function getLongPollServer(): array
    {
        $server = $this->httpClient->get('groups.getLongPollServer', [
            static::PARAM_GROUP_ID => $this->groupID,
        ]);

        return array(
            static::SERVER_URL => $server['server'],
            static::SERVER_TIMESTAMP => $server['ts'],
            static::SERVER_KEY => $server['key'],
        );
    }
}
