<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeTraits
{
    public static function create($name, $opt, $fields=null)
    {
        $basedir = FileUtils::baseDirFile('app', 'Traits', '');
        dd($basedir);
        FileUtils::createFolder($basedir);
        
        if (!file_exists("{$basedir}ResponseTrait.php")) {
            $create = self::createTrait($basedir);
            return $create;
        }
        return false;
    }

    public static function createTrait($basedir)
    {
        $file = file_get_contents(__DIR__."/files/ResponseTrait.stub");
        $create = file_put_contents("{$basedir}ResponseTrait.php", $file);
        if($create) return true;
        return false;
    }
}