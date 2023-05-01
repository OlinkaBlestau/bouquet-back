<?php


namespace Tests\Api;

use App\Models\Bouquet;
use App\Models\User;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class BouquetCest
{
    use WithFaker;

    public function testGetBouquetsPaginated(ApiTester $I): void
    {
        $this->setUpFaker();

        Bouquet::factory()->count(15)
            ->for(User::factory()->create())
            ->create();
        $bouquet = Bouquet::first();

        $I->sendGet("/bouquets");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquets' => [
                'current_page' => 1,
                'data' => [
                    [
                        'user_id' => $bouquet->user_id,
                        'total_price' => $bouquet->total_price,
                    ]
                ]
            ]

        ]);
    }

    public function testGetBouquet(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();

        $I->sendGet("/bouquets/" . $bouquet->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'user_id' => $bouquet->user_id,
            'total_price' => $bouquet->total_price,
        ]);
    }

    public function testCreateBouquet(ApiTester $I): void
    {
        $this->setUpFaker();

        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'total_price' => $this->faker->randomNumber(3),
        ];

        $I->sendPost("/bouquets", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'user_id' => $data['user_id'],
            'total_price' => $data['total_price'],
        ]);

        $I->seeRecord('bouquets', [
            'user_id' => $data['user_id'],
            'total_price' => $data['total_price'],
        ]);
    }

    public function testUpdateBouquet(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();

        $dataToUpdate = [
            'user_id' => $bouquet->user_id,
            'total_price' => $this->faker->randomNumber(4),
        ];

        $I->sendPut("/bouquets/" . $bouquet->id, $dataToUpdate);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquet' => [
                'user_id' => $bouquet->user_id,
                'total_price' => $dataToUpdate['total_price']
            ]
        ]);

        $I->seeRecord('bouquets', [
            'user_id' => $bouquet->user_id,
            'total_price' => $dataToUpdate['total_price']
        ]);
    }

    public function testDeleteBouquet(ApiTester $I): void
    {
        $this->setUpFaker();

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();

        $I->sendDelete("/bouquets/" . $bouquet->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquet' => true,
        ]);

        $I->dontSeeRecord('bouquets', [
            'user_id' => $bouquet->user_id,
            'total_price' => $bouquet->total_price,
        ]);
    }
}
