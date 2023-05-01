<?php


namespace Tests\Api;

use App\Models\Bouquet;
use App\Models\Flower;
use App\Models\User;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class BouquetFlowersCest
{
    use WithFaker;

    public function testGetBouquetFlowers(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->hasAttached(Flower::factory(),
                ['bouquet_flowers_amount' => $this->faker->randomNumber(2)]
            )
            ->create();

        $I->sendGet("/bouquet-flowers/" . $bouquet->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquetFlowers' => [
                'user_id' => $bouquet->user_id,
                'total_price' => (int)$bouquet->total_price,
                'flowers' => [
                    [
                        'name' => $bouquet->flowers()->first()->name,
                        'color' => $bouquet->flowers()->first()->color,
                        'price' => $bouquet->flowers()->first()->price,
                        'storage_flowers_amount' => $bouquet->flowers()->first()->storage_flowers_amount,
                        'img_path' => $bouquet->flowers()->first()->img_path,
                        'pivot' => [
                            'id' => $bouquet->flowers()->first()->pivot->id,
                            'bouquet_id' => $bouquet->flowers()->first()->pivot->bouquet_id,
                            'flower_id' => $bouquet->flowers()->first()->pivot->flower_id,
                            'bouquet_flowers_amount' => $bouquet->flowers()->first()->pivot->bouquet_flowers_amount,
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testCreateBouquetFlowers(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();
        $flower = Flower::factory()->create();

        $data = [
            'bouquet_id' => $bouquet->id,
            'flower_id' => $flower->id,
            'bouquet_flowers_amount' => $this->faker->randomNumber(2),
        ];

        $I->sendPost("/bouquet-flowers", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquet_id' => $data['bouquet_id'],
            'flower_id' => $data['flower_id'],
            'bouquet_flowers_amount' => $data['bouquet_flowers_amount'],
        ]);

        $I->seeRecord('bouquet_flower', [
            'bouquet_id' => $data['bouquet_id'],
            'flower_id' => $data['flower_id'],
            'bouquet_flowers_amount' => $data['bouquet_flowers_amount'],
        ]);
    }

    public function testDeleteBouquetFlowers(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->hasAttached(Flower::factory(),
                ['bouquet_flowers_amount' => $this->faker->randomNumber(2)]
            )
            ->create();

        $bouquetDecorsData = [
            'id' => $bouquet->flowers()->first()->pivot->id,
            'bouquet_id' => $bouquet->flowers()->first()->pivot->bouquet_id,
            'flower_id' => $bouquet->flowers()->first()->pivot->flower_id,
            'bouquet_flowers_amount' => $bouquet->flowers()->first()->pivot->bouquet_flowers_amount,
        ];

        $I->sendDelete("/bouquet-flowers/" . $bouquet->flowers()->first()->pivot->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquetFlowers' => true,
        ]);

        $I->dontSeeRecord('bouquet_flower', $bouquetDecorsData);
    }
}
