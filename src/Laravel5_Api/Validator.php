<?php

namespace SehrGut\Laravel5_Api;

use SehrGut\Laravel5_Api\Exceptions\Validator\InvalidInput;
use Validator as BaseValidator;

class Validator
{
    /**
     * Definition of the validation rules.
     *
     * Keys not present here will be dropped from the input.
     * If you don't want any validation, just name the
     * keys with a value of the empty string.
     *
     * Example:
     * ```
     *      protected static $rules = [
     *          'name' => 'required|min:3',
     *          'excerpt' => 'max:120',
     *          'body' => ''
     *      ];
     * ```
     *
     * @var array
     */
    protected static $rules = [];

    /**
     * Retrieve the rules of this validator.
     *
     * @return array
     */
    public static function getRules()
    {
        return static::$rules;
    }

    /**
     * Retrieve the rules of this validator when validating an array of records.
     *
     * @return array
     */
    public static function getRulesMany()
    {
        return array_map(function ($rule) {
            return '*.' . $rule;
        }, static::$rules);
    }

    /**
     * Validate the input using $rules.
     *
     * Drop any keys that are not present in $rules.
     *
     * @param array $input
     * @param mixed $rules        (optional) Override internal rules
     * @param bool  $only_present Whether to only validate fields present in $input (default = false)
     *
     * @throws InvalidInput
     *
     * @return array
     */
    public static function validate(array $input, $rules = null, $only_present = false)
    {
        $rules = is_null($rules) ? static::$rules : $rules;
        if (empty($rules)) {
            return $input;
        }

        // TODO - refactor this craziness...
        if ($only_present) {
            $rules_whitelist = array_keys($input);
            $rules = array_filter($rules, function ($rule) use ($rules_whitelist) {
                $in_whitelist = false;
                foreach ($rules_whitelist as $allowed) {
                    if (substr($rule, 0, strlen($allowed)) == $allowed) {
                        $in_whitelist = true;
                        break;
                    }
                }

                return $in_whitelist;
            }, ARRAY_FILTER_USE_KEY);
        }

        $validator = BaseValidator::make($input, $rules);
        if ($validator->fails()) {
            throw new InvalidInput($validator->errors());
        }

        return $input;
    }
}
