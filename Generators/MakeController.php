<?php
namespace App\Console\Commands\Generators;

use App\Console\Commands\Generators\Utils\FileUtils;
class MakeController
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
                '{{ namePlural }}',
            ],
            [
                $subdiretory,
                'App\\',
                $name->nameClass,
                $name->nameLower,
                $name->namePlural,
            ],
            self::getStub('controller.api')
        );
        $basedir = FileUtils::baseDirFile('app', 'Http/Controllers', $opt->sub);
        FileUtils::createFolder($basedir);
       
        $create = file_put_contents("$basedir{$name->nameClass}Controller.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }
}
