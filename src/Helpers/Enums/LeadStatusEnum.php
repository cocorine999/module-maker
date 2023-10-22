<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`LeadStatusEnum`***
 *
 * This class represents the enumeration of lead statuses in the application.
 * It defines the available lead statuses as constants, including `NEW`, `QUALIFIED`, `CONVERTED` and `CLOSED`.
 *
 * The default lead status is set to `NEW`.
 *
 * @method static array labels()
 *     Get the labels for the lead statuses.
 *     Returns an array with the labels for the lead statuses, where the keys are the lead status constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the lead statuses.
 *     Returns an array with the descriptions for the lead statuses, where the keys are the lead status constants and the values are the corresponding descriptions.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums`***;
 */
enum LeadStatusEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the new account status.
     */
    case NEW = 'new';

    /**
     * Represents the qualified account status.
     */
    case QUALIFIED = 'qualified';

    /**
     * Represents the converted account status.
     */
    case CONVERTED = 'converted';

    /**
     * Represents the lost account status.
     */
    case LOST = 'lost';

    /**
     * Represents the interested account status.
     */
    case INTERESTED = 'interested';

    /**
     * Represents the closed/terminated account status.
     */
    case CLOSED = 'closed';

    /**
     * The default lead status value.
     * 
     * @return string
     */
    public const DEFAULT          = 'new'; //self::NEW;
    
    /**
     * The fallback lead status value.
     * 
     * @return string
     */
    public const FALLBACK         = 'new'; //self::NEW;

    /**
     * Get the labels for the lead statuses.
     *
     * @return array The labels for the lead statuses.
     */
    public static function labels(): array
    {
        return [
            self::NEW->value         => 'New lead',
            self::QUALIFIED->value   => 'Qualified lead',
            self::INTERESTED->value  => 'Interested lead',
            self::CONVERTED->value   => 'Converted lead',
            self::LOST->value        => 'Lost lead',
            self::CLOSED->value      => 'Closed lead'
        ];
    }

    /**
     * Get all the lead statuses enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::NEW->value         => 'Represents a new lead',
            self::QUALIFIED->value   => 'Represents a qualified lead',
            self::INTERESTED->value  => 'Represents a interested lead',
            self::CONVERTED->value   => 'Represents a converted lead',
            self::LOST->value        => 'Represents a lost lead',
            self::CLOSED->value      => 'Represents closed lead'
        ];
        
    }
}