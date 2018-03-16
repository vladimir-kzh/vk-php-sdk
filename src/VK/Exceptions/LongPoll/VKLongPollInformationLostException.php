<?php

namespace VK\Exceptions\LongPoll;

use VK\Exceptions\VKLongPollException;

class VKLongPollInformationLostException extends VKLongPollException
{
    public function __construct(string $message = '')
    {
        parent::__construct(3, $message);
    }
}
