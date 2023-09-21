<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Common;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`ErrorCodeEnum`***
 *  
 * The `ErrorCodeEnum` represents a set of error codes used in the application.
 * Each error code corresponds to a specific error scenario and provides a
 * standardized way to identify and handle errors throughout the system.
 * It provides a standardized way to communicate and manage errors in the system.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Enums\Common`***
 */
enum ErrorCodeEnum:int implements EnumContract
{
    use IsEnum;

    /**
     * The code for an unknown error.
     *
     * Key   : 'UNKNOWN_ERROR'
     * Value : 1000
     *
     * @var string
     */
    const UNKNOWN_ERROR                              = 1000;

    /**
     * The code for an invalid argument error.
     *
     * Key   : 'INVALID_ARGUMENT'
     * Value : 1001
     *
     * @var string
     */
    const INVALID_ARGUMENT                           = 1001;

    /**
     * The code for an invalid input error.
     *
     * Key   : 'INVALID_INPUT_ERROR'
     * Value : 1002
     *
     * @var string
     */
    const INVALID_INPUT_ERROR                        = 1002;

    /**
     * The code for an access denied error.
     *
     * Key   : 'ACCESS_DENIED'
     * Value : 1003
     *
     * @var string
     */
    const ACCESS_DENIED                              = 1003;

    /**
     * The code for an authentication failed error.
     *
     * Key   : 'AUTHENTICATION_FAILED'
     * Value : 1004
     *
     * @var string
     */
    const AUTHENTICATION_FAILED                      = 1004;

    /**
     * The code for an authorization failed error.
     *
     * Key   : 'AUTHORIZATION_FAILED'
     * Value : 1005
     *
     * @var string
     */
    const AUTHORIZATION_FAILED                       = 1005;

    /**
     * The code for a not found error.
     *
     * Key   : 'NOT_FOUND'
     * Value : 1006
     *
     * @var string
     */
    const NOT_FOUND                                  = 1006;

    /**
     * The code for a validation error.
     *
     * Key   : 'FILE_UPLOAD_FAILED'
     * Value : 1007
     *
     * @var string
     */
    const VALIDATION_ERROR                           = 1007;

    /**
     * The code for a file upload failed error.
     *
     * Key   : 'FILE_UPLOAD_FAILED'
     * Value : 1008
     *
     * @var string
     */
    const FILE_UPLOAD_FAILED                         = 1008;

    /**
     * The code for a file not found error.
     *
     * Key   : 'FILE_NOT_FOUND_ERROR'
     * Value : 1009
     *
     * @var string
     */
    const FILE_NOT_FOUND_ERROR                       = 1009;

    /**
     * The code for a database error.
     *
     * Key   : 'DATABASE_ERROR'
     * Value : 1010
     *
     * @var string
     */
    const DATABASE_ERROR                             = 1010;

    /**
     * The code for a database connection error.
     *
     * Key   : 'DATABASE_CONNECTION_ERROR'
     * Value : 1011
     *
     * @var string
     */
    const DATABASE_CONNECTION_ERROR                  = 1011;

    /**
     * The code for an SQL exception error.
     *
     * Key   : 'SQL_EXCEPTION'
     * Value : 1012
     *
     * @var string
     */
    const SQL_EXCEPTION                              = 1012;

    /**
     * The code for a query exception error.
     *
     * Key   : 'QUERY_EXCEPTION'
     * Value : 1013
     *
     * @var string
     */
    const QUERY_EXCEPTION                            = 1013;

    /**
     * The code for an API error.
     *
     * Key   : 'API_ERROR'
     * Value : 1014
     *
     * @var string
     */
    const API_ERROR                                  = 1014;

    /**
     * The code for a service unavailable error.
     *
     * Key   : 'SERVICE_UNAVAILABLE'
     * Value : 1015
     *
     * @var string
     */
    const SERVICE_UNAVAILABLE                        = 1015;

    /**
     * The code for a permission denied error.
     *
     * Key   : 'PERMISSION_DENIED_ERROR'
     * Value : 1016
     *
     * @var string
     */
    const PERMISSION_DENIED_ERROR                    = 1016;

    /**
     * The code for an invalid json argument error.
     *
     * Key   : 'INVALID_JSON_ARGUMENT'
     * Value : 1017
     *
     * @var string
     */
    const INVALID_JSON_ARGUMENT                      = 1017;

    /**
     * The code for database migration exception error.
     *
     * Key   : 'DATABASE_MIGRATION_EXCEPTION'
     * Value : 1018
     *
     * @var string
     */
    const DATABASE_MIGRATION_EXCEPTION               = 1018;

    /**
     * The code for internal server exception error.
     *
     * Key   : 'INTERNAL_SERVER_ERROR'
     * Value : 1019
     *
     * @var string
     */
    const INTERNAL_SERVER_ERROR                      = 1019;

    /**
     * The code for internal server exception error.
     *
     * Key   : 'PDO_EXCEPTION'
     * Value : 1020
     *
     * @var string
     */
    const PDO_EXCEPTION                             = 1020;

    /**
     * The default error code value.
     * 
     * @return string
     */
    public const DEFAULT                            = 1019; //self::INTERNAL_SERVER_ERROR;
    
    /**
     * The fallback error code value.
     * 
     * @return string
     */
    public const FALLBACK                           = 1000; //self::UNKNOWN_ERROR;

    /**
     * Get the labels for all error codes.
     *
     * @return array An associative array of error codes and their labels.
     */
    public static function labels(): array
    {
        return [
            self::UNKNOWN_ERROR                     => 'Unknown Error',
            self::INVALID_ARGUMENT                  => 'Invalid Argument',
            self::INVALID_INPUT_ERROR               => 'Invalid Input Error',
            self::ACCESS_DENIED                     => 'Access Denied',
            self::AUTHENTICATION_FAILED             => 'Authentication Failed',
            self::AUTHORIZATION_FAILED              => 'Authorization Failed',
            self::NOT_FOUND                         => 'Not Found',
            self::VALIDATION_ERROR                  => 'Validation Error',
            self::FILE_UPLOAD_FAILED                => 'File Upload Failed',
            self::FILE_NOT_FOUND_ERROR              => 'File Not Found Error',
            self::DATABASE_ERROR                    => 'Database Error',
            self::DATABASE_CONNECTION_ERROR         => 'Database Connection Error',
            self::SQL_EXCEPTION                     => 'SQL Exception',
            self::QUERY_EXCEPTION                   => 'Query Exception',
            self::API_ERROR                         => 'API Error',
            self::SERVICE_UNAVAILABLE               => 'Service Unavailable',
            self::PERMISSION_DENIED_ERROR           => 'Permission Denied Error',
            self::INTERNAL_SERVER_ERROR             => 'Internal Server Exception Error',
            self::PDO_EXCEPTION                     => 'PDO Exception'
        ];
    }

    /**
     * Get all the marital status enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the error codes enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::UNKNOWN_ERROR                     => "An unknown error occurred.",
            self::INVALID_ARGUMENT                  => "The argument provided is invalid.",
            self::INVALID_INPUT_ERROR               => "The input provided is invalid.",
            self::ACCESS_DENIED                     => "Access denied. You do not have permission to perform this action.",
            self::AUTHENTICATION_FAILED             => "Authentication failed.",
            self::AUTHORIZATION_FAILED              => "Authorization failed. You are not authorized to perform this action.",
            self::NOT_FOUND                         => "The requested resource was not found.",
            self::VALIDATION_ERROR                  => "There was an error validating the input data.",
            self::FILE_UPLOAD_FAILED                => "Failed to upload the file.",
            self::FILE_NOT_FOUND_ERROR              => "The specified file was not found.",
            self::DATABASE_ERROR                    => "A database error occurred.",
            self::DATABASE_CONNECTION_ERROR         => "Failed to establish a connection to the database.",
            self::SQL_EXCEPTION                     => "An exception occurred while executing an SQL statement.",
            self::QUERY_EXCEPTION                   => "An exception occurred while processing the database query.",
            self::API_ERROR                         => "An error occurred while interacting with the API.",
            self::SERVICE_UNAVAILABLE               => "The service is currently unavailable.",
            self::PERMISSION_DENIED_ERROR           => "Permission denied. You do not have sufficient privileges to perform this action.",
            self::INTERNAL_SERVER_ERROR             => "The internal server exception error.",
            self::PDO_EXCEPTION                     => 'PDO Exception',
        ];
    }

}