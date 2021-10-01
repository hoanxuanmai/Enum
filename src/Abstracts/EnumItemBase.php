<?php
/**
 * Created by Mai Xuân Hoàn
 * Email: hoanxuanmai@gmail.com
 *
 */

namespace HXM\Enum\Abstracts;

class EnumItemBase
{
    public $value = null;
    public $description = null;

    public function __construct($value, $description, array $dataAppends = [])
    {
        $this->value = $value;
        $this->description = $description;

        foreach ($dataAppends as $attr => $value) {
            $this->{$attr} = $value;
        }
    }

    function toArray()
    {
        return (array) $this;
    }
}
