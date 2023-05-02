<?php


namespace Tests\Api\Validation;

use App\Models\Shop;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class ShopValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateShop(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/shops', $example['shopData']);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'error' => true,
            'messages' => [
                $example['attribute'] => [
                    __('validation.required', ['attribute' => $example['humanAttribute']])
                ]
            ]
        ]);

        $I->dontSeeRecord('shops', $example['shopData']);
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateUpdateDecor(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $shop = Shop::factory()->create();

        $I->sendPut('/shops/' . $shop->id, $example['shopData']);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'error' => true,
            'messages' => [
                $example['attribute'] => [
                    __('validation.required', ['attribute' => $example['humanAttribute']])
                ]
            ]
        ]);

        $I->dontSeeRecord('shops', $example['shopData']);
        $I->seeRecord('shops', [
            'email' => $shop->email,
            'phone' => $shop->phone,
            'address' => $shop->address,
            'telegram' => $shop->telegram,
            'instagram' => $shop->instagram,
            'facebook' => $shop->facebook,
        ]);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Shop without email',
                'attribute' => 'email',
                'humanAttribute' => 'email',
                'shopData' => [
                    'phone' => $this->faker->phoneNumber(),
                    'address' => $this->faker->address(),
                    'telegram' => 'https://t.me/flowers',
                    'instagram' => 'https://instagram.com/flowers',
                    'facebook' => 'https://facebook.com/flowers',
                ]
            ],
            [
                'testName' => 'Shop without phone',
                'attribute' => 'phone',
                'humanAttribute' => 'phone',
                'shopData' => [
                    'email' => $this->faker->email(),
                    'address' => $this->faker->address(),
                    'telegram' => 'https://t.me/flowers',
                    'instagram' => 'https://instagram.com/flowers',
                    'facebook' => 'https://facebook.com/flowers',
                ]
            ],
            [
                'testName' => 'Shop without address',
                'attribute' => 'address',
                'humanAttribute' => 'address',
                'shopData' => [
                    'email' => $this->faker->email(),
                    'phone' => $this->faker->phoneNumber(),
                    'telegram' => 'https://t.me/flowers',
                    'instagram' => 'https://instagram.com/flowers',
                    'facebook' => 'https://facebook.com/flowers',
                ]
            ],
            [
                'testName' => 'Shop without telegram',
                'attribute' => 'telegram',
                'humanAttribute' => 'telegram',
                'shopData' => [
                    'email' => $this->faker->email(),
                    'phone' => $this->faker->phoneNumber(),
                    'address' => $this->faker->address(),
                    'instagram' => 'https://instagram.com/flowers',
                    'facebook' => 'https://facebook.com/flowers',
                ]
            ],
            [
                'testName' => 'Shop without instagram',
                'attribute' => 'instagram',
                'humanAttribute' => 'instagram',
                'shopData' => [
                    'email' => $this->faker->email(),
                    'phone' => $this->faker->phoneNumber(),
                    'address' => $this->faker->address(),
                    'telegram' => 'https://t.me/flowers',
                    'facebook' => 'https://facebook.com/flowers',
                ]
            ],
            [
                'testName' => 'Shop without facebook',
                'attribute' => 'facebook',
                'humanAttribute' => 'facebook',
                'shopData' => [
                    'email' => $this->faker->email(),
                    'phone' => $this->faker->phoneNumber(),
                    'address' => $this->faker->address(),
                    'telegram' => 'https://t.me/flowers',
                    'instagram' => 'https://instagram.com/flowers',
                ]
            ],
        ];
    }
}
