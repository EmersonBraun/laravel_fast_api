<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeObserver
{
    public static function create($name, $opt, $fields=null)
    {
        $subdiretory = FileUtils::changeBar($opt->sub,'\\');
        $template = str_replace(
            [
                '{{ subdiretory }}',
                '{{ rootNamespace }}',
                '{{ nameClass }}',
                '{{ nameLower }}',
            ],
            [
                $subdiretory,
                'App\\',
                $name->nameClass,
                $name->nameLower,
            ],
            self::getStub('observer')
        );
        $basedir = FileUtils::baseDirFile('app', 'Observers', $opt->sub);
        FileUtils::createFolder($basedir);
       
        $create = file_put_contents("$basedir{$name->nameClass}Observer.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }
}