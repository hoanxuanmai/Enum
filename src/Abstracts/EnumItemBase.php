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

    public function __construct($value, $description)
    {
        $this->value = $value;
        $this->description = $description;
    }
}
