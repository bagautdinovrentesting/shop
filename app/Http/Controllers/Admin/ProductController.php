<?php

namespace App\Http\Controllers\Admin;

use App\GroupProperty;
use App\Http\Controllers\Controller;
use App\Property;
use App\Section;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Class ProductController
 * @package App\Http\Controllers\Admin
 */
class ProductController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role->slug === 'admin')
            $products = Product::with('section')->get();
        else
            $products = User::find($user->id)->products;


        return view('admin.products.list', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $sections = Section::all();

        return view('admin.products.create', ['sections' => $sections]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateProduct($request);

        $data = $this->getProductData($request);

        if ($request->has('section'))
        {
            $section = Section::find($request->input('section'));
            $section->products()->create($data);
        }

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен');
    }

    /**
     * Validate product forms (create, update)
     *
     * @param Request $request
     */
    public function validateProduct(Request $request) : void
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'section' => 'required',
            'detail_photo' => 'image',
            'preview_photo' => 'image'
        ]);
    }

    /**
     * Get product data from request for store and update methods
     *
     * @param Request $request
     *
     * @return array
     */
    public function getProductData(Request $request) : array
    {
        $data = $request->except(
            '_token',
            '_method',
            'section',
            'status',
            'delete_detail_photo',
            'delete_preview_photo',
            'properties'
        );

        if ($request->hasFile('preview_photo')) {
            $data['preview_photo'] = $request->file('preview_photo')->store('products', ['disk' => 'public']);
        }

        if ($request->hasFile('detail_photo')) {
            $data['detail_photo'] = $request->file('detail_photo')->store('products', ['disk' => 'public']);
        }

        $data['status'] = $request->has('status') ? $request->input('status') : 0;

        $data['user_id'] = $request->user()->id;

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory
     */

    public function edit($id)
    {
        $product = Product::with('section', 'values', 'values.property')->findOrFail($id);

        $this->authorize('update', $product);

        $sections = Section::all();
        $groups = GroupProperty::with('properties', 'properties.values')->get();
        $productProperties = array();

        foreach ($product->values as $value)
        {
            $productProperties[$value->property->id] = $value->id;
        }

        return view('admin.products.edit', ['product' => $product, 'sections' => $sections, 'groups' => $groups, 'productProperties' => $productProperties]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->authorize('update', $product);

        $this->validateProduct($request);

        $data = $this->getProductData($request);

        if ($request->has('section') && Section::find($request->input('section')))
            $data['section_id'] = $request->input('section');

        $product->update($data);

        if ($request->has('properties'))
        {
            $arValues = array();

            foreach($request->properties as $propertyId => $valueId)
            {
                if (!empty($valueId))
                    $arValues[str_random(5)] = ['property_value_id' => $valueId, 'property_id' => $propertyId];
            }
            //dd($arValues);
            $product->values()->detach();
            $product->values()->attach($arValues);
            //$product->values()->sync($arValues);
        }

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $this->authorize('delete', $product);

        Product::destroy($id);

        request()->session()->flash('success', 'Товар успешно удален!');

        return redirect()->route('admin.products.index');
    }
}
