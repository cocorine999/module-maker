<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`VisibilityEnum`***
 * 
 * This class represents the enumeration of visibility options in the application.
 * It defines the available visibility options as constants, including "Public," "Private," and "Shared."
 * 
 * The default visibility is set to `PUBLIC`.
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
enum VisibilityEnum: string implements EnumContract
{
    use IsEnum;


    /**
     * Represents a public visibility.
     *
     * @var string
     */
    case PUBLIC = 'public';

    /**
     * Represents a private visibility.
     *
     * @var string
     */
    case PRIVATE = 'private';

    /**
     * Represents a shared visibility.
     *
     * @var string
     */
    case SHARED = 'shared';

    /**
     * The default visibility option value.
     * 
     * @return string
     */
    public const DEFAULT          = 'shared'; //self::SHARED;
    
    /**
     * The fallback visibility option value.
     * 
     * @return string
     */
    public const FALLBACK         = 'shared'; //self::SHARED;

    /**
     * Get the labels for the visibility options.
     *
     * @return array The labels for the visibility options.
     */
    public static function labels(): array
    {
        return [
            self::PUBLIC => 'Public',
            self::PRIVATE => 'Private',
            self::SHARED => 'Shared'
        ];
    }

    /**
     * Get descriptions for the visibility options.
     *
     * @return array An array containing descriptions for the visibility options.
     */
    public static function descriptions(): array
    {
        return [
            self::PUBLIC => 'Represents a public visibility.',
            self::PRIVATE => 'Represents a private visibility.',
            self::SHARED => 'Represents a shared visibility.'
        ];
    }
}