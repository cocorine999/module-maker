<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

class UsernameOptions
{
    private $generateUniqueUsernames;
    private $generateUsernamesOnCreate;
    private $generateUsernamesOnUpdate;
    private $minUsernameLength;
    private $maxUsernameLength;
    private $allowedCharacters;
    private $usernameFormat;
    private $reservedUsernames;
    private $usernameValidationRules;
    private $usernamePrefix;
    private $usernameSuffix;
    private $caseSensitiveUsernames;
    private $usernameChangeCooldown;
    private $usernameHistoryLimit;
    private $usernameBlacklist;
    private $enableUsernameSuggestions;
    private $automaticUsernameGeneration;
    private $customUsernameGenerationCallback;
    private $reservedPrefixes;
    private $characterReplacementRules;
    private $enableUsernameVisibility;
    private $enableUsernameChangeLog;
    private $usernameChangeLimitPerDay;
    private $usernameHistoryRetentionPeriod;
    private $usernameChangeAuditLog;
    private $usernameChangeAuditLogRetentionPeriod;
    private $usernameChangeAuditLogEnabled;
    private $usernameChangeLimit;
    private $usernameExpiry;
    private $uniqueUsernamesAcrossRoles;
    private $usernameHistoryPruning;
    private $usernameModeration;
    private $aliasSupport;
    private $usernameLengthByRole;
    private $usernameTransferability;
    private $reservedWords;
    private $usernameCensorship;
    private $usernameGenerationTemplates;
    private $usernameBanning;
    private $usernameFormatValidation;
    private $usernameCharacterLimit;
    private $characterReplacementForProfanity;
    private $usernameTransferLogs;
    private $customUsernameValidationCallback;

    private $enforceUniqueEmailAsUsername;
    private $usernameChangeApprovalRequired;
    private $usernameChangeApprovalPolicy;
    private $enforceCaseSensitiveUsernames;
    private $usernameChangeCooldownByRole;
    private $usernameHistoryPruningPolicy;
    private $usernameHistoryPruningThreshold;
    private $usernameModerationPolicy;
    private $usernameModerationThreshold;
    private $maximumAliasCount;
    private $aliasValidationRules;
    private $aliasCooldownPeriod;
    private $aliasExpiryPeriod;
    private $aliasTransferability;
    private $reservedAliasWords;
    private $aliasCensorship;
    private $automaticAliasGeneration;
    private $customAliasGenerationCallback;
    private $aliasBanning;
    private $aliasFormatValidation;
    private $aliasCharacterLimit;
    private $aliasTransferLogs;
    private $customAliasValidationCallback;


    public function __construct(
        bool $generateUniqueUsernames = true,
        bool $generateUsernamesOnCreate = true,
        bool $generateUsernamesOnUpdate = true,
        int $minUsernameLength = 5,
        int $maxUsernameLength = 20,
        string $allowedCharacters = 'a-zA-Z0-9_',
        string $usernameFormat = '{firstname}{lastname}',
        array $reservedUsernames = [],
        array $usernameValidationRules = [],
        string $usernamePrefix = '',
        string $usernameSuffix = '',
        bool $caseSensitiveUsernames = false,
        int $usernameChangeCooldown = 30, // 30 days
        int $usernameHistoryLimit = 10,
        array $usernameBlacklist = [],
        bool $enableUsernameSuggestions = true,
        bool $automaticUsernameGeneration = true,
        callable $customUsernameGenerationCallback = null,
        array $reservedPrefixes = [],
        array $characterReplacementRules = [],
        bool $enableUsernameVisibility = true,
        bool $enableUsernameChangeLog = true,
        int $usernameChangeLimit = 5, // Maximum allowed username changes
        int $usernameExpiry = 365,// Username expires after 365 days

        bool $uniqueUsernamesAcrossRoles = true,
        bool $usernameHistoryPruning = true,
        bool $usernameModeration = false,
        bool $aliasSupport = false,
        array $usernameLengthByRole = [],
        bool $usernameTransferability = false,
        array $reservedWords = [],
        bool $usernameCensorship = false,
        array $usernameGenerationTemplates = [],
        bool $usernameBanning = false,
        array $usernameFormatValidation = [],
        int $usernameCharacterLimit = 30,
        bool $characterReplacementForProfanity = true,
        bool $usernameTransferLogs = false,
        callable $customUsernameValidationCallback = null,
        bool $enforceUniqueEmailAsUsername = false,
        bool $usernameChangeApprovalRequired = false,
        string $usernameChangeApprovalPolicy = 'admin_approval',
        bool $enforceCaseSensitiveUsernames = true,
        array $usernameChangeCooldownByRole = [],
        string $usernameHistoryPruningPolicy = 'auto_prune',
        int $usernameHistoryPruningThreshold = 100,
        string $usernameModerationPolicy = 'auto_moderate',
        int $usernameModerationThreshold = 10,
        int $maximumAliasCount = 5,
        array $aliasValidationRules = [],
        int $aliasCooldownPeriod = 30,
        int $aliasExpiryPeriod = 365,
        bool $aliasTransferability = false,
        array $reservedAliasWords = [],
        bool $aliasCensorship = false,
        bool $automaticAliasGeneration = true,
        callable $customAliasGenerationCallback = null,
        bool $aliasBanning = false,
        array $aliasFormatValidation = [],
        int $aliasCharacterLimit = 30,
        bool $aliasTransferLogs = false,
        callable $customAliasValidationCallback = null,

    ) {
        // Initialize properties here...
    }

    // Getter methods for options...
}
