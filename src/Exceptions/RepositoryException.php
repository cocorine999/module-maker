<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Exceptions;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Common\ErrorCodeEnum;
use Illuminate\Http\Response;


/**
 * Class ***`RepositoryException`***
 *
 * This exception is used to handle errors related to repository operations. It can be thrown when
 * a repository encounters an unexpected issue or fails to perform its intended operation.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Exceptions`***
 */
class RepositoryException extends \LaravelCoreModule\CoreModuleMaker\Exceptions\Contracts\CoreException
{
    /**
     * RepositoryException constructor.
     *
     * @param string         $message       The error message for the exception.
     * @param int            $error_code    The error code associated with the exception.
     * @param int            $status_code   The HTTP status code associated with the exception.
     * @param array|null     $error         Additional error information or data related to the exception.
     * @param int            $code          The Exception code.
     * @param \Throwable|null $previous     The previous throwable used for the exception chaining.
     */
    public function __construct(
        string $message = 'An error occurred during repository operation.',
        int $error_code = ErrorCodeEnum::INTERNAL_SERVER_ERROR,
        int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?array $error = null,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $error_code, $status_code, $error, $code, $previous);
    }
}
