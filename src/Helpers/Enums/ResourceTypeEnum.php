<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`ResourceTypeEnum`***
 * 
 * This class represents the enumeration of resource types in the application.
 * It defines the available resource types as constants, including `MODULE`, `MODEL`, `FIELD`, `SECURITY`, and more.
 * 
 * The default lead status is set to `MODEL`.
 *
 * @method static array labels()
 *     Get the labels for the account types.
 *     Returns an array with the labels for the account types, where the keys are the account type constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the account types.
 *     Returns an array with the descriptions for the account types, where the keys are the account type constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum ResourceTypeEnum: string implements EnumContract
{
    use IsEnum;


    /**
     * Represents a module resource.
     *
     * @var string
     */
    case MODULE = 'module';

    /**
     * Represents a model resource.
     *
     * @var string
     */
    case MODEL = 'model';

    /**
     * Represents a field resource.
     *
     * @var string
     */
    case FIELD = 'field';

    /**
     * Represents a security resource.
     *
     * @var string
     */
    case SECURITY = 'security';

    /**
     * Represents a content-based resource.
     *
     * @var string
     */
    case CONTENT_BASED = 'content-based';

    /**
     * Represents a type-based resource.
     *
     * @var string
     */
    case TYPE_BASED = 'type-based';

    /**
     * Represents an attribute-based resource.
     *
     * @var string
     */
    case ATTRIBUTE_BASED = 'attribute-based';

    /**
     * Represents a location-based resource.
     *
     * @var string
     */
    case LOCATION_BASED = 'location-based';

    /**
     * Represents a context-based resource.
     *
     * @var string
     */
    case CONTEXT_BASED = 'context-based';

    /**
     * Represents a role-based resource.
     *
     * @var string
     */
    case ROLE_BASED = 'role-based';

    /**
     * Represents an API resource.
     *
     * @var string
     */
    case API = 'api';

    /**
     * Represents a template resource.
     *
     * @var string
     */
    case TEMPLATE = 'template';

    /**
     * Represents a document resource.
     *
     * @var string
     */
    case DOCUMENT = 'document';

    /**
     * Represents a media resource.
     *
     * @var string
     */
    case MEDIA = 'media';

    /**
     * Represents a log resource.
     *
     * @var string
     */
    case LOG = 'log';

    /**
     * Represents a event resource.
     *
     * @var string
     */
    case EVENT = 'event';

    /**
     * Represents a setting resource.
     *
     * @var string
     */
    case SETTING = 'setting';

    /**
     * The default asset owner type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'model'; //self::FULL_ACTIVE;
    
    /**
     * The fallback asset owner type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'model'; //self::FULL_ACTIVE;

    /**
     * Get the labels for the resource types.
     *
     * @return array The labels for the resource types.
     */
    public static function labels(): array
    {
        return [
            // Existing resource types
            self::MODULE => 'Module',
            self::MODEL => 'Model',
            self::FIELD => 'Field',
            self::SECURITY => 'Security',
            self::CONTENT_BASED => 'Content-Based',
            self::TYPE_BASED => 'Type-Based',
            self::ATTRIBUTE_BASED => 'Attribute-Based',
            self::LOCATION_BASED => 'Location-Based',
            self::CONTEXT_BASED => 'Context-Based',
            self::ROLE_BASED => 'Role-Based',

            // Additional resource types
            self::API => 'API',
            self::TEMPLATE => 'Template',
            self::DOCUMENT => 'Document',
            self::MEDIA => 'Media',
            self::EVENT => 'Event',
            self::SETTING => 'Setting',
            self::LOG => 'Log',
        ];
    }

    /**
     * Get descriptions for the resource types.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            // Descriptions for existing resource types
            self::MODULE => 'Represents a module resource.',
            self::MODEL => 'Represents a model resource.',
            self::FIELD => 'Represents a field resource.',
            self::SECURITY => 'Represents a security resource.',
            self::CONTENT_BASED => 'Represents a content-based resource.',
            self::TYPE_BASED => 'Represents a type-based resource.',
            self::ATTRIBUTE_BASED => 'Represents an attribute-based resource.',
            self::LOCATION_BASED => 'Represents a location-based resource.',
            self::CONTEXT_BASED => 'Represents a context-based resource.',
            self::ROLE_BASED => 'Represents a role-based resource.',

            self::API => 'Represents an API resource.',
            self::TEMPLATE => 'Represents a template resource.',
            self::DOCUMENT => 'Represents a document resource.',
            self::MEDIA => 'Represents a media resource.',
            self::EVENT => 'Represents an event resource.',
            self::SETTING => 'Represents a setting resource.',
            self::LOG => 'Represents a log resource.'
        ];
    }
}