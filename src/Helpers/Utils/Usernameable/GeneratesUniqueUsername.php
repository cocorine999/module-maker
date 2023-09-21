<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Usernameable;

trait GeneratesUniqueUsername
{

    public function generateUsernameFromName($firstName, $lastName)
    {
        $baseUsername = strtolower($firstName . '.' . $lastName);
        $username = $baseUsername;
        $counter = 1;

        while ($this->usernameExists($username)) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Generate and set a unique username for the model.
     */
    public function generateAndSetUsername()
    {
        if ($this->shouldGenerateUsernameOnCreate() || $this->shouldGenerateUsernameOnUpdate()) {
            $username = $this->generateUniqueUsername($this->getUsernameAttributes());
            $this->setAttribute($this->getUsernameColumn(), $username);
        }
    }

    /**
     * Generate a unique username based on the provided source attributes.
     *
     * @param array $attributes
     * @return string
     */
    protected function generateUniqueUsername(array $attributes): string
    {
        $username = $this->getUsernameOptions()->generateUsername($attributes);

        if ($this->getUsernameOptions()->shouldGenerateUniqueUsernames()) {
            $originalUsername = $username;
            $counter = 2;

            while ($this->usernameExists($username)) {
                $username = $originalUsername . '-' . $counter;
                $counter++;
            }
        }

        return $username;
    }

    /**
     * Check if a username should be generated on create.
     *
     * @return bool
     */
    protected function shouldGenerateUsernameOnCreate()
    {
        return !$this->getAttribute($this->getUsernameColumn()) && $this->getUsernameOptions()->shouldGenerateUsernamesOnCreate();
    }

    /**
     * Check if a username should be generated on update.
     *
     * @return bool
     */
    protected function shouldGenerateUsernameOnUpdate()
    {
        return $this->getUsernameOptions()->shouldGenerateUsernamesOnUpdate();
    }


    /**
     * Check if the given slug already exists in the database.
     * Return true if the slug exists, otherwise return false.
     *
     * @param string $slug The slug to be checked.
     * @return bool
     */
    public function isSlugExistsInDatabase(string $slug): bool
    {
        $slugAttribute = $this->getSlugOptions()->getSlugAttribute();
        return $this->model->where($slugAttribute, $slug)
            ->where('id', '<>', $this->model->getKey())
            ->exists();
    }

    public function changeUsername($newUsername)
    {
        if ($this->validateUsername($newUsername) && !$this->usernameExists($newUsername)) {
            $this->username = $newUsername;
            $this->save();

            return true;
        }

        return false;
    }

    public function generateUsernameSuggestions($input)
    {
        $suggestions = [];
        // Logic to generate username suggestions based on the input
        // You can implement various strategies here, like adding numbers or appending random characters.
        
        return $suggestions;
    }

    public function isUsernameAvailable($username)
    {
        return !$this->usernameExists($username);
    }

    public function isUsernameAvailableForEdit($newUsername)
    {
        return !$this->usernameExists($newUsername) || $this->attributes['username'] === $newUsername;
    }

    public function isUsernameValidCharacters($username)
    {
        // Define a regular expression to check for valid characters
        $pattern = '/^[a-zA-Z0-9_]+$/';

        return preg_match($pattern, $username);
    }

    public function generateTemporaryUsername($user)
    {
        // Logic to generate a temporary username based on user data
    }

    public function generateUsernameSuggestionsFromEmail($email)
    {
        // Generate suggestions like "john.doe" from "john.doe@example.com."
        // Ensure suggestions are unique and meet your username requirements.
    }

    public function getUsernameLengthError($username)
    {
        $minLength = 5;
        $maxLength = 20;

        $length = strlen($username);

        if ($length < $minLength || $length > $maxLength) {
            return 'Username must be between ' . $minLength . ' and ' . $maxLength . ' characters.';
        }

        return null; // No error
    }
}