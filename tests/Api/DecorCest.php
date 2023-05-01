<?php


namespace Tests\Api;

use App\Models\Decor;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class DecorCest
{
    use WithFaker;

    public function testGetDecorsPaginated(ApiTester $I): void
    {
        $this->setUpFaker();

        Decor::factory()->count(15)->create();
        $decor = Decor::first();

        $I->sendGet("/decors");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'decors' => [
                'current_page' => 1,
                'data' => [
                    [
                        'name' => $decor->name,
                        'color' => $decor->color,
                        'price' => $decor->price,
                        'storage_decors_amount' => $decor->storage_decors_amount,
                        'img_path' => $decor->img_path,
                    ]
                ]
            ]

        ]);
    }

    public function testGetDecor(ApiTester $I): void
    {
        $this->setUpFaker();

        $decor = Decor::factory()->create();

        $I->sendGet("/decors/" . $decor->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'name' => $decor->name,
            'color' => $decor->color,
            'price' => $decor->price,
            'storage_decors_amount' => $decor->storage_decors_amount,
            'img_path' => $decor->img_path,
        ]);
    }

    public function testCreateDecor(ApiTester $I): void
    {
        $this->setUpFaker();

        $data = [
            'name' => $this->faker->firstNameFemale(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3),
            'storage_decors_amount' => $this->faker->randomNumber(2),
            'img_path' => $this->faker->imageUrl(),
        ];

        $I->sendPost("/decors", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'name' => $data['name'],
            'color' => $data['color'],
            'price' => $data['price'],
            'storage_decors_amount' => $data['storage_decors_amount'],
            'img_path' => $data['img_path'],
        ]);

        $I->seeRecord('decors', [
            'name' => $data['name'],
            'color' => $data['color'],
            'price' => $data['price'],
            'storage_decors_amount' => $data['storage_decors_amount'],
            'img_path' => $data['img_path'],
        ]);
    }

    public function testUpdateDecor(ApiTester $I): void
    {
        $this->setUpFaker();

        $decor = Decor::factory()->create();

        $dataToUpdate = [
            'name' => $this->faker->firstNameFemale(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3),
            'storage_decors_amount' => $this->faker->randomNumber(2),
            'img_path' => $this->faker->imageUrl(),
        ];

        $I->sendPut("/decors/" . $decor->id, $dataToUpdate);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'decor' => [
                'name' => $dataToUpdate['name'],
                'color' => $dataToUpdate['color'],
                'price' => $dataToUpdate['price'],
                'storage_decors_amount' => $dataToUpdate['storage_decors_amount'],
                'img_path' => $dataToUpdate['img_path'],
            ]
        ]);

        $I->seeRecord('decors', [
            'name' => $dataToUpdate['name'],
            'color' => $dataToUpdate['color'],
            'price' => $dataToUpdate['price'],
            'storage_decors_amount' => $dataToUpdate['storage_decors_amount'],
            'img_path' => $dataToUpdate['img_path'],
        ]);
    }

    public function testDeleteDecor(ApiTester $I): void
    {
        $this->setUpFaker();

        $decor = Decor::factory()->create();

        $I->sendDelete("/decors/" . $decor->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'decor' => true,
        ]);

        $I->dontSeeRecord('decors', [
            'name' => $decor->name,
            'color' => $decor->color,
            'price' => $decor->price,
            'storage_decors_amount' => $decor->storage_decors_amount,
            'img_path' => $decor->img_path,
        ]);
    }
}
