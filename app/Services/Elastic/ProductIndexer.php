<?php

namespace App\Services\Elastic;

use App\Product;
use App\PropertyValue;
use Elasticsearch\Client;

class ProductIndexer
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Product $product): void
    {
        $sections = [];

        if ($section = $product->section) {
            do {
                $sections[] = $section->id;
            } while ($section = $section->parent);
        }

        $this->client->index([
            'index' => 'products',
            'id' => $product->id,
            'body' => [
                'id' => $product->id,
                'created_at' => $product->created_at ? $product->created_at->format(DATE_ATOM) : null,
                'updated_at' => $product->updated_at ? $product->updated_at->format(DATE_ATOM) : null,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'status' => $product->status,
                'section' => $sections ?: [0],
                'user' => $product->user_id,
                'values' => array_map(function (PropertyValue $value) {
                    return [
                        'property' => $value->property_id,
                        'value' => $value->id,
                    ];
                }, $product->values->all()),
            ],
        ]);
    }

    public function remove(Product $product): void
    {
        $this->client->delete([
            'index' => 'products',
            'id' => $product->id,
        ]);
    }

    public function clear(): void
    {
        $this->client->deleteByQuery([
            'index' => 'products',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ],
            ],
        ]);
    }
}
