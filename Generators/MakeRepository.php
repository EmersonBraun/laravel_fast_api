<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeRepository
{
    public static function create($name, $opt, $fields=null)
    {
        $subdiretory = FileUtils::changeBar($opt->sub,'\\');
        $template = str_replace(
            [
                '{{ subdiretory }}',
                '{{ rootNamespace }}',
                '{{ nameClass }}'
            ],
            [
                $subdiretory,
                'App\\',
                $name->nameClass,
            ],
            self::getStub('repository')
        );
        $basedir = FileUtils::baseDirFile('app', 'Repositories', $opt->sub);
        FileUtils::createFolder($basedir);
        
        if (!file_exists("{$basedir}BaseRepository.php")) self::createBaseRepository($basedir);

        $create = file_put_contents("$basedir{$name->nameClass}Repository.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }

    public static function createBaseRepository($basedir)
    {
        $file = file_get_contents(__DIR__."/files/BaseRepository.php");
        $create = file_put_contents("{$basedir}BaseRepository.php", $file);
        if($create) return true;
        return false;
    }
}