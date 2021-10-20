
## About hxm/enum

[Simple installation](#installation), extensible and powerful enumeration implementation for Laravel.

- Enum key value pairs as class constants
- Attribute [casting](#get-casting)
- Validation [rules](#get-rule) for passing enum values as input parameters


## Installation


Via Composer

```bash
composer require hxm/enum
```

## Basic Usage


Now, you just need to add the possible values your enum can have as constants.

```php
<?php
namespace App\Enums;

use HXM\Enum\Abstracts\EnumBase;

class ExampleEnums extends EnumBase
{
    const E1 = 1;
    const E2 = 2;

    protected static $descriptions = [
        1 => 'description for E1'
    ];
}
```

```php
  ExampleEnums::E1; // 1
  
  ExampleEnums::getValueWithDescriptions()->toArray(); // [1 => 'description for E1', 2 => "E2"]
  
  ExampleEnums::getValues()->toArray(); // [1, 2]
  
  ExampleEnums::getDescription(1); // 'description for E1'
  
```

## Get Casting
use in Model Class
```php
class ExampleClass extends Model
{
  protected $casts = [
          ....
          'attribute' => ExampleEnums::class,
          ...
      ];
}

```

## Get Rule

```php
Validator:make($data, [
  'attribute' => ['required', ExampleEnums::getRule()]
]);
```

