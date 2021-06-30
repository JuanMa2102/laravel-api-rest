<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with('category')->paginate();
        return $product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:150'], 
            'description' => ['required', 'max:200'],
            'price' => ['required','numeric','min:0'],
            'category_id' => ['required']

         ]);
 
         $product = Product::create([
             'name' => $request->input('name'),
             'description' => $request->input('description'),
             'price' => $request->input('price'),
             'category_id' => $request->input('category_id')
         ]);

         $product = Product::with('category')->findOrFail($product->id);
 
         return ProductResource::make($product);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:150'], 
            'description' => ['required', 'max:200'],
            'price' => ['required','numeric','min:0'],
            'category_id' => ['required']
         ]);
         
         $product = Product::findOrFail($id);
         
         $product->name = $request->input('name');
         $product->description = $request->input('description');
         $product->price = $request->input('price');
         $product->category_id = $request->input('category_id');
         $product->save();

         $product = Product::with('category')->findOrFail($id);

         return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $product->delete();
        return ProductResource::make($product);
    }
}
