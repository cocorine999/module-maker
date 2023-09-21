<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Exceptions;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Common\ErrorCodeEnum;
use Illuminate\Http\Response;


/**
 * Class ***`DatabaseMigrationException`***
 * 
 * This exception is thrown when a database migration encounters an error.
 * It extends the CoreException class and allows setting a specific status code for API responses if needed.
 * 
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Exceptions`***
 */
class DatabaseMigrationException extends \LaravelCoreModule\CoreModuleMaker\Exceptions\Contracts\CoreException
{

    /**
     * DatabaseMigrationException constructor.
     * 
     * @param string     $message      The specific reason for the database migration error.
     *                                 If not provided, a default message "Database migration failed." will be used.
     * 
     * @param int        $error_code   The error code associated with the exception (optional).
     *                                 If not provided, it defaults to the value of the 'code' parameter.
     * 
     * @param int        $status_code  The HTTP status code associated with the exception (optional).
     *                                 It represents the status code for API responses or HTTP error handling.
     *                                 If not provided, it defaults to HTTP status code 500 (Internal Server Error).
     * @param array|null $error        Additional error information or data related to the exception (optional).
     * @param int        $code         The Exception code. (optional)
     *                                 If not provided, it defaults to 0.
     * @param \Throwable $previous     The previous throwable used for the exception chaining. (optional)
     */
    public function __construct(
        string $message = 'Database migration failed.',
        int $error_code =  ErrorCodeEnum::DATABASE_MIGRATION_EXCEPTION,
        int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR,
        $error = null,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct(message: $message, error_code: $error_code, status_code: $status_code, error: $error, code: $code, previous: $previous);
    }
}