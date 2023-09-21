<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Users;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeOfAccountEnum`***
 *
 * This class represents the enumeration of types of accounts in the application.
 * It defines the available types of accounts as constants, including `PERSONAL` and `MORAL`.
 *
 * The default type of account is set to `PERSONAL`.
 *
 * @method static array labels()
 *     Get the labels for the types of accounts.
 *     Returns an array with the labels for the types of accounts, where the keys are the type of account constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the types of accounts.
 *     Returns an array with the available type of account descriptions.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Users`***
 */
enum TypeOfAccountEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the type of account "personal".
     *
     * @var string
     */
    case PERSONAL           = 'personal';

    /**
     * Represents the type of account "moral".
     *
     * @var string
     */
    case MORAL              = 'moral';

    /**
     * The default type of account value.
     * 
     * @return string
     */
    public const DEFAULT    = 'personal'; //self::PERSONAL;

    /**
     * The fallback type of account value.
     * 
     * @return string
     */
    public const FALLBACK   = 'personal'; //self::PERSONAL;

    /**
     * Get the labels for the types of accounts.
     *
     * @return array The labels for the types of accounts.
     */
    public static function labels(): array
    {
        return [
            self::PERSONAL->value  => 'Personal Account',
            self::MORAL->value     => 'Moral Account',
        ];
    }

    /**
     * Get all the types of accounts enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::PERSONAL->value  => 'Personal User Account',
            self::MORAL->value     => 'Moral User Account'
        ];
    }
    
}
