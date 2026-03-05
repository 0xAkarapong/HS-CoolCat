<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $products = Product::query()
            ->with(['user'])
            ->active()
            ->when(request('search'), fn ($q, $search) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
            )
            ->when(request('category'), fn ($q, $category) => $q->category($category))
            ->when(request('in_stock'), fn ($q) => $q->inStock())
            ->when(request('min_price'), fn ($q, $min) => $q->where('price', '>=', $min))
            ->when(request('max_price'), fn ($q, $max) => $q->where('price', '<=', $max))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product-images', 'public');
        }

        $product = $request->user()->products()->create($data);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $this->authorize('view', $product);

        $product->load(['user', 'reviews.user']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('product-images', 'public');
        }

        $product->update($data);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product removed successfully.');
    }
}
