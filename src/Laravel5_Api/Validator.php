<?php

namespace SehrGut\Laravel5_Api;

use Validator as BaseValidator;

use SehrGut\Laravel5_Api\Exceptions\Validator\InvalidInput;

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
     * @var Array
     */
    protected static $rules = [];

    /**
     * Retrieve the rules of this validator.
     *
     * @return Array
     */
    public static function getRules()
    {
        return static::$rules;
    }

    /**
     * Validate the input using $rules.
     *
     * Drop any keys that are not present in $rules.
     *
     * @param  Array  $input
     * @param  Mixed  $rules  (optional) Override internal rules
     * @param  Bool   $only_present  Whether to only validate fields present in $input (default = false)
     * @return Array
     * @throws InvalidInput
     */
	public static function validate(Array $input, $rules = null, $only_present = false)
    {
        $rules = is_null($rules) ? static::$rules : $rules;
        $input_whitelist = array_keys($rules);
        $whitelisted_input = array_only($input, $input_whitelist);

        // TODO - refactor this crazyness...
        if ($only_present) {
            $rules_whitelist = array_keys($input);
            $rules = array_filter($rules, function($rule) use ($rules_whitelist) {
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

        $validator = BaseValidator::make($whitelisted_input, $rules);
        if ($validator->fails()) {
            throw new InvalidInput($validator->errors());
        }

        return $whitelisted_input;
    }
}