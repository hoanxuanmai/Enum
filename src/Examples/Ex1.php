<?php
/**
 * Created by Vincent
 * Email: vincent@pixodeo.net
 * Date: 6/22/2021
 */

namespace HXM\Enum\Examples;


use HXM\Enum\Abstracts\EnumBase;

class Ex1 extends EnumBase
{
    const C1 = 1;
    const C2 = 2;

    protected static $descriptions = [
        '1' => 'description for C1'
    ];
}
