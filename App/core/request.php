<?php

namespace app\core;


class request
{
    public static function all()
    {
        return $_POST;
    }

    public static function input(string $name)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        throw new \Exception("Não foi encontrado o parâmetro $name");
    }
    public static function only(string|array $only)
    {
        $fieldsPost = self::all();
        $fieldsPost_keys = array_keys($fieldsPost);
        $arr = [];

        foreach ($fieldsPost_keys as $key => $value) {
            $onlyFields = (is_string($only) ? $only : (isset($only[$key]) ? $only[$key] : null));
            if (isset($fieldsPost[$onlyFields])) {
                $arr[$onlyFields] = $fieldsPost[$onlyFields];
            }
        }
        return $arr;
    }
    public static function excepts(string|array $excepts)
    {
        $fieldsPost = self::all();

        if (is_array($excepts)) {
            foreach ($excepts as $key => $value) {
                unset($fieldsPost[$value]);
            }
        }
        if (is_string($excepts)) {
            unset($fieldsPost[$excepts]);
        }
        return $fieldsPost;
    }
    public static function query(string $name)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
        throw new \Exception("Não foi encontrado o parâmetro $name");
    }

    public static function toJson(array $data)
    {
        return json_encode($data);
    }

    public static function toArray($data)
    {
        if (isJson($data)) {
            return json_decode($data, true);
        }
    }
}
