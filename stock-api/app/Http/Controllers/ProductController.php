<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index()
    {
        $resource = ProductResource::collection($this->product->all());

        return $resource->response();
    }

    public function store(ProductRequest $request)
    {
        $productExit = $this->product->where('name', $request->name)->first();

        if ($productExit) return response(['error' => 'produto ja existe!'], 401);

        $productSaved = $this->product->create($request->all());

        if (!$productSaved) return response(['error' => 'erro ao cadastrar produto'], 401);

        $resource = new ProductResource($productSaved);

        return $resource->response()->setStatusCode(201);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Product $product, ProductUpdateRequest $request){
        $productUpdated = $product->update($request->all());

        if($productUpdated > 0) return response(['message' => 'produto atualizado com sucesso'], 200);

        return response(['error' => 'erro ao atualizar produto'], 401);
    }
}
