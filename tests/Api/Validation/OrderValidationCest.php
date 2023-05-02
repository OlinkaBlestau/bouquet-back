<?php


namespace Tests\Api\Validation;

use App\Models\Bouquet;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class OrderValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateOrder(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/orders', $example['orderData']);

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

        $I->dontSeeRecord('orders', $example['orderData']);
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateUpdateBouquet(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $order = Order::factory()
            ->for(Bouquet::factory()
                ->for(User::factory()->create())
            )
            ->for(Shop::factory()->create())
            ->create();

        $I->sendPut('/orders/' . $order->id, $example['orderData']);

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

        $I->dontSeeRecord('orders', $example['orderData']);
        $I->seeRecord('orders', [
            'bouquet_id' => $order->bouquet_id,
            'shop_id' => $order->shop_id,
            'amount' => $order->amount,
        ]);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Order without bouquet_id',
                'attribute' => 'bouquet_id',
                'humanAttribute' => 'bouquet id',
                'orderData' => [
                    'amount' => $this->faker->randomNumber(2),
                    'shop_id' => $this->faker->randomNumber(1),
                ]
            ],
            [
                'testName' => 'User without shop_id',
                'attribute' => 'shop_id',
                'humanAttribute' => 'shop id',
                'orderData' => [
                    'amount' => $this->faker->randomNumber(2),
                    'bouquet_id' => $this->faker->randomNumber(1),
                ]
            ],
        ];
    }
}
