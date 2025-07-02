<?php

namespace Utyemma\SaasPro\Abstracts;

use Throwable;

class BaseException {

    protected string $status = '';
    protected string $message = '';
    protected int $code = 0;

    public static function throw(string $message = '', int $code = 0, Throwable|null $previous = null) {
        $instance = new static();

        $message ??= $instance->message;
        $code ??= $instance->$code;
        $status = $instance->status;

        throw new \Exception("{$status}: {$message}", $code, $previous);
    }

}