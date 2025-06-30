<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = User::query()
            ->where('role', 'customer') // Filter only customers
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customer.index', compact('users', 'search'));
    }

    /**
     * Display the specified customer.
     */
    public function show(User $user)
    {
        // Optional: Ensure only customers can be viewed
        if ($user->role !== 'customer') {
            abort(403, 'Unauthorized: This user is not a customer.');
        }
        return view('admin.customer.show', compact('user'));
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(User $user)
    {
        // Optional: Ensure only customers can be deleted
        if ($user->role !== 'customer') {
            abort(403, 'Unauthorized: This user is not a customer.');
        }

        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
