<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Exceptions;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Common\ErrorCodeEnum;
use Illuminate\Http\Response;


/**
 * Class InvalidArgumentException
 *
 * This exception is thrown when an invalid argument is passed to a method or function.
 * It extends the CoreException class and provides a specific exception for invalid arguments.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Exceptions
 */
class InvalidArgumentException extends \LaravelCoreModule\CoreModuleMaker\Exceptions\Contracts\CoreException
{
    /**
     * InvalidArgumentException constructor.
     *
     * @param string         $message      The error message for the exception.
     * @param int            $error_code   The error code associated with the exception.
     * @param int            $status_code  The HTTP status code associated with the exception.
     * @param array|null     $error        Additional error information or data related to the exception.
     * @param int            $code         The Exception code.
     * @param \Throwable|null $previous     The previous throwable used for the exception chaining.
     */
    public function __construct(
        string $message = 'Invalid argument',
        int $error_code = ErrorCodeEnum::INVALID_ARGUMENT,
        int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?array $error = null,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $error_code, $status_code, $error, $code, $previous);
    }
}
