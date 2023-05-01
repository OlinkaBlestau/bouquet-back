<?php


namespace Tests\Api;

use App\Models\User;
use Codeception\Util\HttpCode;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\Support\ApiTester;

class UserCest
{
    use WithFaker;

    public function testRegisterUser(ApiTester $I): void
    {
        $this->setUpFaker();

        $data = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'address' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'password' => $this->faker->password(),
        ];

        $I->sendPost('/auth/register', $data);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        unset($data['password']);
        $I->seeResponseContainsJson($data);

        $I->seeRecord('users', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
        ]);
    }

    public function testLoginUser(ApiTester $I): void
    {
        $this->setUpFaker();

        $data = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'address' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'password' => bcrypt('root'),
        ];

        $user = User::create($data);

        Artisan::call('passport:install');

        $I->sendPost('/auth/login', [
            'email' => $data['email'],
            'password' => 'root'
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'userId' => $user->id,
            'role' => 'user',
        ]);
    }

    public function testUpdateUser(ApiTester $I): void
    {
        $this->setUpFaker();

        $user = User::create([
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'address' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'password' => bcrypt('root'),
        ]);

        $dataToUpdate = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'address' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
        ];

        $I->sendPut("/users/" . $user->id, $dataToUpdate);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'first_name' => $dataToUpdate['first_name'],
            'last_name' => $dataToUpdate['last_name'],
            'email' => $dataToUpdate['email'],
            'address' => $dataToUpdate['address'],
            'phone' => $dataToUpdate['phone'],
        ]);

        $I->seeRecord('users', [
            'first_name' => $dataToUpdate['first_name'],
            'last_name' => $dataToUpdate['last_name'],
            'email' => $dataToUpdate['email'],
            'address' => $dataToUpdate['address'],
            'phone' => $dataToUpdate['phone'],
        ]);
    }

    public function testGetUser(ApiTester $I): void
    {
        $this->setUpFaker();

        $user = User::create([
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'address' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'password' => bcrypt('root'),
        ]);

        $I->sendGet("/users/" . $user->id);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'address' => $user->address,
            'phone' => $user->phone,
        ]);
    }

    public function testGetUsersPaginated(ApiTester $I): void
    {
        $this->setUpFaker();

        User::factory()->count(15)->create();
        $user = User::first();

        $I->sendGet("/users");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'users' => [
                'current_page' => 1,
                'data' => [
                    [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'address' => $user->address,
                        'phone' => $user->phone,
                    ]
                ]
            ]

        ]);
    }
}
