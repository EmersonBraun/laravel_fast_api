<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeTest
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
            self::getStub('test')
        );
        $basedir = FileUtils::baseDirFile('', 'tests/Unit', $opt->sub);
        FileUtils::createFolder($basedir);
       
        $create = file_put_contents("$basedir{$name->nameClass}Test.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }
}