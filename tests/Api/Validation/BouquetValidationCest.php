<?php


namespace Tests\Api\Validation;

use App\Models\Bouquet;
use App\Models\User;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class BouquetValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateBouquet(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/bouquets', $example['bouquetData']);

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

        $I->dontSeeRecord('bouquets', $example['bouquetData']);
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

        $bouquet = Bouquet::factory()
            ->for(User::factory()->create())
            ->create();

        $I->sendPut('/bouquets/' . $bouquet->id, $example['bouquetData']);

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

        $I->dontSeeRecord('bouquets', $example['bouquetData']);
        $I->seeRecord('bouquets', [
            'user_id' => $bouquet->user_id,
            'total_price' => $bouquet->total_price,
        ]);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Bouquet without user_id',
                'attribute' => 'user_id',
                'humanAttribute' => 'user id',
                'bouquetData' => [
                    'total_price' => $this->faker->randomNumber(2),
                ]
            ],
            [
                'testName' => 'User without total_price',
                'attribute' => 'total_price',
                'humanAttribute' => 'total price',
                'bouquetData' => [
                    'user_id' => $this->faker->randomNumber(1),
                ]
            ],
        ];
    }
}
