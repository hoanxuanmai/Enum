<?php
/**
 * Created by Mai Xuân Hoàn
 * Email: hoanxuanmai@gmail.com
 *
 */

namespace HXM\Enum\Abstracts;


use HXM\Enum\EnumCast;
use HXM\Enum\EnumRule;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Database\Eloquent\Castable;

class EnumBase implements Castable
{
    private static  $cacheValueWithDescriptions = [];

    protected static $descriptions = [];

    protected static $translation = false;

    /**
     * @return Collection
     * @throws \ReflectionException
     */
    static function getEnums() :Collection
    {

        return collect(( new \ReflectionClass(get_called_class()))->getConstants());
    }

    /**
     * @param array $dataAppend
     * @return Collection
     * @throws \ReflectionException
     */
    static function getCollection(array $dataAppend = []): Collection
    {
        return self::getValueWithDescriptions()->mapWithKeys(function ($dt, $k) use ($dataAppend) {

            return [$k => new EnumItemBase($k, $dt, $dataAppend[$k] ?? [])];

        });

    }
        /**
     * @return Collection
     * @throws \ReflectionException
     */
    static function getValues() : Collection
    {
        return self::getEnums()->values();
    }

    /**
     * @return Collection
     * @throws \ReflectionException
     */
    static function getValueWithDescriptions()
    {
        $return = self::setValueAndDescription();
        return collect($return);
    }

    /**
     * @param $value
     * @param string|null $default
     * @return string
     * @throws \ReflectionException
     */
    public static function getDescription($value, string $default = null)
    {
        return static::getValueWithDescriptions()[$value] ?? $default;
    }

    /**
     * @param array $descriptions
     * @throws \ReflectionException
     */
    public static function setDescriptions(array $descriptions)
    {
        foreach ($descriptions as $val => $des) {
            static::$descriptions[$val] = $des;
        }

        if (key_exists(static::class, self::$cacheValueWithDescriptions))
            unset(self::$cacheValueWithDescriptions[static::class]);

        self::setValueAndDescription();
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    private static function setValueAndDescription()
    {
        $class = static::class;

        if (key_exists($class, self::$cacheValueWithDescriptions)) {
            return self::$cacheValueWithDescriptions[$class];
        }

        self::$cacheValueWithDescriptions[$class] = [];
        foreach (self::getEnums() as $key => $value) {
            $des = static::$descriptions[$value] ?? static::defaultDescription($key);

            self::$cacheValueWithDescriptions[$class][$value] = static::$translation ? __($des) : $des;
        }

        return self::$cacheValueWithDescriptions[$class];
    }

    /**
     * @param $value
     * @return string
     */
    protected static function defaultDescription($value)
    {
        $value = preg_replace('/[^a-zA-Z0-9]+/', ' ', $value);
        return ucwords($value);
    }

    /**
     * @param $value
     * @return EnumItemBase|null
     * @throws \ReflectionException
     */
    static function value($value)
    {
        self::setValueAndDescription();
        $class = static::class;

        if (key_exists($value, self::$cacheValueWithDescriptions[$class])) {
            return new EnumItemBase($value, self::$cacheValueWithDescriptions[$class][$value]);
        }

        return null;
    }


    /**
     * @return EnumRule
     * @throws \ReflectionException
     */
    static function getRule()
    {
        return new EnumRule(static::getValues());
    }

    /**
     * @return EnumCast
     * @throws \ReflectionException
     */
    public static function castUsing()
    {
        return new EnumCast(static::getValueWithDescriptions());
    }
}
