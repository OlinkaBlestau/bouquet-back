<?php


namespace Tests\Api\Validation;

use App\Models\Flower;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class FlowerValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateCreateFlower(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/flowers', $example['flowerData']);

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

        $I->dontSeeRecord('flowers', $example['flowerData']);
    }

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateUpdateFlower(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $flower = Flower::factory()->create();

        $I->sendPut('/flowers/' . $flower->id, $example['flowerData']);

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

        $I->dontSeeRecord('flowers', $example['flowerData']);
        $I->seeRecord('flowers', [
            'name' => $flower->name,
            'color' => $flower->color,
            'price' => $flower->price,
            'storage_flowers_amount' => $flower->storage_flowers_amount,
            'img_path' => $flower->img_path,
        ]);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'Flower without name',
                'attribute' => 'name',
                'humanAttribute' => 'name',
                'flowerData' => [
                    'color' => $this->faker->colorName(),
                    'price' => $this->faker->randomNumber(3),
                    'storage_flowers_amount' => $this->faker->randomNumber(2),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Flower without color',
                'attribute' => 'color',
                'humanAttribute' => 'color',
                'flowerData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'price' => $this->faker->randomNumber(3),
                    'storage_flowers_amount' => $this->faker->randomNumber(2),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Flower without price',
                'attribute' => 'price',
                'humanAttribute' => 'price',
                'flowerData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'color' => $this->faker->colorName(),
                    'storage_flowers_amount' => $this->faker->randomNumber(2),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Flower without storage_flowers_amount',
                'attribute' => 'storage_flowers_amount',
                'humanAttribute' => 'storage flowers amount',
                'flowerData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'color' => $this->faker->colorName(),
                    'price' => $this->faker->randomNumber(3),
                    'img_path' => $this->faker->imageUrl(),
                ]
            ],
            [
                'testName' => 'Flower without img_path',
                'attribute' => 'img_path',
                'humanAttribute' => 'img path',
                'flowerData' => [
                    'name' => $this->faker->firstNameFemale(),
                    'color' => $this->faker->colorName(),
                    'price' => $this->faker->randomNumber(3),
                    'storage_flowers_amount' => $this->faker->randomNumber(2),
                ]
            ],
        ];
    }
}
