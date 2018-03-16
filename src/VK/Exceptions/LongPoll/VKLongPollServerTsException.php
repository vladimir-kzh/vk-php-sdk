<?php

namespace VK\Exceptions\LongPoll;

use VK\Exceptions\VKLongPollException;

class VKLongPollServerTsException extends VKLongPollException
{
    protected $ts;

    public function __construct(?int $ts, string $message = '')
    {
        $this->ts = $ts;
        parent::__construct(1, $message);
    }

    /**
     * @return int|null
     */
    public function getLastTimestamp(): ?int
    {
        return $this->ts;
    }
}
