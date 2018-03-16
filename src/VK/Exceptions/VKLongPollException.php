<?php

namespace VK\Exceptions;

use VK\Exceptions\LongPoll\VKLongPollInformationLostException;
use VK\Exceptions\LongPoll\VKLongPollInvalidVersionException;
use VK\Exceptions\LongPoll\VKLongPollServerKeyExpiredException;
use VK\Exceptions\LongPoll\VKLongPollServerTsException;

class VKLongPollException extends \Exception
{
    protected const KEY_ERROR_CODE = 'failed';
    protected const KEY_TS = 'ts';

    public function __construct(int $error_code, string $message = '')
    {
        parent::__construct($message, $error_code);
    }

    public static function make(array $error)
    {
        $error_code = intval($error[static::KEY_ERROR_CODE] ?? 0);
        switch ($error_code) {
            case 1:
                return new VKLongPollServerTsException($error[static::KEY_TS] ?? null);
            case 2:
                return new VKLongPollServerKeyExpiredException();
            case 3:
                return new VKLongPollInformationLostException();
            case 4:
                return new VKLongPollInvalidVersionException();
            default:
                return new VKLongPollException($error_code, 'Unknown error');
        }
    }

}