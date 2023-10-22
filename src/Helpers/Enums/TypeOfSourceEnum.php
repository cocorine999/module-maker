<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeOfSourceEnum`***
 *
 * This class represents the enumeration of types of a lead source in the application.
 * It defines the available types of a lead source as constants, including `WEBSITE`, `REFERRAL`, `ADVERTISEMENT`, BLOG_POST, FACEBOOK, TWITTER, YOUTUBE, TIK_TOK, INSTAGRAM, LINKEDIN and `PARTNERSHIP`.
 *
 * The default lead source is set to `INQUIRY`.
 *
 * @method static array labels()
 *     Get the labels for the types of a lead source.
 *     Returns an array with the labels for the types of a lead source, where the keys are the lead source constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the types of a lead source.
 *     Returns an array with the descriptions for the types of a lead source, where the keys are the lead source constants and the values are the corresponding descriptions.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums`***;
 */
enum TypeOfSourceEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the website lead source.
     */
    case WEBSITE = 'website';

    /**
     * Represents the inquiry lead source.
     */
    case INQUIRY = 'inquiry';

    /**
     * Represents the referral lead source.
     */
    case REFERRAL = 'referral';

    /**
     * Represents the advertisement lead source.
     */
    case ADVERTISEMENT = 'advertisement';

    /**
     * Represents the blog_post lead source.
     */
    case BLOG_POST = 'blog_post';

    /**
     * Represents the social_media facebook lead source.
     */
    case FACEBOOK = 'facebook';

    /**
     * Represents the social_media twitter lead source.
     */
    case TWITTER = 'twitter';

    /**
     * Represents the social_media youtube lead source.
     */
    case YOUTUBE = 'youtube';

    /**
     * Represents the social_media tik_tok lead source.
     */
    case TIK_TOK = 'tik_tok';

    /**
     * Represents the social_media linkedin lead source.
     */
    case LINKEDIN = 'linkedin';

    /**
     * Represents the social_media instagram lead source.
     */
    case INSTAGRAM = 'instagram';

    /**
     * Represents the partnership lead source.
     */
    case PARTNERSHIP = 'partnership';

    /**
     * The default lead source value.
     * 
     * @return string
     */
    public const DEFAULT          = 'inquiry'; //self::INQUIRY;
    
    /**
     * The fallback lead source value.
     * 
     * @return string
     */
    public const FALLBACK         = 'inquiry'; //self::INQUIRY;

    /**
     * Get the labels for the types of a lead source.
     *
     * @return array The labels for the types of a lead source.
     */
    public static function labels(): array
    {
        return [
            self::WEBSITE->value          => 'Website lead',
            self::REFERRAL->value         => 'Referral lead',
            self::INQUIRY->value          => 'Inquiry lead',
            self::ADVERTISEMENT->value    => 'Advertisement lead',
            self::BLOG_POST->value        => 'Blog post lead',
            self::FACEBOOK->value         => 'Facebook lead',
            self::TWITTER->value          => 'Twitter lead',
            self::YOUTUBE->value          => 'YouTube lead',
            self::TIK_TOK->value          => 'Tik Tok lead',
            self::INSTAGRAM->value        => 'Instagram lead',
            self::LINKEDIN->value         => 'LinkedIn lead',
            self::PARTNERSHIP->value      => 'Partnership lead'
        ];
    }

    /**
     * Get all the types of a lead source enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::WEBSITE->value          => 'Represents Website lead',
            self::REFERRAL->value         => 'Represents Referral lead',
            self::INQUIRY->value          => 'Represents Inquiry lead',
            self::ADVERTISEMENT->value    => 'Represents Advertisement lead',
            self::BLOG_POST->value        => 'Represents Blog post lead',
            self::FACEBOOK->value         => 'Represents Facebook lead',
            self::TWITTER->value          => 'Represents Twitter lead',
            self::YOUTUBE->value          => 'Represents YouTube lead',
            self::TIK_TOK->value          => 'Represents Tik Tok lead',
            self::INSTAGRAM->value        => 'Represents Instagram lead',
            self::LINKEDIN->value         => 'Represents LinkedIn lead',
            self::PARTNERSHIP->value      => 'Represents Partnership lead'
        ];
        
    }
}