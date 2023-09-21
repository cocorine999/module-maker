<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Exceptions\Contracts;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Common\ErrorCodeEnum;
use Illuminate\Http\Request;
use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Responses\Json\JsonResponseTrait;
use Illuminate\Http\Response;

/**
 * Class ***`CoreException`***
 * 
 * This is the base exception class for core-related exceptions in the application.
 * All core exception classes should extend this class to inherit common exception behavior.
 * 
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Exceptions\Contracts`***
 */
class CoreException extends \Exception
{
    /**
     * The HTTP status code associated with the exception.
     *
     * @var int
     */
    protected $status_code;

    /**
     * The error code associated with the exception.
     *
     * @var int
     */
    protected int $error_code;

    /**
     * Additional error details or context.
     *
     * @var mixed
     */
    protected mixed $error;


    /**
     * CoreException constructor.
     * 
     * @param string     $message      The Exception message to be thrown. (optional)
     *                                 It should describe the specific reason for the migration error.
     *                                 If not provided, a default message "An unexpected error occurred." will be used.
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
    public function __construct(string $message = 'An unexpected error occurred.', int $error_code = ErrorCodeEnum::DEFAULT, int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR, $error = null, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(message: $message, code: $code, previous: $previous);

        $this->error_code    = $error_code ?? $this->code;
        $this->status_code = $status_code;
        $this->error        = $error;
    }

    /**
     * Get the HTTP status code associated with the exception.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    /**
     * Set the HTTP status code of the exception.
     *
     * @param  int  $status_code
     * @return void
     */
    public function setStatusCode(int $status_code): void
    {
        $this->status_code = $status_code;
    }

    /**
     * Get the error code associated with the exception.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->error_code;
    }

    /**
     * Set the error code of the exception.
     *
     * @param  int   $error_code
     * @return void
     */
    public function setErrorCode(int $error_code): void
    {
        $this->error_code = $error_code;
    }

    /**
     * Get the additional error details or context.
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the error code of the exception.
     *
     * @param  int   $error
     * @return void
     */
    public function setError(int $error): void
    {
        $this->error = $error;
    }


    /**
     * Render the exception for display or response as a JSON object.
     *
     * This method can be overridden in child classes to provide customized rendering of the exception.
     * For API context, it returns the exception message and status code as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request, \Throwable $exception = null): \Illuminate\Http\JsonResponse
    {
        if ($request->expectsJson() || $request->wantsJson() || $request->isJson() || $request->is('api/*')) {

            $message = $this->getMessage();
            if ($exception) {
                $message = $exception->getMessage();
                $message = $exception->getPrevious() ? $message . $exception->getPrevious()->getMessage() : $message;
            }

            return JsonResponseTrait::error(
                message: $message,
                errors: $this->getError(),
                status_code: $this->getStatusCode()
            );
        }
    }

    /**
     * Get a string representation of the exception.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        $errorString = "";
        if ($this->error !== null) {
            $errorString = "\nAdditional Error Details: " . json_encode($this->error);
        }

        $codeToDisplay = $this->getErrorCode() !== null ? $this->getErrorCode() : $this->getCode();
            
        return get_class($this) . " [{$codeToDisplay}]: {$this->getMessage()}{$errorString}\n";
    }
}