<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`WalletAccountTypeEnum`***
 * 
 * This class represents the enumeration of scopes in the application.
 * It defines the available scopes as constants, including `GLOBAL`, `ORGANIZATION_SPECIFIC`, `RESOURCE_SPECIFIC`, and `DEPARTMENT_SPECIFIC`.
 * 
 * The default scope is set to `GLOBAL`.
 *
 * @method static array labels()
 *     Get the labels for the visibility options.
 *     Returns an array with the labels for the visibility options, where the keys are the visibility option constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the visibility options.
 *     Returns an array with the descriptions for the visibility options, where the keys are the visibility option constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum WalletAccountTypeEnum: string implements EnumContract
{
    use IsEnum;


    /**
     * Represents a global scope.
     *
     * @var string
     */
    case XOF = 'fcfa';

    /**
     * Represents a global scope.
     *
     * @var string
     */
    case US_DOLLAR = 'us_dollar';

    /**
     * Represents a global scope.
     *
     * @var string
     */
    case CA_DOLLAR = 'ca_dollar';

    /**
     * Represents a global scope.
     *
     * @var string
     */
    case EURO = 'euro';

    /**
     * The default scope.
     * 
     * @return string
     */
    public const DEFAULT          = 'fcfa'; //self::SHARED;
    
    /**
     * The fallback scope.
     * 
     * @return string
     */
    public const FALLBACK         = 'fcfa'; //self::SHARED;

    /**
     * Get the labels for the scopes.
     *
     * @return array The labels for the scopes.
     */
    public static function labels(): array
    {
        return [
            self::XOF => 'Franc CFA'
        ];
    }

    /**
     * Get descriptions for the scopes.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::XOF => 'Franc CFA'
        ];
    }
}