<?php


namespace Tests\Api\Validation;

use App\Models\Decor;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class DecorValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateDecor(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/decors', $example['decorData']);

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

        $I->dontSeeRecord('decors', $example['decorData']);
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

        $decor = Decor::factory()->create();

        $I->sendPut('/decors/' . $decor->id, $example['decorData']);

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

        $I->dontSeeRecord('decors', $example['decorData']);
        $I->seeRecord('decors', [
            'name' => $decor->name,
            'color' => $decor->color,
            'price' => $decor->price,
            'storage_decors_amount' => $decor->storage_decors_amount,
            'img_path' => $decor->img_path,
        ]);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Decor without name',
                'attribute' => 'name',
                'humanAttribute' => 'name',
                'decorData' => [
                    'color' => $this->faker->colorName(),
                    'price' => $this->faker->randomNumber(3),
                    'storage_decors_amount' => $this->faker->randomNumber(2),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Decor without color',
                'attribute' => 'color',
                'humanAttribute' => 'color',
                'decorData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'price' => $this->faker->randomNumber(3),
                    'storage_decors_amount' => $this->faker->randomNumber(2),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Decor without price',
                'attribute' => 'price',
                'humanAttribute' => 'price',
                'decorData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'color' => $this->faker->colorName(),
                    'storage_decors_amount' => $this->faker->randomNumber(2),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Decor without storage_decors_amount',
                'attribute' => 'storage_decors_amount',
                'humanAttribute' => 'storage decors amount',
                'decorData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'color' => $this->faker->colorName(),
                    'price' => $this->faker->randomNumber(3),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Decor without img_path',
                'attribute' => 'img_path',
                'humanAttribute' => 'img path',
                'decorData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'color' => $this->faker->colorName(),
                    'price' => $this->faker->randomNumber(3),
                    'storage_decors_amount' => $this->faker->randomNumber(2),
                ]
            ],
        ];
    }
}
