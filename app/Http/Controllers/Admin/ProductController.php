<?php

namespace App\Http\Controllers\Admin;

use App\GroupProperty;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Section;
use App\Services\Product\ProductService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role->slug === 'admin') {
            $products = Product::with('section')->get();
        } else {
            $products = $user->products;
        }

        return view('admin.products.list', ['products' => $products]);
    }

    /**
     * @return View
     */
    public function create()
    {
        $sections = Section::all();

        return view('admin.products.create', ['sections' => $sections]);
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $this->service->createProduct($request);

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory
     */

    public function edit($id)
    {
        $product = Product::with('section', 'values', 'values.property')->findOrFail($id);

        $this->authorize('update', $product);

        $sections = Section::all();
        $groups = GroupProperty::with('properties', 'properties.values')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'sections' => $sections,
            'groups' => $groups,
            'productProperties' => $product->getProperties()
        ]);
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $this->service->updateProduct($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно обновлен');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->values()->detach();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно удален!');
    }
}
