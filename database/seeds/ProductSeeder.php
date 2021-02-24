<?php

use App\Property;
use App\PropertyValue;
use App\Section;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::select('id')->whereHas('role', function (Builder $query) {
            $query->where('level', '>=', 2);
        })->get();

        $sections = Section::select('id')->where('status', 1)->get();

        //$propertyValues = PropertyValue::select(['id', 'property_id'])->get();
        $properties = Property::with('values:id,property_id')->select(['id'])->get();

        factory(Product::class, 1000)->create([
            'user_id' => $users->random()->id,
            'section_id' => $sections->random()->id,
        ])->each(function ($product) use ($properties) {

            /*$randomValues = $propertyValues->random(rand(1, 8))
                ->pluck('property_id', 'id')
                ->map(function ($propertyId) {
                    return ['property_id' => $propertyId];
                });*/

            $randomProperties = $properties->random(rand(1, 8));
            $randomValues = [];

            foreach ($randomProperties as $property) {
                $randomValues[$property->values->random()->id] = ['property_id' => $property->id];
            }

            $product->values()->attach($randomValues);
        });

        /*Product::create([
            'name' => 'Acer Nitro 5 AN517-51-55RE',
            'description' => 'Ноутбук Acer Nitro 5 AN517-51-55RE с диагональю 17.3" – это игровое устройство.',
            'price' => 35000,
            'section_id' => 1,
            'user_id' => 1
        ]);*/
    }
}
