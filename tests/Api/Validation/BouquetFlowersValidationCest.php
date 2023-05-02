<?php


namespace Tests\Api\Validation;

use App\Models\Bouquet;
use App\Models\User;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class BouquetFlowersValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateBouquetFlowers(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/bouquet-flowers', $example['bouquetFlowersData']);

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

        $I->dontSeeRecord('bouquet_flower', $example['bouquetFlowersData']);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Bouquet Flowers without flower_id',
                'attribute' => 'flower_id',
                'humanAttribute' => 'flower id',
                'bouquetFlowersData' => [
                    'bouquet_id' => $this->faker->randomNumber(1),
                    'bouquet_flowers_amount' => $this->faker->randomNumber(2),
                ]
            ],
            [
                'testName' => 'Bouquet Flowers without bouquet_id',
                'attribute' => 'bouquet_id',
                'humanAttribute' => 'bouquet id',
                'bouquetFlowersData' => [
                    'flower_id' => $this->faker->randomNumber(1),
                    'bouquet_flowers_amount' => $this->faker->randomNumber(2),
                ]
            ],
            [
                'testName' => 'Bouquet Flowers without bouquet_flowers_amount',
                'attribute' => 'bouquet_flowers_amount',
                'humanAttribute' => 'bouquet flowers amount',
                'bouquetFlowersData' => [
                    'flower_id' => $this->faker->randomNumber(1),
                    'bouquet_id' => $this->faker->randomNumber(1),
                ]
            ],
        ];
    }
}
