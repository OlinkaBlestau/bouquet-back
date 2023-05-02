<?php


namespace Tests\Api\Validation;

use Codeception\Example;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\ApiTester;

class UserValidationCest
{
    use WithFaker;

    /**
     * @param ApiTester $I
     * @param Example $example
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testValidateRegisterUser(ApiTester $I, Example $example): void
    {
        $I->wantTo($example['testName']);

        $I->sendPost('/auth/register', $example['userData']);

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

        $I->dontSeeRecord('users', $example['userData']);
    }

    private function dataProvider(): array
    {
        $this->setUpFaker();

        return [
            [
                'testName' => 'User without first name',
                'attribute' => 'first_name',
                'humanAttribute' => 'first name',
                'userData' => [
                    'last_name' => $this->faker->lastName(),
                    'email' => $this->faker->email(),
                    'address' => $this->faker->address(),
                    'phone' => $this->faker->phoneNumber(),
                    'password' => $this->faker->password(5),
                ]
            ],
            [
                'testName' => 'User without last name',
                'attribute' => 'last_name',
                'humanAttribute' => 'last name',
                'userData' => [
                    'first_name' => $this->faker->firstName(),
                    'email' => $this->faker->email(),
                    'address' => $this->faker->address(),
                    'phone' => $this->faker->phoneNumber(),
                    'password' => $this->faker->password(5),
                ]
            ],
            [
                'testName' => 'User without email',
                'attribute' => 'email',
                'humanAttribute' => 'email',
                'userData' => [
                    'first_name' => $this->faker->firstName(),
                    'last_name' => $this->faker->lastName(),
                    'address' => $this->faker->address(),
                    'phone' => $this->faker->phoneNumber(),
                    'password' => $this->faker->password(5),
                ]
            ],
            [
                'testName' => 'User without address',
                'attribute' => 'address',
                'humanAttribute' => 'address',
                'userData' => [
                    'first_name' => $this->faker->firstName(),
                    'last_name' => $this->faker->lastName(),
                    'email' => $this->faker->email(),
                    'phone' => $this->faker->phoneNumber(),
                    'password' => $this->faker->password(5),
                ]
            ],
            [
                'testName' => 'User without phone',
                'attribute' => 'phone',
                'humanAttribute' => 'phone',
                'userData' => [
                    'first_name' => $this->faker->firstName(),
                    'last_name' => $this->faker->lastName(),
                    'email' => $this->faker->email(),
                    'address' => $this->faker->address(),
                    'password' => $this->faker->password(5),
                ]
            ],
        ];
    }
}
