<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeModel
{
   public static function create($name, $opt, $fields=null)
    {
        $subdiretory = FileUtils::changeBar($opt->sub,'\\');
        $fields = self::mountFields($fields);
        $template = str_replace(
            [
                '{{ subdiretory }}',
                '{{ rootNamespace }}',
                '{{ nameClass }}',
                '{{ tableName }}',
                '{{ primaryKey }}',
                '{{ filables }}',
                '{{ guarded }}',
                '{{ casts }}',
                '{{ timestamps }}',
                '{{ dates }}',
                '{{ softDeletes }}',
            ],
            [
                $subdiretory,
                'App\\',
                $name->nameClass,
                $name->nameSnake,
                $fields->primaryKey,
                $fields->fillable,
                $fields->guarded,
                $fields->casts,
                $fields->timestamps,
                $fields->dates,
                $fields->softDeletes
            ],
            self::getStub('model')
        );
        $basedir = FileUtils::baseDirFile('app', 'Models', $opt->sub);
        FileUtils::createFolder($basedir);
       
        $create = file_put_contents("$basedir{$name->nameClass}.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }

    public static function mountFields($fields)
    {
        if(!$fields) {
            return (object) [
                'primaryKey' => 'id',
                'fillable' => '[]',
                'guarded' => "['id']",
                'casts' => '[]',
                'timestamps' => 'false',
                'dates' => '[]',
                'softDeletes' => '//'
            ];
        }
    }
}