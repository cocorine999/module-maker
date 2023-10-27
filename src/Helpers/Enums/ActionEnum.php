<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;

/**
 * Class ***`ActionEnum`***
 * 
 * This class represents the enumeration of actions in the application.
 * It defines the available actions as constants, including "View," "Create," "Edit," "Delete," and more.
 * 
 * The default action is set to `VIEW`.
 *
 * @method static array labels()
 *     Get the labels for the available actions.
 *     Returns an array with the labels for the actions, where the keys are the action constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the available actions.
 *     Returns an array with the descriptions for the actions, where the keys are the action constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum ActionEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents a view action.
     *
     * @var string
     */
    case VIEW = 'view';

    /**
     * Represents a create action.
     *
     * @var string
     */
    case CREATE = 'create';

    /**
     * Represents an edit action.
     *
     * @var string
     */
    case EDIT = 'edit';

    /**
     * Represents a delete action.
     *
     * @var string
     */
    case DELETE = 'delete';

    /**
     * Represents a publish action.
     *
     * @var string
     */
    case PUBLISH = 'publish';

    /**
     * Represents a unpublish action.
     *
     * @var string
     */
    case UNPUBLISH = 'unpublish';

    /**
     * Represents a approve action.
     *
     * @var string
     */
    case APPROVE = 'approve';

    /**
     * Represents a reject action.
     *
     * @var string
     */
    case REJECT = 'reject';

    /**
     * Represents a comment action.
     *
     * @var string
     */
    case COMMENT = 'comment';

    /**
     * Represents a download action.
     *
     * @var string
     */
    case DOWNLOAD = 'download';

    /**
     * Represents a upload action.
     *
     * @var string
     */
    case UPLOAD = 'upload';

    /**
     * Represents a share action.
     *
     * @var string
     */
    case SHARE = 'share';

    /**
     * Represents a execute action.
     *
     * @var string
     */
    case EXECUTE = 'execute';

    /**
     * Represents a export action.
     *
     * @var string
     */
    case EXPORT = 'export';

    /**
     * Represents a import action.
     *
     * @var string
     */
    case IMPORT = 'import';

    /**
     * Represents a print action.
     *
     * @var string
     */
    case PRINT = 'print';

    /**
     * Represents a add action.
     *
     * @var string
     */
    case ADD = 'add';

    /**
     * Represents a remove action.
     *
     * @var string
     */
    case REMOVE = 'remove';

    /**
     * Represents a change_status action.
     *
     * @var string
     */
    case CHANGE_STATUS = 'change_status';

    /**
     * Represents a send_message action.
     *
     * @var string
     */
    case SEND_MESSAGE = 'send_message';

    /**
     * The default action value.
     * 
     * @return string
     */
    public const DEFAULT = 'view';

    /**
     * The fallback action value.
     * 
     * @return string
     */
    public const FALLBACK = 'view';

    /**
     * Get the labels for the available actions.
     *
     * @return array The labels for the available actions.
     */
    public static function labels(): array
    {
        return [
            self::VIEW => 'View',
            self::CREATE => 'Create',
            self::EDIT => 'Edit',
            self::DELETE => 'Delete',
        ];
    }

    /**
     * Get descriptions for the available actions.
     *
     * @return array An array containing descriptions for the actions.
     */
    public static function descriptions(): array
    {
        return [
            self::VIEW => 'Represents a view action.',
            self::CREATE => 'Represents a create action.',
            self::EDIT => 'Represents an edit action.',
            self::DELETE => 'Represents a delete action.',
        ];
    }
}
