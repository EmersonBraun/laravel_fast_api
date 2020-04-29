<?php

namespace App\Console\Commands\Generators\Utils;
use Illuminate\Support\Str; // laravel < 6 remove this line

class Format
{
    public static function name($name)
    {
        $cleanName = self::cleanName($name);

        return (object) [
            'nameClass' => self::nameClass($cleanName),
            'nameCamel' => self::nameCamel($cleanName),
            'nameSnake' => self::nameSnake($cleanName),
            'nameKebab' => self::nameKebab($cleanName),
            'nameLower' => self::nameLower($cleanName),
            'namePlural' => self::namePlural($cleanName),
        ];
    }

    public static function cleanName($name)
    {
        $string = str_replace(' ', '_', $name);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

        return preg_replace('/-+/', '-', $string);
    }

    public static function nameClass($name)
    {
        $name = Str::camel($name);
        $name = ucfirst($name);
        return $name;
    }

    public static function nameCamel($name)
    {
        $name = Str::camel($name);
        return $name;
    }

    public static function nameSnake($name)
    {
        $name = Str::snake($name);
        return Str::plural($name);
    }

    public static function nameKebab($name)
    {
        $name = Str::kebab($name);
        return $name;
    }

    public static function nameLower($name)
    {
        return strtolower($name);
    }

    public static function namePlural($name)
    {;
        return Str::plural($name);
    }

    public static function subdiretory($subdiretory)
    {
        if(!$subdiretory) return '';
        $subdiretory = str_replace('/','\\',$subdiretory); //correct bar
        return $subdiretory;
    }

    public static function root($root)
    {
        if(!$root) return 'App\\';
        $root = str_replace('/','\\',$root); //correct bar
        if ($root[0] == "\\") $root = substr($root, 1);
        return $root;
    }
}
