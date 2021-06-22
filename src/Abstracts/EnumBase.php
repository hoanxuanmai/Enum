<?php
/**
 * Created by Mai Xuân Hoàn
 * Email: hoanxuanmai@gmail.com
 *
 */

namespace HXM\Enum\Abstracts;


use Illuminate\Support\Collection;

class EnumBase
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
     * @return array|string|null
     * @throws \ReflectionException
     */
    public static function getDescription($value)
    {
        $value = static::getValueWithDescriptions()[$value] ?? null;

        return $value;
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
}
