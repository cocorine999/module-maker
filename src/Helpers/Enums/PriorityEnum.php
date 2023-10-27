<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`PriorityEnum`***
 * 
 * This class represents the enumeration of priority levels in the application.
 * It defines the available priority levels as constants, including `LOW`, `MEDIUM`, `HIGH`, and `CUSTOM`.
 * 
 * The default priority level is set to `LOW`.
 *
 * @method static array labels()
 *     Get the labels for the priority levels.
 *     Returns an array with the labels for the priority levels, where the keys are the priority level constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the priority levels.
 *     Returns an array with the descriptions for the priority levels, where the keys are the priority level constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum PriorityEnum: string implements EnumContract
{
    use IsEnum;


    /**
     * Represents a low priority.
     *
     * @var string
     */
    case LOW = 'low';

    /**
     * Represents a medium priority.
     *
     * @var string
     */
    case MEDIUM = 'medium';

    /**
     * Represents a high priority.
     *
     * @var string
     */
    case HIGH = 'high';

    /**
     * Represents a custom priority.
     *
     * @var string
     */
    case CUSTOM = 'custom';

    /**
     * The default priority level value.
     * 
     * @return string
     */
    public const DEFAULT          = 'medium'; //self::MEDIUM;
    
    /**
     * The fallback priority level value.
     * 
     * @return string
     */
    public const FALLBACK         = 'medium'; //self::MEDIUM;

    /**
     * Get the labels for the priority levels.
     *
     * @return array The labels for the priority levels.
     */
    public static function labels(): array
    {
        return [
            self::LOW    => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH   => 'High',
            self::CUSTOM => 'Custom',
        ];
    }

    /**
     * Get descriptions for the priority levels.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::LOW    => 'Represents a low priority level.',
            self::MEDIUM => 'Represents a medium priority level.',
            self::HIGH   => 'Represents a high priority level.',
            self::CUSTOM => 'Represents a custom priority level.',
        ];
    }
}