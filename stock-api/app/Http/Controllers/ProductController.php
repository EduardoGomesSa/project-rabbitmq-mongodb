<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\RabbitMQ\RabbitMQPublisher;

class ProductController extends Controller
{
    private Product $product;
    private RabbitMQPublisher $publisher;

    public function __construct(RabbitMQPublisher $publisher)
    {
        $this->product = new Product();
        $this->publisher = $publisher;
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

        $this->publisher->publish('stock-events', [
            'productId' => $productSaved->id,
            'quantity' => $productSaved->amount,
            'event' => 'ProductCreated'
        ]);

        return $resource->response()->setStatusCode(201);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Product $product, ProductUpdateRequest $request)
    {
        $productUpdated = $product->update($request->all());

        if ($productUpdated > 0) return response(['message' => 'produto atualizado com sucesso'], 200);

        $this->publisher->publish('stock-events', [
            'productId' => $product->id,
            'quantity' => $product->amount,
            'event' => 'ProductUpdated'
        ]);

        return response(['error' => 'erro ao atualizar produto'], 402);
    }

    public function destroy(Product $product)
    {
        $productDeleted = $product->delete();

        if ($productDeleted > 0) return response(['message' => 'produto excluído com sucesso'], 200);

        $this->publisher->publish('stock-events', [
            'productId' => $product->id,
            'event' => 'ProductDeleted'
        ]);

        return response(['error' => 'erro ao excluír produto'], 402);
    }
}
