<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeMigration
{
    public static function create($name, $opt, $fields=null)
    {
        $subdiretory = FileUtils::changeBar($opt->sub,'\\');
        $fields = self::mountFields($fields);
        $template = str_replace(
            [
                '{{ nameClass }}',
                '{{ tableName }}',
                '{{ primaryKey }}',
                '{{ filables }}',
                '{{ timestamps }}',
                '{{ softDeletes }}',
            ],
            [
                $name->nameClass,
                $name->nameSnake,
                $fields->primaryKey,
                $fields->filables,
                $fields->timestamps,
                $fields->softDeletes,
            ],
            self::getStub('migration')
        );
        $basedir = FileUtils::baseDirFile('', 'database', 'migrations');
        FileUtils::createFolder($basedir);
        $name = date('Y').'_'.date('m').'_'.date('d').date('his').'_create_'.$name->nameSnake.'_table.php';
        $create = file_put_contents($basedir.$name, $template);
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
                'filables' => '',
                'timestamps' => '//',
                'softDeletes' => '//'
            ];
        }
    }
}