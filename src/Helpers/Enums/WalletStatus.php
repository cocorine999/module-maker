<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`WalletStatus`***
 * 
 * This class represents an enumeration of wallet statuses in the application.
 * It defines available wallet statuses as constants, including 'single', 'joint', and 'locked'
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
enum WalletStatus: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents an active status.
     *
     * @var string
     */
    case ACTIVE = 'active';

    /**
     * Represents an active status.
     *
     * @var string
     */
    case INACTIVE = 'inactive';

    /**
     * Represents a locked wallet.
     *
     * @var string
     */
    case LOCKED = 'locked';

    /**
     * Represents a blocked wallet.
     *
     * @var string
     */
    case BLOCKED = 'blocked';

    /**
     * The default status.
     * 
     * @return string
     */
    public const DEFAULT          = 'active'; //self::ACTIVE;
    
    /**
     * The fallback scope.
     * 
     * @return string
     */
    public const FALLBACK         = 'active'; //self::ACTIVE;

    /**
     * Get the labels for the wallet statuses.
     *
     * @return array The labels for the wallet statuses.
     */
    public static function labels(): array
    {
        return [
            self::ACTIVE   => 'Active',
            self::INACTIVE => 'Inactive',
            self::LOCKED   => 'Locked',
            self::BLOCKED  => 'Blocked',
        ];
    }

    /**
     * Get descriptions for the wallet statuses.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::ACTIVE   => 'The wallet is currently active and operational.',
            self::INACTIVE => 'The wallet is currently inactive.',
            self::LOCKED   => 'The wallet has been Locked.',
            self::BLOCKED  => 'The wallet has been blocked or suspended.',
        ];
    }
}