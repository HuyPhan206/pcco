<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // Correct import for the Category model
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        // Giả định có model Category
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $price = $request->price;
    $discountPrice = $request->discount_price;

    if ($discountPrice !== null && $discountPrice >= $price) {
        return redirect()->back()->withErrors(['discount_price' => 'Giá giảm không được lớn hơn hoặc bằng giá gốc.'])->withInput();
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|integer|min:0',
        'discount_price' => 'nullable|numeric',
        'image' => 'nullable|image|max:20480',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
    ]);

    $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

    Product::create([
        'price' => $price,
        'discount_price' => $discountPrice,
        'image' => $imagePath,
        'category_id' => $request->category_id,
        'stock' => $request->stock,
    ]);

    return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm.');
}
public function update(Request $request, Product $product)
    {
        // Kiểm tra và điều chỉnh discount_price trước khi validate
        $price = $request->price;
        $discountPrice = $request->discount_price;

        if ($discountPrice !== null && $discountPrice >= $price) {
            return redirect()->back()->withErrors(['discount_price' => 'Giá giảm không được lớn hơn hoặc bằng giá gốc.'])->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'discount_price' => 'nullable|numeric',
            'image' => 'nullable|image|max:20480',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : $product->image;
if ($request->hasFile('image')) {
        Storage::disk('public')->delete($product->image);
        $imagePath = $request->file('image')->store('products', 'public');
    } else {
        $imagePath = $product->image;
    }
        $product->update([
            'price' => $price,
            'discount_price' => $discountPrice,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    

    // Thêm method destroy
    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa.');
    }
}