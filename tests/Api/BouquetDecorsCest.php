<?php


namespace Tests\Api;

use App\Models\Bouquet;
use App\Models\Decor;
use App\Models\User;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class BouquetDecorsCest
{
    use WithFaker;

    public function testGetBouquetDecors(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->hasAttached(Decor::factory(),
                ['bouquet_decors_amount' => $this->faker->randomNumber(2)]
            )
            ->create();

        $I->sendGet("/bouquet-decors/" . $bouquet->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

       $I->seeResponseContainsJson([
            'bouquetDecors' => [
                'user_id' => $bouquet->user_id,
                'total_price' => (int)$bouquet->total_price,
                'decors' => [
                    [
                        'name' => $bouquet->decors()->first()->name,
                        'color' => $bouquet->decors()->first()->color,
                        'price' => $bouquet->decors()->first()->price,
                        'storage_decors_amount' => $bouquet->decors()->first()->storage_decors_amount,
                        'img_path' => $bouquet->decors()->first()->img_path,
                        'pivot' => [
                            'id' => $bouquet->decors()->first()->pivot->id,
                            'bouquet_id' => $bouquet->decors()->first()->pivot->bouquet_id,
                            'decor_id' => $bouquet->decors()->first()->pivot->decor_id,
                            'bouquet_decors_amount' => $bouquet->decors()->first()->pivot->bouquet_decors_amount,
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testCreateBouquetDecors(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();
        $decor = Decor::factory()->create();

        $data = [
            'bouquet_id' => $bouquet->id,
            'decor_id' => $decor->id,
            'bouquet_decors_amount' => $this->faker->randomNumber(2),
        ];

        $I->sendPost("/bouquet-decors", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquet_id' => $data['bouquet_id'],
            'decor_id' => $data['decor_id'],
            'bouquet_decors_amount' => $data['bouquet_decors_amount'],
        ]);

        $I->seeRecord('bouquet_decor', [
            'bouquet_id' => $data['bouquet_id'],
            'decor_id' => $data['decor_id'],
            'bouquet_decors_amount' => $data['bouquet_decors_amount'],
        ]);
    }

    public function testDeleteBouquetDecors(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->hasAttached(Decor::factory(),
                ['bouquet_decors_amount' => $this->faker->randomNumber(2)]
            )
            ->create();

        $bouquetDecorsData = [
            'id' => $bouquet->decors()->first()->pivot->id,
            'bouquet_id' => $bouquet->decors()->first()->pivot->bouquet_id,
            'decor_id' => $bouquet->decors()->first()->pivot->decor_id,
            'bouquet_decors_amount' => $bouquet->decors()->first()->pivot->bouquet_decors_amount,
        ];

        $I->sendDelete("/bouquet-decors/" . $bouquet->decors()->first()->pivot->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquetDecors' => true,
        ]);

        $I->dontSeeRecord('bouquet_decor', $bouquetDecorsData);
    }
}
