<?php

namespace VK\CallbackApi\LongPoll;

use VK\CallbackApi\VKCallbackApiHandler;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;
use VK\LongPoll\VKLongPollExecutorAbstract;

class VKCallbackApiLongPollExecutor extends VKLongPollExecutorAbstract
{

    protected const PARAM_GROUP_ID = 'group_id';

    protected const EVENT_TYPE = 'type';
    protected const EVENT_OBJECT = 'object';

    protected $group_id;
    protected $handler;

    /**
     * CallbackApiLongPollExecutor constructor.
     * @param VKApiClient $api_client
     * @param string $access_token
     * @param int $group_id
     * @param VKCallbackApiHandler $handler
     * @param int $wait
     */
    public function __construct(
        VKApiClient $api_client,
        string $access_token,
        int $group_id,
        VKCallbackApiHandler $handler,
        int $wait = self::DEFAULT_WAIT
    )
    {
        $this->group_id = $group_id;
        $this->handler = $handler;
        parent::__construct($api_client, $access_token, $wait);
    }

    /**
     * @param $event
     */
    protected function handleEvent($event)
    {
        $this->handler->parseObject($this->group_id, null, $event[static::EVENT_TYPE], $event[static::EVENT_OBJECT]);
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
        $params = array(
            static::PARAM_GROUP_ID => $this->group_id
        );

        $server = $this->api_client->groups()->getLongPollServer($this->access_token, $params);

        return array(
            static::SERVER_URL => $server['server'],
            static::SERVER_TIMESTAMP => $server['ts'],
            static::SERVER_KEY => $server['key'],
        );
    }
}
