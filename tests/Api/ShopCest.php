<?php


namespace Tests\Api;

use App\Models\Shop;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class ShopCest
{
    use WithFaker;

    public function testGetShopsPaginated(ApiTester $I): void
    {
        $this->setUpFaker();

        Shop::factory()->count(15)->create();
        $shop = Shop::first();

        $I->sendGet("/shops");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'shops' => [
                'current_page' => 1,
                'data' => [
                    [
                        'email' => $shop->email,
                        'phone' => $shop->phone,
                        'address' => $shop->address,
                        'telegram' => $shop->telegram,
                        'instagram' => $shop->instagram,
                        'facebook' => $shop->facebook,
                    ]
                ]
            ]

        ]);
    }

    public function testGetShop(ApiTester $I): void
    {
        $this->setUpFaker();

        $shop = Shop::factory()->create();

        $I->sendGet("/shops/" . $shop->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'email' => $shop->email,
            'phone' => $shop->phone,
            'address' => $shop->address,
            'telegram' => $shop->telegram,
            'instagram' => $shop->instagram,
            'facebook' => $shop->facebook,
        ]);
    }

    public function testCreateShop(ApiTester $I): void
    {
        $this->setUpFaker();

        $data = [
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'telegram' => 'https://t.me/flowers',
            'instagram' => 'https://instagram.com/flowers',
            'facebook' => 'https://facebook.com/flowers',
        ];

        $I->sendPost("/shops", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'telegram' => $data['telegram'],
            'instagram' => $data['instagram'],
            'facebook' => $data['facebook'],
        ]);

        $I->seeRecord('shops', [
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'telegram' => $data['telegram'],
            'instagram' => $data['instagram'],
            'facebook' => $data['facebook'],
        ]);
    }

    public function testUpdateShop(ApiTester $I): void
    {
        $this->setUpFaker();

        $shop = Shop::factory()->create();

        $dataToUpdate = [
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'telegram' => 'https://t.me/flowers',
            'instagram' => 'https://instagram.com/flowers',
            'facebook' => 'https://facebook.com/flowers',
        ];

        $I->sendPut("/shops/" . $shop->id, $dataToUpdate);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'shop' => [
                'email' => $dataToUpdate['email'],
                'phone' => $dataToUpdate['phone'],
                'address' => $dataToUpdate['address'],
                'telegram' => $dataToUpdate['telegram'],
                'instagram' => $dataToUpdate['instagram'],
                'facebook' => $dataToUpdate['facebook'],
            ]
        ]);

        $I->seeRecord('shops', [
            'email' => $dataToUpdate['email'],
            'phone' => $dataToUpdate['phone'],
            'address' => $dataToUpdate['address'],
            'telegram' => $dataToUpdate['telegram'],
            'instagram' => $dataToUpdate['instagram'],
            'facebook' => $dataToUpdate['facebook'],
        ]);
    }

    public function testDeleteShop(ApiTester $I): void
    {
        $this->setUpFaker();

        $shop = Shop::factory()->create();

        $I->sendDelete("/shops/" . $shop->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'shop' => true,
        ]);

        $I->dontSeeRecord('shops', [
            'email' => $shop->email,
            'phone' => $shop->phone,
            'address' => $shop->address,
            'telegram' => $shop->telegram,
            'instagram' => $shop->instagram,
            'facebook' => $shop->facebook,
        ]);
    }
}
