<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;
use File;

class MakeRoute
{
    public static function create($name, $opt, $fields=null)
    {
        $subdiretory = FileUtils::changeBar($opt->sub,'\\');
        $template = str_replace(
            [
                '{{ nameClass }}',
                '{{ nameLower }}',
                '{{ subdiretory }}'
            ],
            [
                $name->nameClass,
                $name->nameLower,
                $subdiretory
            ],
            self::getStub('route.api')
        );

       $create = File::append(base_path('routes/api.php'), $template);
       return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }
}