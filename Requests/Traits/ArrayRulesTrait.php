<?php

namespace App\Http\Requests\Traits;

/**
 * Trait ArrayRulesTrait
 * @package App\Http\Requests\Traits
 */
trait ArrayRulesTrait
{
    /**
     * Merge rules from sub request
     *
     * @param array $baseRules
     * @param string $key
     * @param array $subRules
     * @param bool $isRequired
     * @param int|null $min
     * @param int|null $max
     */
    protected function addArraySubRules(array &$baseRules, string $key, array $subRules, bool $isRequired = false, int $min = 0, int $max = 0)
    {
        $baseRules[$key] = ($isRequired ? 'required|' : '') . 'array' .
            ($min ? '|min:' . $min : '') .
            ($max ? '|max:' . $max : '');

        foreach ($subRules as $subKey => $subRule) {
            $baseRules[$key . '.*.' . $subKey] = $subRule;
        }
    }

    /**
     * Merge rules from sub request
     *
     * @param array $baseRules
     * @param string $key
     * @param array $subRules
     * @param bool $isRequired
     */
    protected function addFieldsSubRules(array &$baseRules, string $key, array $subRules, bool $isRequired = false)
    {
        $baseRules[$key] = ($isRequired ? 'required|' : '') . 'array';

        foreach ($subRules as $subKey => $subRule) {
            $baseRules[$key . '.' . $subKey] = $subRule;
        }
    }
}
