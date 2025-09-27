<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    /**
     * Display admin management dashboard
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'manager', 'super_admin']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $admins = $query->latest()->paginate(15);

        return view('admin.super-admin.index', compact('admins'));
    }

    /**
     * Show form to create new admin
     */
    public function create()
    {
        return view('admin.super-admin.create');
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,manager,super_admin',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'role', 'status']);
        $data['password'] = Hash::make($request->password);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.super-admin.index')
                        ->with('success', 'Admin created successfully!');
    }

    /**
     * Show admin details
     */
    public function show(User $admin)
    {
        // Ensure we're only showing admin users
        if (!$admin->isAdmin()) {
            abort(404);
        }

        return view('admin.super-admin.show', compact('admin'));
    }

    /**
     * Show form to edit admin
     */
    public function edit(User $admin)
    {
        // Ensure we're only editing admin users
        if (!$admin->isAdmin()) {
            abort(404);
        }

        // Prevent editing own account through this interface
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.profile.index')
                           ->with('info', 'Use the profile section to edit your own account.');
        }

        return view('admin.super-admin.edit', compact('admin'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, User $admin)
    {
        // Ensure we're only updating admin users
        if (!$admin->isAdmin()) {
            abort(404);
        }

        // Prevent updating own account through this interface
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.profile.index')
                           ->with('error', 'You cannot edit your own account through this interface.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,manager,super_admin',
            'status' => 'required|in:active,inactive,suspended',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'role', 'status']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $admin->update($data);

        return redirect()->route('admin.super-admin.index')
                        ->with('success', 'Admin updated successfully!');
    }

    /**
     * Delete admin
     */
    public function destroy(User $admin)
    {
        // Ensure we're only deleting admin users
        if (!$admin->isAdmin()) {
            abort(404);
        }

        // Prevent deleting own account
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Delete avatar if exists
        if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $admin->delete();

        return redirect()->route('admin.super-admin.index')
                        ->with('success', 'Admin deleted successfully!');
    }

    /**
     * Toggle admin status
     */
    public function toggleStatus(User $admin)
    {
        // Ensure we're only toggling admin users
        if (!$admin->isAdmin()) {
            abort(404);
        }

        // Prevent toggling own status
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own status!');
        }

        $newStatus = $admin->status === 'active' ? 'inactive' : 'active';
        $admin->update(['status' => $newStatus]);

        $action = $newStatus === 'active' ? 'activated' : 'deactivated';
        return back()->with('success', "Admin {$action} successfully!");
    }

    /**
     * Reset admin password
     */
    public function resetPassword(Request $request, User $admin)
    {
        // Ensure we're only resetting admin passwords
        if (!$admin->isAdmin()) {
            abort(404);
        }

        // Prevent resetting own password through this interface
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Use the profile section to change your own password.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password reset successfully!');
    }
}
