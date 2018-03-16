<?php

namespace VK\Exceptions\LongPoll;

use VK\Exceptions\VKLongPollException;

class VKLongPollInvalidVersionException extends VKLongPollException
{
    public function __construct(string $message = '')
    {
        parent::__construct(4, $message);
    }
}
