<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserChangeLog;
use App\Models\GoogleSheetsSetting;
use App\Services\EmailNotificationService;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        try {
            // Log user creation
            UserChangeLog::logChange(
                $user->id,
                'user_registration',
                'new_user',
                null,
                $user->toArray()
            );

            // Sync to Google Sheets
            $this->syncToGoogleSheets($user, 'create');

            // Only send welcome email to customers (not admin users)
            if ($user->role === 'customer' || !$user->role) {
                EmailNotificationService::sendWelcomeEmail($user);
                Log::info("Welcome email sent to user: {$user->email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send welcome email to user {$user->email}: " . $e->getMessage());
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        try {
            // Get the changed fields
            $changes = [];
            foreach ($user->getDirty() as $field => $newValue) {
                $oldValue = $user->getOriginal($field);
                if ($oldValue !== $newValue && $field !== 'updated_at') {
                    $changes[$field] = [
                        'old' => $oldValue,
                        'new' => $newValue
                    ];
                }
            }

            if (!empty($changes)) {
                // Log each field change
                UserChangeLog::logMultipleChanges(
                    $user->id,
                    'profile_update',
                    $changes
                );

                // Sync to Google Sheets
                $this->syncToGoogleSheets($user, 'update');

                // Log specific important changes
                if (isset($changes['email'])) {
                    Log::info("User email changed for user ID: {$user->id}", $changes['email']);
                }
                if (isset($changes['phone'])) {
                    Log::info("User phone changed for user ID: {$user->id}", $changes['phone']);
                }
                if (isset($changes['role'])) {
                    Log::info("User role changed for user ID: {$user->id}", $changes['role']);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to log user update: " . $e->getMessage());
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Log user deletion
        Log::info("User deleted: {$user->email}");
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // Log user restoration
        Log::info("User restored: {$user->email}");
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // Log user force deletion
        Log::info("User force deleted: {$user->email}");
    }

    /**
     * Sync user data to Google Sheets
     */
    private function syncToGoogleSheets(User $user, string $operation): void
    {
        try {
            $setting = GoogleSheetsSetting::where('sheet_type', 'users')
                ->where('is_active', true)
                ->first();

            if (!$setting) {
                return;
            }

            // Load relationships for comprehensive data
            $user->loadCount(['orders', 'addresses']);
            $user->loadSum('orders', 'total_amount');
            $user->load('addresses');

            $defaultAddress = $user->addresses->where('is_default', true)->first();

            $userData = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
                'registration_date' => $user->created_at->format('Y-m-d H:i:s'),
                'last_login' => $user->last_login_at?->format('Y-m-d H:i:s'),
                'total_orders' => $user->orders_count ?? 0,
                'total_spent' => $user->orders_sum_total_amount ?? 0,
                'address' => $user->address,
                'city' => $user->city,
                'state' => $user->state,
                'postal_code' => $user->postal_code,
                'country' => $user->country,
                'date_of_birth' => $user->date_of_birth?->format('Y-m-d'),
                'gender' => $user->gender,
                'email_marketing_consent' => $user->email_marketing_consent ? 'Yes' : 'No',
                'sms_marketing_consent' => $user->sms_marketing_consent ? 'Yes' : 'No',
                'total_addresses' => $user->addresses_count ?? 0,
                'default_address' => $defaultAddress ?
                    $defaultAddress->address_line_1 . ', ' . $defaultAddress->city . ', ' . $defaultAddress->state :
                    'None',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            ];

            $setting->syncData($userData, $operation);

        } catch (\Exception $e) {
            Log::error("Failed to sync user to Google Sheets: " . $e->getMessage());
        }
    }
}
