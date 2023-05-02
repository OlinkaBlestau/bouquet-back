<?php


namespace Tests\Api\Validation;

use App\Models\Bouquet;
use App\Models\User;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class BouquetDecorsValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateBouquetDecors(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/bouquet-decors', $example['bouquetDecorsData']);

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

        $I->dontSeeRecord('bouquet_decor', $example['bouquetDecorsData']);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Bouquet Decors without decor_id',
                'attribute' => 'decor_id',
                'humanAttribute' => 'decor id',
                'bouquetDecorsData' => [
                    'bouquet_id' => $this->faker->randomNumber(1),
                    'bouquet_decors_amount' => $this->faker->randomNumber(2),
                ]
            ],
            [
                'testName' => 'Bouquet Decors without bouquet_id',
                'attribute' => 'bouquet_id',
                'humanAttribute' => 'bouquet id',
                'bouquetDecorsData' => [
                    'decor_id' => $this->faker->randomNumber(1),
                    'bouquet_decors_amount' => $this->faker->randomNumber(2),
                ]
            ],
            [
                'testName' => 'Bouquet Decors without bouquet_decors_amount',
                'attribute' => 'bouquet_decors_amount',
                'humanAttribute' => 'bouquet decors amount',
                'bouquetDecorsData' => [
                    'decor_id' => $this->faker->randomNumber(1),
                    'bouquet_id' => $this->faker->randomNumber(1),
                ]
            ],
        ];
    }
}
