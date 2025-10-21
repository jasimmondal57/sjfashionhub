<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSetting;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Show maintenance page
     */
    public function show()
    {
        $settings = MaintenanceSetting::getCurrent();
        
        if (!$settings->is_enabled) {
            return redirect('/');
        }

        return view('maintenance', [
            'settings' => $settings,
            'requiresPassword' => !empty($settings->password),
        ]);
    }

    /**
     * Verify maintenance password
     */
    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $settings = MaintenanceSetting::getCurrent();

        if (!$settings->is_enabled) {
            return redirect('/');
        }

        if (!$settings->password) {
            return redirect('/');
        }

        if ($settings->checkPassword($request->password)) {
            session(['maintenance_verified' => true]);
            return redirect('/')->with('success', 'Welcome! Maintenance mode access granted.');
        }

        return back()->with('error', 'Invalid password. Please try again.');
    }
}

