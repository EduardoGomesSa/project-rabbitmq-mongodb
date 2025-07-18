<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private Product $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function index() {
        return $this->product->all();
    }
}
