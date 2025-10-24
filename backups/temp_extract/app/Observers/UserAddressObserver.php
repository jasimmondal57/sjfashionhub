<?php

namespace App\Observers;

use App\Models\UserAddress;
use App\Models\UserChangeLog;
use App\Models\GoogleSheetsSetting;
use Illuminate\Support\Facades\Log;

class UserAddressObserver
{
    /**
     * Handle the UserAddress "created" event.
     */
    public function created(UserAddress $userAddress): void
    {
        try {
            // Log the address creation
            UserChangeLog::logChange(
                $userAddress->user_id,
                'address_add',
                'new_address',
                null,
                $userAddress->toArray()
            );

            // Sync to Google Sheets
            $this->syncToGoogleSheets($userAddress, 'create');

            Log::info("Address created for user: {$userAddress->user_id}");
        } catch (\Exception $e) {
            Log::error("Failed to log address creation: " . $e->getMessage());
        }
    }

    /**
     * Handle the UserAddress "updated" event.
     */
    public function updated(UserAddress $userAddress): void
    {
        try {
            // Get the changed fields
            $changes = [];
            foreach ($userAddress->getDirty() as $field => $newValue) {
                $oldValue = $userAddress->getOriginal($field);
                if ($oldValue !== $newValue) {
                    $changes[$field] = [
                        'old' => $oldValue,
                        'new' => $newValue
                    ];
                }
            }

            if (!empty($changes)) {
                // Log each field change
                UserChangeLog::logMultipleChanges(
                    $userAddress->user_id,
                    'address_update',
                    $changes
                );

                // Sync to Google Sheets
                $this->syncToGoogleSheets($userAddress, 'update');

                Log::info("Address updated for user: {$userAddress->user_id}", $changes);
            }
        } catch (\Exception $e) {
            Log::error("Failed to log address update: " . $e->getMessage());
        }
    }

    /**
     * Handle the UserAddress "deleted" event.
     */
    public function deleted(UserAddress $userAddress): void
    {
        try {
            // Log the address deletion
            UserChangeLog::logChange(
                $userAddress->user_id,
                'address_delete',
                'deleted_address',
                $userAddress->toArray(),
                null
            );

            // Sync to Google Sheets
            $this->syncToGoogleSheets($userAddress, 'delete');

            Log::info("Address deleted for user: {$userAddress->user_id}");
        } catch (\Exception $e) {
            Log::error("Failed to log address deletion: " . $e->getMessage());
        }
    }

    /**
     * Sync address data to Google Sheets
     */
    private function syncToGoogleSheets(UserAddress $userAddress, string $operation): void
    {
        try {
            // Sync to user_addresses sheet
            $addressSetting = GoogleSheetsSetting::where('sheet_type', 'user_addresses')
                ->where('is_active', true)
                ->first();

            if ($addressSetting) {
                $addressData = [
                    'address_id' => $userAddress->id,
                    'user_id' => $userAddress->user_id,
                    'user_name' => $userAddress->user->name ?? '',
                    'user_email' => $userAddress->user->email ?? '',
                    'address_type' => $userAddress->address_type,
                    'first_name' => $userAddress->first_name,
                    'last_name' => $userAddress->last_name,
                    'company' => $userAddress->company,
                    'address_line_1' => $userAddress->address_line_1,
                    'address_line_2' => $userAddress->address_line_2,
                    'city' => $userAddress->city,
                    'state' => $userAddress->state,
                    'postal_code' => $userAddress->postal_code,
                    'country' => $userAddress->country,
                    'phone' => $userAddress->phone,
                    'is_default' => $userAddress->is_default ? 'Yes' : 'No',
                    'created_at' => $userAddress->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $userAddress->updated_at->format('Y-m-d H:i:s'),
                ];

                $addressSetting->syncData($addressData, $operation);
            }

            // Also update the main users sheet with updated address count
            $userSetting = GoogleSheetsSetting::where('sheet_type', 'users')
                ->where('is_active', true)
                ->first();

            if ($userSetting && $userAddress->user) {
                $user = $userAddress->user;
                $user->loadCount(['orders', 'addresses']);
                $user->loadSum('orders', 'total_amount');
                
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
                    'total_orders' => $user->orders_count,
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
                    'total_addresses' => $user->addresses_count,
                    'default_address' => $defaultAddress ? 
                        $defaultAddress->address_line_1 . ', ' . $defaultAddress->city . ', ' . $defaultAddress->state : 
                        'None',
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                ];

                $userSetting->syncData($userData, 'update');
            }

        } catch (\Exception $e) {
            Log::error("Failed to sync address to Google Sheets: " . $e->getMessage());
        }
    }
}
