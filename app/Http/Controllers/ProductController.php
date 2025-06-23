<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Banner;
use App\Http\Controllers\Admin\BannerController;
class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        
        foreach ($products as $product) {
            Log::info('Trang chủ - Product: ' . $product->name . ', Image URL: ' . asset('storage/products/' . $product->image));
        }
        $mainBanner = Banner::where('type', 'main')
                            ->where('is_active', true)
                            ->orderBy('position')
                            ->first();
        $smallBanners = Banner::where('type', 'small')
                             ->where('is_active', true)
                             ->orderBy('position')
                             ->take(5) // Fetch up to 5 small banners
                             ->get();
        return view('products.index', compact('categories', 'products', 'mainBanner', 'smallBanners'));
    }
    public function show(Product $product)
{
    $product->load('category');
    \Log::info('Product Show: ', ['product' => $product->toArray(), 'category' => $product->category]);
    if (!$product) {
        abort(404); // Đảm bảo lỗi 404 được hiển thị
    }
    return view('products.show', compact('product'));
}
    /* public function show(Product $product)
    {
        $product->load('category'); // Eager-load the category relationship
        return view('products.show', compact('product'));
    } */
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with('category')
            ->where('name', 'LIKE', "%{$query}%")
            ->get();
        return view('products.index', compact('products'));
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID
        $categories = Category::all(); // Lấy danh sách danh mục
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, $id)
    {
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'nullable',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'stock' => 'required|integer|min:0',
    ]);

    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->category_id = $request->category_id;
    $product->stock = $request->stock;

    // Nếu có ảnh mới được tải lên, lưu ảnh mới
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->save();

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

}