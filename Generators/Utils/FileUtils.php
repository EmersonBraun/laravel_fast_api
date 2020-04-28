<?php

namespace App\Console\Commands\Generators\Utils;

class FileUtils
{
    public static function baseDirFile($root, $folder, $subdiretory=null)
    {
        $sub = $subdiretory ? self::changeBar($subdiretory,'/') : ''; 
        if($sub) return base_path("$root/$folder/$sub/");
        return base_path("$root/$folder/");
    }

    public static function createFolder($dir)
    {
        if (!file_exists($dir)) mkdir($dir, 0777, true);
    }

    public static function changeBar($dir, $type='/')
    {
        if(!$dir) return '';
        if($type == '\\') {
            if ($dir[0] !== "\\") return "\\$dir";
            return $dir;
        }
        if ($dir[0] !== "/") return "/$dir";
        return $dir;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }
}
