<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaintenanceController extends Controller
{
    /**
     * Show maintenance mode settings page
     */
    public function index()
    {
        $settings = MaintenanceSetting::getCurrent();
        return view('admin.maintenance.index', compact('settings'));
    }

    /**
     * Toggle maintenance mode
     */
    public function toggle(Request $request)
    {
        $settings = MaintenanceSetting::getCurrent();
        
        if ($settings->is_enabled) {
            // Disable maintenance mode
            MaintenanceSetting::disable();
            Log::info('Maintenance mode disabled', ['admin_id' => auth()->id()]);
            return back()->with('success', 'Maintenance mode has been disabled. Site is now live!');
        } else {
            // Enable maintenance mode
            $password = $request->input('password');
            MaintenanceSetting::enable($password, auth()->id());
            Log::info('Maintenance mode enabled', [
                'admin_id' => auth()->id(),
                'has_password' => !empty($password),
            ]);
            return back()->with('success', 'Maintenance mode has been enabled. Site is now in maintenance mode.');
        }
    }

    /**
     * Update maintenance settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'password' => 'nullable|string|min:4|max:255',
            'expected_end_at' => 'nullable|date|after:now',
        ]);

        $settings = MaintenanceSetting::getCurrent();
        $settings->title = $validated['title'];
        $settings->description = $validated['description'];
        $settings->expected_end_at = $validated['expected_end_at'] ?? null;

        if ($validated['password']) {
            $settings->password = bcrypt($validated['password']);
        }

        $settings->save();

        Log::info('Maintenance settings updated', ['admin_id' => auth()->id()]);
        return back()->with('success', 'Maintenance settings have been updated successfully.');
    }

    /**
     * Clear maintenance password
     */
    public function clearPassword()
    {
        $settings = MaintenanceSetting::getCurrent();
        $settings->password = null;
        $settings->save();

        Log::info('Maintenance password cleared', ['admin_id' => auth()->id()]);
        return back()->with('success', 'Maintenance password has been cleared.');
    }
}

