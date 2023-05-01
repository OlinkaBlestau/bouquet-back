<?php


namespace Tests\Api;

use App\Models\Bouquet;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class OrderCest
{
    use WithFaker;

    public function testGetOrdersPaginated(ApiTester $I): void
    {
        $this->setUpFaker();

        Order::factory()->count(15)
            ->for(Bouquet::factory()
                ->for(User::factory()->create())
            )
            ->for(Shop::factory()->create())
            ->create();

        $order = Order::first();

        $I->sendGet("/orders");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'orders' => [
                'current_page' => 1,
                'data' => [
                    [
                        'bouquet_id' => $order->bouquet_id,
                        'shop_id' => $order->shop_id,
                        'amount' => $order->amount,
                    ]
                ]
            ]

        ]);
    }

    public function testGetOrder(ApiTester $I): void
    {
        $this->setUpFaker();

       $order = Order::factory()
           ->for(Bouquet::factory()
               ->for(User::factory()->create())
           )
           ->for(Shop::factory()->create())
           ->create();

        $I->sendGet("/orders/" . $order->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquet_id' => $order->bouquet_id,
            'shop_id' => $order->shop_id,
            'amount' => $order->amount,
        ]);
    }

    public function testCreateOrder(ApiTester $I): void
    {
        $this->setUpFaker();

        $shop = Shop::factory()->create();
        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();

        $data = [
            'bouquet_id' => $bouquet->id,
            'shop_id' => $shop->id,
            'amount' => $this->faker->randomNumber(2),
        ];

        $I->sendPost("/orders", $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'bouquet_id' => $data['bouquet_id'],
            'shop_id' => $data['shop_id'],
            'amount' => $data['amount'],
        ]);

        $I->seeRecord('orders', [
            'bouquet_id' => $data['bouquet_id'],
            'shop_id' => $data['shop_id'],
            'amount' => $data['amount'],
        ]);
    }

    public function testUpdateOrder(ApiTester $I): void
    {
        $this->setUpFaker();

        $order = Order::factory()
            ->for(Bouquet::factory()
                ->for(User::factory()->create())
            )
            ->for(Shop::factory()->create())
            ->create();

        $dataToUpdate = [
            'bouquet_id' => $order->bouquet_id,
            'shop_id' => $order->shop_id,
            'amount' => $this->faker->randomNumber(2),
        ];

        $I->sendPut("/orders/" . $order->id, $dataToUpdate);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'order' => [
                'bouquet_id' => $dataToUpdate['bouquet_id'],
                'shop_id' => $dataToUpdate['shop_id'],
                'amount' => $dataToUpdate['amount'],
            ]
        ]);

        $I->seeRecord('orders', [
            'bouquet_id' => $dataToUpdate['bouquet_id'],
            'shop_id' => $dataToUpdate['shop_id'],
            'amount' => $dataToUpdate['amount'],
        ]);
    }

    public function testDeleteOrder(ApiTester $I): void
    {
        $this->setUpFaker();

        $order = Order::factory()
            ->for(Bouquet::factory()
                ->for(User::factory()->create())
            )
            ->for(Shop::factory()->create())
            ->create();

        $I->sendDelete("/orders/" . $order->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'order' => true,
        ]);

        $I->dontSeeRecord('orders', [
            'bouquet_id' => $order->bouquet_id,
            'shop_id' => $order->shop_id,
            'amount' => $order->amount,
        ]);
    }
}
