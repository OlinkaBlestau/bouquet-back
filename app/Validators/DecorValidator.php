<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Factory;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DecorValidator extends LaravelValidator
{
    private function getCommonRules(): array
    {
        return [
            'name' => 'required|string',
            'color' => 'required|string',
            'price' => 'required|integer',
            'storage_decors_amount' => 'required|integer',
            'img_path' => 'required|string',
        ];
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
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
