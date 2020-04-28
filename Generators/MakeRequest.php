<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeRequest
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
                $name->nameClass
            ],
            self::getStub('request')
        );
        $basedir = FileUtils::baseDirFile('app', 'Http/Requests', $opt->sub);
        FileUtils::createFolder($basedir);
       
        $create = file_put_contents("$basedir{$name->nameClass}Request.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }
}