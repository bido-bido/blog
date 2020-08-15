<?php

namespace Bido\User\Services;

class VerifyCodeService
{
    private static $min = 100000;

    private static $max = 999999;

    private static $preFix = 'verify_code_';

    public static function generate()
    {
        return random_int(self::$min, self::$max);
    }

    public static function store($id, $code, $time)
    {
        cache()->set(self::$preFix . $id, $code, $time);
    }

    public static function get($id)
    {
        return cache()->get(self::$preFix . $id);
    }

    public static function delete($id)
    {

        return cache()->delete(self::$preFix . $id);
    }

    public static function getRule()
    {
        return 'required|numeric|between:' . self::$min . ',' . self::$max;
    }

    public static function check($id, $code)
    {
        if (self::get($id) != $code) {
            return false;
        }
        self::delete($id);

        return true;
    }

    public static function has($id)
    {
        return cache()->has(self::$preFix . $id);
    }
}