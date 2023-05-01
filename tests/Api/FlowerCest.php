<?php


namespace Tests\Api;

use App\Models\Flower;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class FlowerCest
{
    use WithFaker;

    public function testGetFlowersPaginated(ApiTester $I): void
    {
        $this->setUpFaker();

        Flower::factory()->count(15)->create();
        $flower = Flower::first();

        $I->sendGet("/flowers");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'flowers' => [
                'current_page' => 1,
                'data' => [
                    [
                        'name' => $flower->name,
                        'color' => $flower->color,
                        'price' => $flower->price,
                        'storage_flowers_amount' => $flower->storage_flowers_amount,
                        'img_path' => $flower->img_path,
                    ]
                ]
            ]

        ]);
    }

    public function testGetFlower(ApiTester $I): void
    {
        $this->setUpFaker();

        $flower = Flower::factory()->create();

        $I->sendGet("/flowers/" . $flower->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'name' => $flower->name,
            'color' => $flower->color,
            'price' => $flower->price,
            'storage_flowers_amount' => $flower->storage_flowers_amount,
            'img_path' => $flower->img_path,
        ]);
    }

    public function testCreateFlower(ApiTester $I): void
    {
        $this->setUpFaker();

        $data = [
            'name' => $this->faker->firstNameFemale(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3),
            'storage_flowers_amount' => $this->faker->randomNumber(2),
            'img_path' => $this->faker->imageUrl(),
        ];

        $I->sendPost("/flowers", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'name' => $data['name'],
            'color' => $data['color'],
            'price' => $data['price'],
            'storage_flowers_amount' => $data['storage_flowers_amount'],
            'img_path' => $data['img_path'],
        ]);

        $I->seeRecord('flowers', [
            'name' => $data['name'],
            'color' => $data['color'],
            'price' => $data['price'],
            'storage_flowers_amount' => $data['storage_flowers_amount'],
            'img_path' => $data['img_path'],
        ]);
    }

    public function testUpdateFlower(ApiTester $I): void
    {
        $this->setUpFaker();

        $flower = Flower::factory()->create();

        $dataToUpdate = [
            'name' => $this->faker->firstNameFemale(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3),
            'storage_flowers_amount' => $this->faker->randomNumber(2),
            'img_path' => $this->faker->imageUrl(),
        ];

        $I->sendPut("/flowers/" . $flower->id, $dataToUpdate);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'flower' => [
                'name' => $dataToUpdate['name'],
                'color' => $dataToUpdate['color'],
                'price' => $dataToUpdate['price'],
                'storage_flowers_amount' => $dataToUpdate['storage_flowers_amount'],
                'img_path' => $dataToUpdate['img_path'],
            ]
        ]);

        $I->seeRecord('flowers', [
            'name' => $dataToUpdate['name'],
            'color' => $dataToUpdate['color'],
            'price' => $dataToUpdate['price'],
            'storage_flowers_amount' => $dataToUpdate['storage_flowers_amount'],
            'img_path' => $dataToUpdate['img_path'],
        ]);
    }

    public function testDeleteFlower(ApiTester $I): void
    {
        $this->setUpFaker();

        $flower = Flower::factory()->create();

        $I->sendDelete("/flowers/" . $flower->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'flower' => true,
        ]);

        $I->dontSeeRecord('flowers', [
            'name' => $flower->name,
            'color' => $flower->color,
            'price' => $flower->price,
            'storage_flowers_amount' => $flower->storage_flowers_amount,
            'img_path' => $flower->img_path,
        ]);
    }
}
