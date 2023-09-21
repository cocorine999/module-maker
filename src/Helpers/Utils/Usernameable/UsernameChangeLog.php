<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Usernameable;

use Illuminate\Support\Carbon;

trait UsernameChangeLog
{

    public function logUsernameChange($oldUsername, $newUsername)
    {
        $this->usernameHistory()->create([
            'user_id' => $this->id,
            'old_username' => $oldUsername,
            'new_username' => $newUsername,
        ]);
    }

    public function getUsernameChangeHistory()
    {
        return $this->usernameHistory()->latest()->get();
    }

    public function usernameHistory()
    {
        return $this->hasMany(UsernameHistory::class);
    }

    public function getUsernameChangedAtAttribute()
    {
        return $this->usernameHistory->latest()->first()->created_at ?? $this->created_at;
    }

    
    public function canChangeUsername()
    {
        // Check if a cooldown period has passed since the last username change.
        $cooldownPeriodInHours = 24; // You can customize this value.
    
        if (!$this->last_username_change_at) {
            // If the user has never changed their username, they can change it now.
            return true;
        }
    
        $lastChangeTimestamp = strtotime($this->last_username_change_at);
        $currentTimestamp = strtotime(Carbon::now());
    
        // Calculate the time elapsed in hours since the last username change.
        $hoursElapsed = ($currentTimestamp - $lastChangeTimestamp) / 3600;
    
        // Check if the cooldown period has passed.
        return $hoursElapsed >= $cooldownPeriodInHours;
    }
}