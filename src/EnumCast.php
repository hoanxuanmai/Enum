<?php
/**
 * Created by Mai Xuân Hoàn
 * Email: hoanxuanmai@gmail.com
 *
 */

namespace HXM\Enum;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class EnumCast implements CastsAttributes
{

    public $valueWithDescription;

    public function __construct(Collection $valueWithDescription)
    {
        $this->valueWithDescription = $valueWithDescription;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return $this->valueWithDescription[$value] ?? null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
