<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Factory;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class OrderValidator extends LaravelValidator
{
    private function getCommonRules(): array
    {
        return [
            'bouquet_id' => 'required|integer|exists:bouquets,id',
            'shop_id' => 'required|integer|exists:shops,id',
            'amount' => 'required|integer',
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
