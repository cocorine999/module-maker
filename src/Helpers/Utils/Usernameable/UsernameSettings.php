<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

class UsernameSettings
{

    private $generateUniqueUsernames = true;
    private $generateUsernamesOnCreate = true;
    private $generateUsernamesOnUpdate = true;
    private $minUsernameLength = 5;
    private $maxUsernameLength = 20;
    private $allowedCharacters = 'a-zA-Z0-9_';
    private $usernameFormat = 'alpha_numeric';
    private $reservedUsernames = ['admin', 'superuser'];
    private $usernameValidationRules = ['required', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'];
    private $usernamePrefix = '';
    private $usernameSuffix = '';
    private $caseSensitiveUsernames = false;
    private $usernameChangeCooldown = 30; // in days
    private $usernameHistoryLimit = 10;
    private $usernameBlacklist = ['banned', 'inappropriate'];
    private $enableUsernameSuggestions = true;
    private $automaticUsernameGeneration = true;
    private $customUsernameGenerationCallback = null;
    private $reservedPrefixes = ['test', 'dev'];
    private $characterReplacementRules = ['badword' => 'goodword'];
    private $enableUsernameVisibility = true;
    private $enableUsernameChangeLog = true;
    private $usernameChangeLimitPerDay = 5;
    private $usernameHistoryRetentionPeriod = 365; // in days
    private $usernameChangeAuditLog = true;
    private $usernameChangeAuditLogRetentionPeriod = 365; // in days
    private $usernameChangeAuditLogEnabled = true;
    private $usernameChangeLimit = 100;
    private $usernameExpiry = 30; // in days
    private $uniqueUsernamesAcrossRoles = false;
    private $usernameHistoryPruning = true;
    private $usernameModeration = false;
    private $aliasSupport = true;
    private $usernameLengthByRole = [
        'user' => 15,
        'admin' => 20,
    ];
    private $usernameTransferability = true;
    private $reservedWords = ['admin', 'superuser'];
    private $usernameCensorship = true;
    private $usernameGenerationTemplates = [
        'firstname.lastname' => '{first_name}.{last_name}',
    ];
    private $usernameBanning = true;
    private $usernameFormatValidation = true;
    private $usernameCharacterLimit = 20;
    private $characterReplacementForProfanity = true;
    private $usernameTransferLogs = true;
    private $customUsernameValidationCallback = null;


    private $enforceUniqueEmailAsUsername = false;
    private $usernameChangeApprovalRequired = false;
    private $usernameChangeApprovalPolicy = 'manual';
    private $enforceCaseSensitiveUsernames = false;
    private $usernameChangeCooldownByRole = [];
    private $usernameHistoryPruningPolicy = 'auto';
    private $usernameHistoryPruningThreshold = 100;
    private $usernameModerationPolicy = 'auto';
    private $usernameModerationThreshold = 10;
    private $maximumAliasCount = 10;
    private $aliasValidationRules = []; // Define alias validation rules
    private $aliasCooldownPeriod = 24; // in hours
    private $aliasExpiryPeriod = 30; // in days
    private $aliasTransferability = true;
    private $reservedAliasWords = ['reserved_alias'];
    private $aliasCensorship = true;
    private $automaticAliasGeneration = true;
    private $customAliasGenerationCallback = null;
    private $aliasBanning = true;
    private $aliasFormatValidation = true;
    private $aliasCharacterLimit = 20;
    private $aliasTransferLogs = true;
    private $customAliasValidationCallback = null;
    


    // Getter and Setter for $generateUniqueUsernames
    public function getGenerateUniqueUsernames(): bool
    {
        return $this->generateUniqueUsernames;
    }

    public function setGenerateUniqueUsernames(bool $generateUniqueUsernames): void
    {
        $this->generateUniqueUsernames = $generateUniqueUsernames;
    }

    // Getter and Setter for $generateUsernamesOnCreate
    public function getGenerateUsernamesOnCreate(): bool
    {
        return $this->generateUsernamesOnCreate;
    }

    public function setGenerateUsernamesOnCreate(bool $generateUsernamesOnCreate): void
    {
        $this->generateUsernamesOnCreate = $generateUsernamesOnCreate;
    }

    // Getter and Setter for $generateUsernamesOnUpdate
    public function getGenerateUsernamesOnUpdate(): bool
    {
        return $this->generateUsernamesOnUpdate;
    }

    public function setGenerateUsernamesOnUpdate(bool $generateUsernamesOnUpdate): void
    {
        $this->generateUsernamesOnUpdate = $generateUsernamesOnUpdate;
    }

    // Getter and Setter for $minUsernameLength
    public function getMinUsernameLength(): int
    {
        return $this->minUsernameLength;
    }

    public function setMinUsernameLength(int $minUsernameLength): void
    {
        $this->minUsernameLength = $minUsernameLength;
    }

    // Getter and Setter for $maxUsernameLength
    public function getMaxUsernameLength(): int
    {
        return $this->maxUsernameLength;
    }

    public function setMaxUsernameLength(int $maxUsernameLength): void
    {
        $this->maxUsernameLength = $maxUsernameLength;
    }

    // Getter and Setter for $allowedCharacters
    public function getAllowedCharacters(): string
    {
        return $this->allowedCharacters;
    }

    public function setAllowedCharacters(string $allowedCharacters): void
    {
        $this->allowedCharacters = $allowedCharacters;
    }

    // Getter and Setter for $usernameFormat
    public function getUsernameFormat(): string
    {
        return $this->usernameFormat;
    }

    public function setUsernameFormat(string $usernameFormat): void
    {
        $this->usernameFormat = $usernameFormat;
    }

    // Getter and Setter for $reservedUsernames
    public function getReservedUsernames(): array
    {
        return $this->reservedUsernames;
    }

    public function setReservedUsernames(array $reservedUsernames): void
    {
        $this->reservedUsernames = $reservedUsernames;
    }

    // Getter and Setter for $caseSensitiveUsernames
    public function getCaseSensitiveUsernames(): bool
    {
        return $this->caseSensitiveUsernames;
    }

    public function setCaseSensitiveUsernames(bool $caseSensitiveUsernames): void
    {
        $this->caseSensitiveUsernames = $caseSensitiveUsernames;
    }

    // Getter and Setter for $usernameChangeCooldown
    public function getUsernameChangeCooldown(): int
    {
        return $this->usernameChangeCooldown;
    }

    public function setUsernameChangeCooldown(int $usernameChangeCooldown): void
    {
        $this->usernameChangeCooldown = $usernameChangeCooldown;
    }

    // Getter and Setter for $usernameHistoryLimit
    public function getUsernameHistoryLimit(): int
    {
        return $this->usernameHistoryLimit;
    }

    public function setUsernameHistoryLimit(int $usernameHistoryLimit): void
    {
        $this->usernameHistoryLimit = $usernameHistoryLimit;
    }

    // Getter and Setter for $usernameBlacklist
    public function getUsernameBlacklist(): array
    {
        return $this->usernameBlacklist;
    }

    public function setUsernameBlacklist(array $usernameBlacklist): void
    {
        $this->usernameBlacklist = $usernameBlacklist;
    }

    // Getter and Setter for $enableUsernameSuggestions
    public function getEnableUsernameSuggestions(): bool
    {
        return $this->enableUsernameSuggestions;
    }

    public function setEnableUsernameSuggestions(bool $enableUsernameSuggestions): void
    {
        $this->enableUsernameSuggestions = $enableUsernameSuggestions;
    }

    // Getter and Setter for $automaticUsernameGeneration
    public function getAutomaticUsernameGeneration(): bool
    {
        return $this->automaticUsernameGeneration;
    }

    public function setAutomaticUsernameGeneration(bool $automaticUsernameGeneration): void
    {
        $this->automaticUsernameGeneration = $automaticUsernameGeneration;
    }

    // Getter and Setter for $customUsernameGenerationCallback
    public function getCustomUsernameGenerationCallback(): ?callable
    {
        return $this->customUsernameGenerationCallback;
    }

    public function setCustomUsernameGenerationCallback(?callable $customUsernameGenerationCallback): void
    {
        $this->customUsernameGenerationCallback = $customUsernameGenerationCallback;
    }

    // Getter and Setter for $reservedPrefixes
    public function getReservedPrefixes(): array
    {
        return $this->reservedPrefixes;
    }

    public function setReservedPrefixes(array $reservedPrefixes): void
    {
        $this->reservedPrefixes = $reservedPrefixes;
    }

    // Getter and Setter for $characterReplacementRules
    public function getCharacterReplacementRules(): array
    {
        return $this->characterReplacementRules;
    }

    public function setCharacterReplacementRules(array $characterReplacementRules): void
    {
        $this->characterReplacementRules = $characterReplacementRules;
    }

    // Getter and Setter for $enableUsernameVisibility
    public function getEnableUsernameVisibility(): bool
    {
        return $this->enableUsernameVisibility;
    }

    public function setEnableUsernameVisibility(bool $enableUsernameVisibility): void
    {
        $this->enableUsernameVisibility = $enableUsernameVisibility;
    }

    // Getter and Setter for $usernameChangeLog
    public function getUsernameChangeLog(): bool
    {
        return $this->enableUsernameChangeLog;
    }

    public function setUsernameChangeLog(bool $usernameChangeLog): void
    {
        $this->enableUsernameChangeLog = $usernameChangeLog;
    }

    // Getter and Setter for $usernameChangeLimitPerDay
    public function getUsernameChangeLimitPerDay(): int
    {
        return $this->usernameChangeLimitPerDay;
    }

    public function setUsernameChangeLimitPerDay(int $usernameChangeLimitPerDay): void
    {
        $this->usernameChangeLimitPerDay = $usernameChangeLimitPerDay;
    }

    // Getter and Setter for $usernameHistoryRetentionPeriod
    public function getUsernameHistoryRetentionPeriod(): int
    {
        return $this->usernameHistoryRetentionPeriod;
    }

    public function setUsernameHistoryRetentionPeriod(int $usernameHistoryRetentionPeriod): void
    {
        $this->usernameHistoryRetentionPeriod = $usernameHistoryRetentionPeriod;
    }

    // Getter and Setter for $usernameChangeAuditLog
    public function getUsernameChangeAuditLog(): bool
    {
        return $this->usernameChangeAuditLog;
    }

    public function setUsernameChangeAuditLog(bool $usernameChangeAuditLog): void
    {
        $this->usernameChangeAuditLog = $usernameChangeAuditLog;
    }

    // Getter and Setter for $usernameChangeAuditLogRetentionPeriod
    public function getUsernameChangeAuditLogRetentionPeriod(): int
    {
        return $this->usernameChangeAuditLogRetentionPeriod;
    }

    public function setUsernameChangeAuditLogRetentionPeriod(int $usernameChangeAuditLogRetentionPeriod): void
    {
        $this->usernameChangeAuditLogRetentionPeriod = $usernameChangeAuditLogRetentionPeriod;
    }

    // Getter and Setter for $usernameChangeAuditLogEnabled
    public function getUsernameChangeAuditLogEnabled(): bool
    {
        return $this->usernameChangeAuditLogEnabled;
    }

    public function setUsernameChangeAuditLogEnabled(bool $usernameChangeAuditLogEnabled): void
    {
        $this->usernameChangeAuditLogEnabled = $usernameChangeAuditLogEnabled;
    }

    // Getter and Setter for $usernameChangeLimit
    public function getUsernameChangeLimit(): int
    {
        return $this->usernameChangeLimit;
    }

    public function setUsernameChangeLimit(int $usernameChangeLimit): void
    {
        $this->usernameChangeLimit = $usernameChangeLimit;
    }

    // Getter and Setter for $usernameExpiry
    public function getUsernameExpiry(): int
    {
        return $this->usernameExpiry;
    }

    public function setUsernameExpiry(int $usernameExpiry): void
    {
        $this->usernameExpiry = $usernameExpiry;
    }

    // Getter and Setter for $uniqueUsernamesAcrossRoles
    public function getUniqueUsernamesAcrossRoles(): bool
    {
        return $this->uniqueUsernamesAcrossRoles;
    }

    public function setUniqueUsernamesAcrossRoles(bool $uniqueUsernamesAcrossRoles): void
    {
        $this->uniqueUsernamesAcrossRoles = $uniqueUsernamesAcrossRoles;
    }

    // Getter and Setter for $usernameHistoryPruning
    public function getUsernameHistoryPruning(): bool
    {
        return $this->usernameHistoryPruning;
    }

    public function setUsernameHistoryPruning(bool $usernameHistoryPruning): void
    {
        $this->usernameHistoryPruning = $usernameHistoryPruning;
    }

    // Getter and Setter for $usernameModeration
    public function getUsernameModeration(): bool
    {
        return $this->usernameModeration;
    }

    public function setUsernameModeration(bool $usernameModeration): void
    {
        $this->usernameModeration = $usernameModeration;
    }

    // Getter and Setter for $aliasSupport
    public function getAliasSupport(): bool
    {
        return $this->aliasSupport;
    }

    public function setAliasSupport(bool $aliasSupport): void
    {
        $this->aliasSupport = $aliasSupport;
    }

    // Getter and Setter for $usernameLengthByRole
    public function getUsernameLengthByRole(): array
    {
        return $this->usernameLengthByRole;
    }

    public function setUsernameLengthByRole(array $usernameLengthByRole): void
    {
        $this->usernameLengthByRole = $usernameLengthByRole;
    }

    // Getter and Setter for $usernameTransferability
    public function getUsernameTransferability(): bool
    {
        return $this->usernameTransferability;
    }

    public function setUsernameTransferability(bool $usernameTransferability): void
    {
        $this->usernameTransferability = $usernameTransferability;
    }

    // Getter and Setter for $reservedWords
    public function getReservedWords(): array
    {
        return $this->reservedWords;
    }

    public function setReservedWords(array $reservedWords): void
    {
        $this->reservedWords = $reservedWords;
    }


    // Getter and Setter for $usernameCensorship
    public function getUsernameCensorship(): bool
    {
        return $this->usernameCensorship;
    }

    public function setUsernameCensorship(bool $usernameCensorship): void
    {
        $this->usernameCensorship = $usernameCensorship;
    }

    // Getter and Setter for $usernameGenerationTemplates
    public function getUsernameGenerationTemplates(): array
    {
        return $this->usernameGenerationTemplates;
    }

    public function setUsernameGenerationTemplates(array $usernameGenerationTemplates): void
    {
        $this->usernameGenerationTemplates = $usernameGenerationTemplates;
    }

    // Getter and Setter for $usernameBanning
    public function getUsernameBanning(): bool
    {
        return $this->usernameBanning;
    }

    public function setUsernameBanning(bool $usernameBanning): void
    {
        $this->usernameBanning = $usernameBanning;
    }

    // Getter and Setter for $usernameFormatValidation
    public function getUsernameFormatValidation(): bool
    {
        return $this->usernameFormatValidation;
    }

    public function setUsernameFormatValidation(bool $usernameFormatValidation): void
    {
        $this->usernameFormatValidation = $usernameFormatValidation;
    }

    // Getter and Setter for $usernameCharacterLimit
    public function getUsernameCharacterLimit(): int
    {
        return $this->usernameCharacterLimit;
    }

    public function setUsernameCharacterLimit(int $usernameCharacterLimit): void
    {
        $this->usernameCharacterLimit = $usernameCharacterLimit;
    }

    // Getter and Setter for $characterReplacementForProfanity
    public function getCharacterReplacementForProfanity(): bool
    {
        return $this->characterReplacementForProfanity;
    }

    public function setCharacterReplacementForProfanity(bool $characterReplacementForProfanity): void
    {
        $this->characterReplacementForProfanity = $characterReplacementForProfanity;
    }

    // Getter and Setter for $usernameTransferLogs
    public function getUsernameTransferLogs(): bool
    {
        return $this->usernameTransferLogs;
    }

    public function setUsernameTransferLogs(bool $usernameTransferLogs): void
    {
        $this->usernameTransferLogs = $usernameTransferLogs;
    }

    // Getter and Setter for $customUsernameValidationCallback
    public function getCustomUsernameValidationCallback(): ?callable
    {
        return $this->customUsernameValidationCallback;
    }

    public function setCustomUsernameValidationCallback(?callable $customUsernameValidationCallback): void
    {
        $this->customUsernameValidationCallback = $customUsernameValidationCallback;
    }

    // Getter and Setter for $enforceUniqueEmailAsUsername
    public function getEnforceUniqueEmailAsUsername(): bool
    {
        return $this->enforceUniqueEmailAsUsername;
    }

    public function setEnforceUniqueEmailAsUsername(bool $enforceUniqueEmailAsUsername): void
    {
        $this->enforceUniqueEmailAsUsername = $enforceUniqueEmailAsUsername;
    }

    // Getter and Setter for $usernameChangeApprovalRequired
    public function getUsernameChangeApprovalRequired(): bool
    {
        return $this->usernameChangeApprovalRequired;
    }

    public function setUsernameChangeApprovalRequired(bool $usernameChangeApprovalRequired): void
    {
        $this->usernameChangeApprovalRequired = $usernameChangeApprovalRequired;
    }

    // Getter and Setter for $usernameChangeApprovalPolicy
    public function getUsernameChangeApprovalPolicy(): string
    {
        return $this->usernameChangeApprovalPolicy;
    }

    public function setUsernameChangeApprovalPolicy(string $usernameChangeApprovalPolicy): void
    {
        $this->usernameChangeApprovalPolicy = $usernameChangeApprovalPolicy;
    }

    // Getter and Setter for $enforceCaseSensitiveUsernames
    public function getEnforceCaseSensitiveUsernames(): bool
    {
        return $this->enforceCaseSensitiveUsernames;
    }

    public function setEnforceCaseSensitiveUsernames(bool $enforceCaseSensitiveUsernames): void
    {
        $this->enforceCaseSensitiveUsernames = $enforceCaseSensitiveUsernames;
    }

    // Getter and Setter for $usernameChangeCooldownByRole
    public function getUsernameChangeCooldownByRole(): array
    {
        return $this->usernameChangeCooldownByRole;
    }

    public function setUsernameChangeCooldownByRole(array $usernameChangeCooldownByRole): void
    {
        $this->usernameChangeCooldownByRole = $usernameChangeCooldownByRole;
    }

    // Getter and Setter for $usernameHistoryPruningPolicy
    public function getUsernameHistoryPruningPolicy(): string
    {
        return $this->usernameHistoryPruningPolicy;
    }

    public function setUsernameHistoryPruningPolicy(string $usernameHistoryPruningPolicy): void
    {
        $this->usernameHistoryPruningPolicy = $usernameHistoryPruningPolicy;
    }

    // Getter and Setter for $usernameHistoryPruningThreshold
    public function getUsernameHistoryPruningThreshold(): int
    {
        return $this->usernameHistoryPruningThreshold;
    }

    public function setUsernameHistoryPruningThreshold(int $usernameHistoryPruningThreshold): void
    {
        $this->usernameHistoryPruningThreshold = $usernameHistoryPruningThreshold;
    }


    // Getter and Setter for $usernameModerationPolicy
    public function getUsernameModerationPolicy(): string
    {
        return $this->usernameModerationPolicy;
    }

    public function setUsernameModerationPolicy(string $usernameModerationPolicy): void
    {
        $this->usernameModerationPolicy = $usernameModerationPolicy;
    }

    // Getter and Setter for $usernameModerationThreshold
    public function getUsernameModerationThreshold(): int
    {
        return $this->usernameModerationThreshold;
    }

    public function setUsernameModerationThreshold(int $usernameModerationThreshold): void
    {
        $this->usernameModerationThreshold = $usernameModerationThreshold;
    }

    // Getter and Setter for $maximumAliasCount
    public function getMaximumAliasCount(): int
    {
        return $this->maximumAliasCount;
    }

    public function setMaximumAliasCount(int $maximumAliasCount): void
    {
        $this->maximumAliasCount = $maximumAliasCount;
    }

    // Getter and Setter for $aliasValidationRules
    public function getAliasValidationRules(): array
    {
        return $this->aliasValidationRules;
    }

    public function setAliasValidationRules(array $aliasValidationRules): void
    {
        $this->aliasValidationRules = $aliasValidationRules;
    }

    // Getter and Setter for $aliasCooldownPeriod
    public function getAliasCooldownPeriod(): int
    {
        return $this->aliasCooldownPeriod;
    }

    public function setAliasCooldownPeriod(int $aliasCooldownPeriod): void
    {
        $this->aliasCooldownPeriod = $aliasCooldownPeriod;
    }

    

    // Getter and Setter for $aliasExpiryPeriod
    public function getAliasExpiryPeriod(): int
    {
        return $this->aliasExpiryPeriod;
    }

    public function setAliasExpiryPeriod(int $aliasExpiryPeriod): void
    {
        $this->aliasExpiryPeriod = $aliasExpiryPeriod;
    }

    // Getter and Setter for $aliasTransferability
    public function getAliasTransferability(): bool
    {
        return $this->aliasTransferability;
    }

    public function setAliasTransferability(bool $aliasTransferability): void
    {
        $this->aliasTransferability = $aliasTransferability;
    }

    // Getter and Setter for $reservedAliasWords
    public function getReservedAliasWords(): array
    {
        return $this->reservedAliasWords;
    }

    public function setReservedAliasWords(array $reservedAliasWords): void
    {
        $this->reservedAliasWords = $reservedAliasWords;
    }

    // Getter and Setter for $aliasCensorship
    public function getAliasCensorship(): bool
    {
        return $this->aliasCensorship;
    }

    public function setAliasCensorship(bool $aliasCensorship): void
    {
        $this->aliasCensorship = $aliasCensorship;
    }

    // Getter and Setter for $automaticAliasGeneration
    public function getAutomaticAliasGeneration(): bool
    {
        return $this->automaticAliasGeneration;
    }

    public function setAutomaticAliasGeneration(bool $automaticAliasGeneration): void
    {
        $this->automaticAliasGeneration = $automaticAliasGeneration;
    }



    // Getter and Setter for $customAliasGenerationCallback
    public function getCustomAliasGenerationCallback(): ?callable
    {
        return $this->customAliasGenerationCallback;
    }

    public function setCustomAliasGenerationCallback(?callable $customAliasGenerationCallback): void
    {
        $this->customAliasGenerationCallback = $customAliasGenerationCallback;
    }

    // Getter and Setter for $aliasBanning
    public function getAliasBanning(): bool
    {
        return $this->aliasBanning;
    }

    public function setAliasBanning(bool $aliasBanning): void
    {
        $this->aliasBanning = $aliasBanning;
    }

    // Getter and Setter for $aliasFormatValidation
    public function getAliasFormatValidation(): bool
    {
        return $this->aliasFormatValidation;
    }

    public function setAliasFormatValidation(bool $aliasFormatValidation): void
    {
        $this->aliasFormatValidation = $aliasFormatValidation;
    }

    // Getter and Setter for $aliasCharacterLimit
    public function getAliasCharacterLimit(): int
    {
        return $this->aliasCharacterLimit;
    }

    public function setAliasCharacterLimit(int $aliasCharacterLimit): void
    {
        $this->aliasCharacterLimit = $aliasCharacterLimit;
    }

    // Getter and Setter for $aliasTransferLogs
    public function getAliasTransferLogs(): bool
    {
        return $this->aliasTransferLogs;
    }

    public function setAliasTransferLogs(bool $aliasTransferLogs): void
    {
        $this->aliasTransferLogs = $aliasTransferLogs;
    }


    // Setter for $usernameValidationRules
    public function setUsernameValidationRules(array $usernameValidationRules): void
    {
        $this->usernameValidationRules = $usernameValidationRules;
    }

    public function getUsernameValidationRules(): array
    {
        return $this->usernameValidationRules;
    }

    // Setter for $usernamePrefix
    public function getUsernamePrefix(): string
    {
        return $this->usernamePrefix;
    }

    public function setUsernamePrefix(string $usernamePrefix): void
    {
        $this->usernamePrefix = $usernamePrefix;
    }

    // Setter for $usernameSuffix
    public function getUsernameSuffix(): string
    {
        return $this->usernameSuffix;
    }

    public function setUsernameSuffix(string $usernameSuffix): void
    {
        $this->usernameSuffix = $usernameSuffix;
    }
    

    /**
     * Validate a username based on defined rules.
     *
     * @param string $username
     * @return bool True if the username is valid, false otherwise.
     */
    public function validateUsername(string $username): bool
    {
        // Implement validation logic here based on $usernameValidationRules
        // For example, you can check if $username meets the rules defined in $this->usernameValidationRules

        // Sample validation logic (customize as needed):
        $validationRules = $this->getUsernameValidationRules();

        foreach ($validationRules as $rule) {
            // Implement validation checks based on rules (e.g., 'required', 'unique', 'regex')
            if ($rule === 'required' && empty($username)) {
                return false;
            } elseif ($rule === 'unique') {
                // Check uniqueness of the username in your application's context
                // You may need to query your database to check for uniqueness
                if ($this->isUsernameUnique($username)) {
                    return false;
                }
            } elseif ($rule === 'regex' && !preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                return false;
            }
        }

        // If no validation errors were found, the username is considered valid.
        return true;
    }

    /**
     * Sanitize a username based on defined rules.
     *
     * @param string $username
     * @return string Sanitized username.
     */
    public function sanitizeUsername(string $username): string
    {
        // Implement sanitization logic here if needed.
        // For example, you can trim whitespace and apply other rules.

        // Sample sanitization logic (customize as needed):
        $sanitizedUsername = trim($username);

        // Apply additional sanitization rules as required

        return $sanitizedUsername;
    }

    /**
     * Check if a username is unique in your application's context.
     *
     * @param string $username
     * @return bool True if the username is unique, false otherwise.
     */
    private function isUsernameUnique(string $username): bool
    {
        // Implement database query to check if the username is unique in your application's context.
        // You can use your application's database connection and query the 'users' table.

        // Sample implementation (customize for your application):
        // Assuming you have access to your database connection, you can perform a query like this:
        // $result = $this->db->query("SELECT COUNT(*) FROM users WHERE username = ?", [$username]);
        // $count = $result->fetchColumn();
        // return $count === 0; // If count is 0, the username is unique.

        // Replace this with your database query logic.
        return true; // For demonstration purposes, always return true.
    }

    // Method to generate a username based on a template
    public function generateUsername(string $template, array $userData): string
    {
        // Implement logic to generate a username based on the provided template and user data
        // For example, if the template is 'firstname.lastname', you can combine the user's first and last names

        // Example implementation:
        $firstName = $userData['first_name'] ?? '';
        $lastName = $userData['last_name'] ?? '';
        $generatedUsername = strtolower($firstName . '.' . $lastName);

        // You can add additional logic and templates based on your requirements

        return $generatedUsername;
    }

    // Method to check if a generated username is unique
    public function isGeneratedUsernameUnique(string $generatedUsername): bool
    {
        // Implement your unique username validation logic here
        // You may need to query your database to check if the generated username already exists

        // For now, we'll assume the generated username is not unique
        return false;
    }

    // Method to apply a template to data and replace placeholders
    private function applyTemplate(string $template, array $data): string
    {
        // Implement logic to replace placeholders in the template with data values
        // For example, replace '{first_name}' with the user's first name
        foreach ($data as $placeholder => $value) {
            $template = str_replace('{' . $placeholder . '}', $value, $template);
        }

        return $template;
    }

    // Method to generate a username based on a template
    public function generateUsernameFromTemplate(array $data): string
    {
        // Implement logic to generate a username from a template using the provided data
        // You can define different templates in your settings and choose one based on your application's logic
        // Example template: '{first_name}.{last_name}'
        $template = $this->getUsernameGenerationTemplate();
        $username = $this->applyTemplate($template, $data);

        return $username;
    }

    // Method to make a non-unique username unique (example implementation)
    private function makeUsernameUnique(string $username): string
    {
        // Implement your logic to make a non-unique username unique
        // You can append numbers, random characters, or use any custom logic

        // For now, we'll append a random number to the username
        $uniqueUsername = $username . rand(1, 999);

        return $uniqueUsername;
    }

}
