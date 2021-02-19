<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Seller;
use App\Models\Buyer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $seller = Seller::has('products')->get()->random();
        $buyer = User::all()->except($seller->id)->random();

        return [
            'quantity' => $this->faker->numberBetween(2, 3),
            'buyer_id' => $buyer->id,
            'product_id' => $seller->products()->first()->id,
        ];
    }
}
