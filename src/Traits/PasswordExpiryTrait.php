<?php

namespace Larasoft\PasswordExpiry\Traits;

use Carbon\Carbon;
use Larasoft\PasswordExpiry\Models\PreviousPasswordHash;

trait PasswordExpirable
{
    public static function bootPasswordExpirable()
    {
        static::saving(function ($user) {
            $original = $user->getOriginal();
            if (!empty($original) && $user->password != $original['password']) {
                $user->previousPasswordHashes()->create([
                    'password_hash' => $user->password
                ]);
            }

            // track the previously used password hashes, so they can't be re-used
            $HashFound = $user->previousPasswordHashes()->where('password_hash', $user->password)->count();
            if ($HashFound) {
                return false;
            } else {
                return true;
            }
        });
    }

    public function previousPasswordHashes()
    {
        return $this->hasMany(PreviousPasswordHash::class);
    }

    /*
     * Get datetime when the current password was set
     */
    public function getCurrentPasswordSetTime()
    {
        return $this->previousPasswordHashes->last()->created_at;
    }

    /*
     * Check if user password is expired?
     */
    public function isPasswordExpired()
    {
        $days = config('passwordExpiry.expiry_days');

        if ($this->previousPasswordHashes()->count()) {
            return $this->previousPasswordHashes->last()->created_at <= Carbon::now()->subDays($days);
        } else {
            return false;
        }
    }

    /**
     * Format and get password expiry message
     */
    public function getPasswordExpiryMessage()
    {
        $days = config('password-expiry.expiry_days');
        $message = config('password-expiry.expiry_message');
        $message = str_replace(':number', $days, $message);

        return $message;
    }
}
