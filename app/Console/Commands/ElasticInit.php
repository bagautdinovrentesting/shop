<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class ElasticInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init elastic indexes';

    private $client;

    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client= $client;
    }

    public function handle()
    {
        try {
            $this->client->indices()->delete([
                'index' => 'products'
            ]);
        } catch (Missing404Exception $e) {}

        $this->client->indices()->create([
            'index' => 'products',
            'body' => [
                'mappings' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'created_at' => [
                            'type' => 'date',
                        ],
                        'updated_at' => [
                            'type' => 'date',
                        ],
                        'name' => [
                            'type' => 'text',
                        ],
                        'description' => [
                            'type' => 'text',
                        ],
                        'price' => [
                            'type' => 'float',
                        ],
                        'status' => [
                            'type' => 'boolean',
                        ],
                        'section' => [
                            'type' => 'integer',
                        ],
                        'user' => [
                            'type' => 'integer',
                        ],
                        'values' => [
                            'type' => 'nested',
                            'properties' => [
                                'property' => [
                                    'type' => 'keyword'
                                ],
                                'value' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'ru_stopwords' => [
                                'type' => 'stop',
                                'stopwords' => 'а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with',
                            ],
                            "ru_stemmer" => [
                                "type" => "stemmer",
                                "language" => "russian",
                            ],
                            "en_stemmer" => [
                                "type" => "stemmer",
                                "language" => "english",
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                ],
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'ru_stemmer',
                                    'ru_stopwords',
                                    'en_stemmer',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
