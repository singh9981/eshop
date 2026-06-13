<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Guard name
     */
    protected $guard = 'admin';

    /**
     * Table name
     */
    protected $table = 'admins';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',                 // super | admin
        'access_expiry_date',   // null for super admin
        'is_active'
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'access_expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    /* ---------------------------------
     |  Custom Helper Functions
     |---------------------------------*/

    /**
     * Check super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->type === 'super';
    }

    /**
     * Check admin access expired
     */
    public function isExpired(): bool
    {
        if ($this->isSuperAdmin()) {
            return false; // super admin never expires
        }

        if ($this->access_expiry_date === null) {
            return false;
        }

        return Carbon::now()->gt($this->access_expiry_date);
    }

    /**
     * Check admin active & valid
     */
    public function hasValidAccess(): bool
    {
        return $this->is_active && !$this->isExpired();
    }
}
