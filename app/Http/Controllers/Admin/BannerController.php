<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('position')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:10240',
            'description' => 'nullable|string',
            'type' => 'required|in:main,small',
            'position' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean', // Allow nullable to handle unchecked checkbox
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'type' => $request->type,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? 1 : 0, // Convert checkbox to boolean
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được thêm.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:20480', // Image is optional on update
            'description' => 'nullable|string',
            'type' => 'required|in:main,small',
            'position' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean', // Allow nullable to handle unchecked checkbox
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($banner->image);
            // Upload new image
            $imagePath = $request->file('image')->store('banners', 'public');
        } else {
            $imagePath = $banner->image;
        }

        $banner->update([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
            'type' => $request->type,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? 1 : 0, // Convert checkbox to boolean
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật.');
    }

    public function destroy(Banner $banner)
    {
        // Delete image from storage
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa.');
    }
}