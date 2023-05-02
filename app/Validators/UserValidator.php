<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Factory;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{
    private function getCommonRules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string',
            'phone' => 'required|string',
        ];
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'password' => 'required|string|min:4'
        ],
        ValidatorInterface::RULE_UPDATE => []
    ];

    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $rules = $this->rules;
        $rules[ValidatorInterface::RULE_CREATE] = array_merge(
            $this->getCommonRules(),
            $rules[ValidatorInterface::RULE_CREATE]
        );
        $rules[ValidatorInterface::RULE_UPDATE] = array_merge(
            $this->getCommonRules(),
            $rules[ValidatorInterface::RULE_UPDATE]
        );

        $this->setRules($rules);
    }
}
