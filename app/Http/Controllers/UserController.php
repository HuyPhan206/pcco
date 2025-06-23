<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Address;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure only authenticated users can access this page
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:15',
            'birth_day' => 'required|integer|between:1,31',
            'birth_month' => 'required|integer|between:1,12',
            'birth_year' => 'required|integer|between:1900,' . date('Y'),
            'avatar' => 'nullable|image|max:20480',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete the old avatar if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store the new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Update other fields
        $user->name = $validated['name'];
        $user->gender = $validated['gender'];
        $user->phone = $validated['phone'];
        $user->birth_date = $validated['birth_year'] . '-' . str_pad($validated['birth_month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($validated['birth_day'], 2, '0', STR_PAD_LEFT);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Thông tin đã được cập nhật thành công!');
    }
    public function addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses;
        return view('user.addresses', compact('user', 'addresses'));
    }

    public function storeAddress(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        // If this is the first address, make it the default
        $isDefault = $user->addresses()->count() === 0 ? true : ($request->has('is_default') ? true : false);

        // If this address is set as default, unset the default flag for other addresses
        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create([
            'address' => $validated['address'],
            'city' => $validated['city'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
            'is_default' => $isDefault,
        ]);

        return redirect()->route('user.addresses')->with('success', 'Địa chỉ đã được thêm thành công!');
    }

    public function editAddress(Address $address)
    {
        $this->authorize('update', $address); // Ensure the address belongs to the user
        $user = Auth::user();
        $addresses = $user->addresses; // Fetch the user's addresses
        return view('user.addresses', compact('user', 'addresses', 'address'));
    }

    public function updateAddress(Request $request, Address $address)
    {
        $this->authorize('update', $address); // Ensure the address belongs to the user

        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        $isDefault = $request->has('is_default') ? true : false;

        // If this address is set as default, unset the default flag for other addresses
        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address->update([
            'address' => $validated['address'],
            'city' => $validated['city'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
            'is_default' => $isDefault,
        ]);

        return redirect()->route('user.addresses')->with('success', 'Địa chỉ đã được cập nhật thành công!');
    }

    public function deleteAddress(Address $address)
    {
        $this->authorize('delete', $address); // Ensure the address belongs to the user
        $address->delete();
        return redirect()->route('user.addresses')->with('success', 'Địa chỉ đã được xóa thành công!');
    }

    public function setDefaultAddress(Address $address)
    {
        $this->authorize('update', $address); // Ensure the address belongs to the user

        $user = Auth::user();
        // Unset the default flag for all addresses
        $user->addresses()->update(['is_default' => false]);
        // Set the selected address as default
        $address->update(['is_default' => true]);

        return redirect()->route('user.addresses')->with('success', 'Địa chỉ mặc định đã được cập nhật!');
    }
}