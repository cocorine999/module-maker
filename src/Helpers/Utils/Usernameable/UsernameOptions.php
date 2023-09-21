<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

class UsernameOptions
{
    private $usernameSettings;
    private $temporaryUsernameSettings;
    private $aliasSettings;


    public function __construct(
        UsernameSettings $usernameSettings,
        TemporaryUsernameSettings $temporaryUsernameSettings,
        AliasSettings $aliasSettings
    ) {
        $this->usernameSettings = $usernameSettings;
        $this->temporaryUsernameSettings = $temporaryUsernameSettings;
        $this->aliasSettings = $aliasSettings;
    }

    /**
     * Get the options for slug generation.
     *
     * @return UsernameOptions
     */
    public static function create(): UsernameOptions
    {
        return new static();
    }

    protected function getUsernameOptions(): self
    {
        return UsernameOptions::create();
    }
    
    public function getUsernameSettings(): UsernameSettings
    {
        return $this->usernameSettings;
    }

    public function getTemporaryUsernameSettings(): TemporaryUsernameSettings
    {
        return $this->temporaryUsernameSettings;
    }

    public function getAliasSettings(): AliasSettings
    {
        return $this->aliasSettings;
    }

}
