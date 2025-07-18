<?php

namespace App\Http\Controllers;

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
}
