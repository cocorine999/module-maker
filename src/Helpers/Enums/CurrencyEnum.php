<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`CurrencyEnum`***
 * 
 * This class represents the enumeration of currencies in the application.
 * It defines the available currencies as constants, including 'XOF', 'USD', 'CA_DOLLAR', and 'EURO'.
 * 
 * The default scope is set to `XOF`.
 *
 * @method static array labels()
 *     Get the labels for the currencies options.
 *     Returns an array with the labels for the currencies options, where the keys are the currencies option constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the currencies options.
 *     Returns an array with the descriptions for the currencies options, where the keys are the currencies option constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum CurrencyEnum: string implements EnumContract
{
    use IsEnum;


    /**
     * Represents the currency Franc CFA used in West African countries.
     *
     * @var string
     */
    case XOF = 'xof';

    /**
     * Represents the currency Naira used in Nigeria.
     *
     * @var string
     */
    case NGN = 'ngn';

    /**
     * Represents the Ghanaian Cedi.
     *
     * @var string
     */
    case GHS = 'ghs';

    /**
     * Represents the Ethiopian Birr.
     *
     * @var string
     */
    case ETB = 'etb';

    /**
     * Represents the Algerian Dinar.
     *
     * @var string
     */
    case DZD = 'dzd';

    /**
     * Represents the Zambian Kwacha used in Zambia.
     */
    case ZMW = 'zmw';

    /**
     * Represents the Ugandan Shilling.
     *
     * @var string
     */
    case UGX = 'ugx';

    /**
     * Represents the currency Kenyan Shilling used in Kenya.
     *
     * @var string
     */
    case KES = 'kes';

    /**
     * Represents the currency Rand used in South Africa.
     *
     * @var string
     */
    case ZAR = 'zar';

    /**
     * Represents the currency Egyptian Pound used in Egypt.
     *
     * @var string
     */
    case EGP = 'egp';

    /**
     * Represents the currency Moroccan Dirham used in Morocco.
     *
     * @var string
     */
    case MAD = 'mad';

    /**
     * Represents the currency US Dollar.
     *
     * @var string
     */
    case USD = 'usd';

    /**
     * Represents the currency Canadian Dollar.
     *
     * @var string
     */
    case CAD = 'cad';

    /**
     * Represents the currency Euro.
     *
     * @var string
     */
    case EUR = 'eur';

    /**
     * The default scope.
     * 
     * @return string
     */
    public const DEFAULT          = 'xof'; //self::XOF;
    
    /**
     * The fallback scope.
     * 
     * @return string
     */
    public const FALLBACK         = 'xof'; //self::XOF;

    /**
     * Get the labels for the currency types.
     *
     * @return array The labels for the currency types.
     */
    public static function labels(): array
    {
        return [
            self::XOF => 'West African CFA franc',
            self::NGN => 'Nigerian Naira',
            self::GHS => 'Ghanaian Cedi',
            self::ETB => 'Ethiopian Birr',
            self::DZD => 'Algerian Dinar',
            self::ZMW => 'Zambian Kwacha',
            self::UGX => 'Ugandan Shilling',
            self::KES => 'Kenyan Shilling',
            self::ZAR => 'South African Rand',
            self::EGP => 'Egyptian Pound (Egypt)',
            self::MAD => 'Moroccan Dirham (Morocco)',
            self::USD => 'United States Dollar',
            self::CAD => 'Canadian Dollar',
            self::EUR => 'Euro'
        ];
    }

    /**
     * Get descriptions for the currency types.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::XOF => 'The West African CFA franc - The currency used by eight independent states in West Africa.',
            self::NGN => 'Nigerian Naira - The official currency of Nigeria.',
            self::GHS => 'Ghanaian Cedi - The currency of Ghana.',
            self::ETB => 'Ethiopian Birr - The currency used in Ethiopia.',
            self::DZD => 'Algerian Dinar - The currency of Algeria.',
            self::ZMW => 'Zambian Kwacha - The currency used in Zambia.',
            self::UGX => 'Ugandan Shilling - The official currency of Uganda.',
            self::KES => 'Kenyan Shilling - The currency used in Kenya.',
            self::ZAR => 'South African Rand - The currency of South Africa.',
            self::EGP => 'Egyptian Pound - The currency used in Egypt.',
            self::MAD => 'Moroccan Dirham - The currency of Morocco.',
            self::USD => 'United States Dollar - The official currency of the United States of America.',
            self::CAD => 'Canadian Dollar - The official currency of Canada.',
            self::EUR => 'Euro - The official currency of the European Union.'
        ];
    }
}