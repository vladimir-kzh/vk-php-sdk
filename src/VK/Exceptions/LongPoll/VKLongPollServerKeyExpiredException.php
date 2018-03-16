<?php

namespace VK\Exceptions\LongPoll;

use VK\Exceptions\VKLongPollException;

class VKLongPollServerKeyExpiredException extends VKLongPollException
{
    public function __construct(string $message = '')
    {
        parent::__construct(2, $message);
    }
}
