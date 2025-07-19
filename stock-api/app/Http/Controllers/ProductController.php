<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private Product $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function index() {
        $resource = ProductResource::collection($this->product->all());

        return $resource->response();
    }

    public function store(ProductRequest $request) {
        $productExit = $this->product->where('name', $request->name)->first();

        if($productExit) return response(['error'=>'produto ja existe!'], 401);

        $productSaved = $this->product->create($request->all());

        if(!$productSaved) return response(['error'=>'erro ao cadastrar produto'], 401);

        $resource = new ProductResource($productSaved);

        return $resource->response()->setStatusCode(201);
    }
}
