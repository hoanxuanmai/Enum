<?php
/**
 * Created by Mai Xuân Hoàn
 * Email: hoanxuanmai@gmail.com
 *
 */

namespace HXM\Enum;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

class EnumRule implements Rule
{
    public $values;

    public function __construct(Collection $values)
    {
        $this->values = $values;
    }

    public function passes($attribute, $value)
    {
        return $this->values->contains($value);
    }

    public function message()
    {
        return __('The :attribute is invalid.');
    }
}

