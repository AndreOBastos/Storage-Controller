<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductHistory as HistoryResource;
use App\Http\Resources\ProductHistoryCollection as HistoryCollection;
use App\Product;
use App\ProductHistory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return new ProductCollection(Product::all());
    }

    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'amount' => 'required',
            'price' => 'required'
        ]);

        $product = new Product;

        $product->name = $request->name;
        $product->description = $request->description;
        $product->amount = (int) $request->amount;
        $product->price = (float) $request->price;

        $product->save();

        $producthistory = new ProductHistory;

        $producthistory->product_id = Product::max('id') + 1;
        $producthistory->change_description = "Added Product {$producthistory->product_id}";

        $producthistory->save();

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function storeAll(Request $request)
    {
        $product_collection = [];
        foreach($request->values as $product_to_add){
            $product = new Product;

            $product->name = $product_to_add['name'];
            $product->description = $product_to_add['description'];
            $product->amount = (int) $product_to_add['amount'];
            $product->price = (float) $product_to_add['price'];

            $product->save();

            $producthistory = new ProductHistory;

            $producthistory->product_id = Product::max('id') + 1;
            $producthistory->change_description = "Added Product {$producthistory->product_id}";

            $producthistory->save();

            array_push($product_collection, $product);
        }

        return (new ProductCollection($product_collection))
            ->response()
            ->setStatusCode(201);
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'amount' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->amount = (int) $request->amount;
        $product->price = (float) $request->price;

        $product->save();

        $producthistory = new ProductHistory;

        $producthistory->product_id = $id;
        $producthistory->change_description = "Updated Product {$producthistory->product_id}";

        $producthistory->save();

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        $producthistory = new ProductHistory;

        $producthistory->product_id = $id;
        $producthistory->change_description = "Deleted Product {$producthistory->product_id}";

        $producthistory->save();

        return response()->json(null, 204);
    }

    public function history()
    {
        return new HistoryCollection(ProductHistory::all());
    }
}
