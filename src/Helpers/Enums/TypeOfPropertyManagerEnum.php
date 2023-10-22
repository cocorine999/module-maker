<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeOfPropertyManagerEnum`***
 *
 * This class represents the enumeration of property manager type in the application.
 * It defines the available property manager type as constants, including `LANDLORD`, `PROPERTY_ADMINISTRATOR`, `JUDICIAL_OFFICER`, `BROKER`, `REALTOR` and `ENTERPRISE`.
 * 
 * The default lead status is set to `LANDLORD`.
 *
 * @method static array labels()
 *     Get the labels for the property manager type.
 *     Returns an array with the labels for the property manager type, where the keys are the property manager type constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the property manager type.
 *     Returns an array with the descriptions for the property manager type, where the keys are the property manager type constants and the values are the corresponding descriptions.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums`***;
 */
enum TypeOfPropertyManagerEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the landlord property manager type.
     *
     * @var string
     */
    case LANDLORD = 'landlord';

    /**
     * Represents the property administrator property manager type.
     *
     * @var string
     */
    case PROPERTY_ADMINISTRATOR = 'property_administrator';

    /**
     * Represents the realtor property manager type.
     *
     * @var string
     */
    case JUDICIAL_OFFICER = 'judicial_officer';

    /**
     * Represents the broker property manager type.
     *
     * @var string
     */
    case BROKER = 'broker';

    /**
     * Represents the realtor property manager type.
     *
     * @var string
     */
    case REALTOR = 'realtor';

    /**
     * Represents the corporate property manager type.
     *
     * @var string
     */
    case CORPORATE = 'corporate';

    /**
     * The default property manager type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'property_administrator'; //self::LANDLORD;
    
    /**
     * The fallback property manager type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'property_administrator'; //self::LANDLORD;

    /**
     * Get the labels for the asset managers type.
     *
     * @return array The labels for the asset managers type.
     */
    public static function labels(): array
    {
        return [
            self::LANDLORD->name              => 'Personal',
            self::PROPERTY_ADMINISTRATOR->name  => 'Particulier',
            self::REALTOR->name                 => 'Realtor',
            self::JUDICIAL_OFFICER->name                  => 'Professional',
            self::BROKER->name                  => 'Broker'
        ];
    }

    /**
     * Get all the asset managers type enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::LANDLORD     => 'Represents the personal property manager type.',
            self::PROPERTY_ADMINISTRATOR  => 'Represents the particular property manager type.',
            self::REALTOR      => 'Represents the realtor property manager type.',
            self::JUDICIAL_OFFICER => 'Represents the professional property manager type.',
            self::BROKER       => 'Represents the broker property manager type.'
        ];
        
    }
}