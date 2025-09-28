<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'status',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'last_login_at',
        'email_marketing_consent',
        'sms_marketing_consent',
        'notes',
        'provider',
        'provider_id',
        'phone_verified_at',
        'login_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
            'email_marketing_consent' => 'boolean',
            'sms_marketing_consent' => 'boolean',
            'phone_verified_at' => 'datetime',
        ];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'manager', 'super_admin']);
    }

    public function scopeSuperAdmins($query)
    {
        return $query->where('role', 'super_admin');
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }

        return $this->date_of_birth->age;
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Generate Gravatar URL as fallback
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
    }

    // Helper methods
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'manager', 'super_admin']);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isProfileComplete()
    {
        $requiredFields = ['name', 'email'];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    public function isPhoneVerified()
    {
        return !is_null($this->phone_verified_at);
    }

    public function isEmailVerified()
    {
        return !is_null($this->email_verified_at);
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isRegularAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function canManageUsers()
    {
        return in_array($this->role, ['super_admin']);
    }

    public function canManageAdmins()
    {
        return $this->role === 'super_admin';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
