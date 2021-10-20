<?php

namespace App\Services\Elastic;

use App\Http\Requests\ProductSearchRequest;
use App\Product;
use App\Section;
use Elasticsearch\Client;
use Illuminate\Database\Query\Expression;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductSearch
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(ProductSearchRequest $request, int $perPage)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $query = $request->get('query');

        $response = $this->client->search([
            'index' => 'products',
            'body' => [
                '_source' => ['id'],
                'from' => ($page - 1) * $perPage,
                'size' => $perPage,
                'sort' => [
                    ['updated_at' => ['order' => 'desc']],
                ],
                'query' => [
                    'bool' => [
                        'must' => array_merge(
                            [
                                ['term' => ['status' => Product::STATUS_ACTIVE]],
                            ],
                            array_filter([
                                !empty($query) ? ['multi_match' => [
                                    'query' => $query,
                                    'fields' => [ 'name^3', 'description' ]
                                ]] : false,
                            ]),
                        )
                    ],
                ],
            ],
        ]);

        $ids = array_column($response['hits']['hits'], '_id');

        if ($ids) {
            $products = Product::whereIn('id', $ids)
                ->orderBy(new Expression('FIELD(id,' . implode(',', $ids) . ')'))
                ->get();
            $pagination = new LengthAwarePaginator($products, $response['hits']['total']['value'], $perPage, $page);
        } else {
            $pagination = new LengthAwarePaginator([], 0, $perPage, $page);
        }

        $pagination->withPath('search')->appends('query', $query);

        return $pagination;
    }

    public function productsQuery(Section $section, int $perPage, int $currentPage) : array
    {
        $response = $this->client->search([
            'index' => 'products',
            'body' => [
                '_source' => ['id'],
                'from' => ($currentPage - 1) * $perPage,
                'size' => $perPage,
                'sort' => [
                    ['updated_at' => ['order' => 'asc']],
                ],
                'query' => [
                    'bool' => [
                        'must' => array_merge(
                            [
                                ['term' => ['status' => Product::STATUS_ACTIVE]],
                                ['term' => ['section' => $section->id]],
                            ],
                        )
                    ],
                ],
            ],
        ]);

        $ids = array_column($response['hits']['hits'], '_id');

        return [$ids, $response['hits']['total']['value']];
    }

    public function propertyAggregate(Section $section) : array
    {
        $response = $this->client->search([
            'index' => 'products',
            'body' => [
                '_source' => ['id'],
                'aggs' => [
                    'facets' => [
                        'filter' => [
                            'bool' => [
                                'must' => array_merge(
                                    [
                                        ['term' => ['status' => Product::STATUS_ACTIVE]],
                                        ['term' => ['section' => $section->id]],
                                    ],
                                )
                            ]
                        ],
                        'aggs' => [
                            'aggs_props' => [
                                'nested' => [
                                    'path' => 'values'
                                ],
                                'aggs' => [
                                    'props' => [
                                        'terms' => ['field' => 'values.property'],
                                        'aggs' => [
                                            'values' => [
                                                'terms' => [
                                                    'size' => 100,
                                                    'field' => 'values.value',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ],
                ],
            ],
        ]);

        return $response['aggregations']['facets']['aggs_props']['props']['buckets'];
    }

    public function productsQueryWithFilter(Section $section, int $perPage, int $currentPage, array $filterProperties)
    {
        $response = $this->client->search([
            'index' => 'products',
            'body' => [
                '_source' => ['id'],
                'from' => ($currentPage - 1) * $perPage,
                'size' => $perPage,
                'sort' => [
                    ['updated_at' => ['order' => 'asc']],
                ],
                'query' => [
                    'bool' => [
                        'must' => array_merge(
                            [
                                ['term' => ['status' => Product::STATUS_ACTIVE]],
                                ['term' => ['section' => $section->id]],
                            ],
                            array_map(function ($value, $id) {
                                return [
                                    'nested' => [
                                        'path' => 'values',
                                        'query' => [
                                            'bool' => [
                                                'must' => array_values([
                                                    ['term' => ['values.property' => $id]],
                                                    ['bool' => [
                                                        'should' => array_map(function ($singleValue) {
                                                            return ['term' => ['values.value' => $singleValue]];
                                                        }, $value),]
                                                    ]
                                                ]),
                                            ],
                                        ],
                                    ],
                                ];
                            }, $filterProperties, array_keys($filterProperties))
                        )
                    ],
                ],
            ],
        ]);

        $ids = array_column($response['hits']['hits'], '_id');

        return [$ids, $response['hits']['total']['value']];
    }

    public function propertyAggregateWithFilter(Section $section, array $filterProperties) : array
    {
        $filterPropsByOtherProps = [];

        foreach ($filterProperties as $propertyIndex => $values) {
            $filterPropsByOtherProps[$propertyIndex] = array_filter($filterProperties, function($prop, $innerPropIndex) use ($propertyIndex){
                return $innerPropIndex !== $propertyIndex;
            }, ARRAY_FILTER_USE_BOTH);
        }

        array_walk($filterPropsByOtherProps, function(&$properties, $propertyIndex, $section){
            $properties = [
                'filter' => [
                    'bool' => [
                        'must' => array_merge(
                            [
                                ['term' => ['status' => Product::STATUS_ACTIVE]],
                                ['term' => ['section' => $section->id]],
                            ],
                            array_map(function ($values, $innerPropertyIndex) {
                                return [
                                    'nested' => [
                                        'path' => 'values',
                                        'query' => [
                                            'bool' => [
                                                'must' => array_values([
                                                    ['term' => ['values.property' => $innerPropertyIndex]],
                                                    [
                                                        'bool' => [
                                                            'should' => array_map(function ($singleValue) {
                                                                return ['term' => ['values.value' => $singleValue]];
                                                            }, $values),
                                                        ]
                                                    ]
                                                ]),
                                            ],
                                        ],
                                    ],
                                ];
                            }, $properties, array_keys($properties))
                        )
                    ]
                ],
                'aggs' => [
                    'facets' => [
                        'nested' => [
                            'path' => 'values'
                        ],
                        'aggs' => [
                            'aggs_special' => [
                                'filter' => [
                                    'match' => [
                                        'values.property' => $propertyIndex
                                    ]
                                ],
                                'aggs' => [
                                    'props' => [
                                        'terms' => ['field' => 'values.property'],
                                        'aggs' => [
                                            'values' => [
                                                'terms' => [
                                                    'size' => 100,
                                                    'field' => 'values.value',
                                                ],
                                            ],
                                        ],
                                    ]
                                ]
                            ],
                        ],
                    ]
                ]

            ];
        }, $section);

        $response = $this->client->search([
            'index' => 'products',
            'body' => [
                '_source' => ['id'],
                'aggs' => [
                    'all_props' => [
                        'filter' => [
                            'bool' => [
                                'must' => array_merge(
                                    [
                                        ['term' => ['status' => Product::STATUS_ACTIVE]],
                                        ['term' => ['section' => $section->id]],
                                    ],
                                    array_map(function ($value, $id) {
                                        return [
                                            'nested' => [
                                                'path' => 'values',
                                                'query' => [
                                                    'bool' => [
                                                        'must' => array_values([
                                                            ['term' => ['values.property' => $id]],
                                                            [
                                                                'bool' => [
                                                                    'should' => array_map(function ($singleValue) {
                                                                        return ['term' => ['values.value' => $singleValue]];
                                                                    }, $value),
                                                                ]
                                                            ]
                                                        ]),
                                                    ],
                                                ],
                                            ],
                                        ];
                                    }, $filterProperties, array_keys($filterProperties))
                                )
                            ]
                        ],
                        'aggs' => [
                            'facets' => [
                                'nested' => [
                                    'path' => 'values'
                                ],
                                'aggs' => [
                                    'props' => [
                                        'terms' => [
                                            'field' => 'values.property',
                                            'size' => 100
                                        ],
                                        'aggs' => [
                                            'values' => [
                                                'terms' => [
                                                    'size' => 100,
                                                    'field' => 'values.value',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ]] + $filterPropsByOtherProps,
            ],
        ]);

        return $response['aggregations'];
    }
}
