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

        $basedirTraits = FileUtils::baseDirFile('app', 'Traits', $opt->sub);
        FileUtils::createFolder($basedirTraits);
        if (!file_exists("{$basedirTraits}ResponseTrait.php")) self::createTrait($basedirTraits);

        $create = file_put_contents("$basedir{$name->nameClass}Repository.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }

    public static function createBaseRepository($basedir)
    {
        $file = file_get_contents(__DIR__."/files/BaseRepository.stub");
        $create = file_put_contents("{$basedir}BaseRepository.php", $file);
        if($create) return true;
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