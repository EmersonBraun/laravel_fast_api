<?php
namespace App\Console\Commands\Generators;
use App\Console\Commands\Generators\Utils\FileUtils;

class MakeFactory
{
    public static function create($name, $opt, $fields=null)
    {
        $subdiretory = FileUtils::changeBar($opt->sub,'\\');
        $fields = $fields ? $fields : '// \'key\' => $faker->boolean(50),';
        $template = str_replace(
            [
                '{{ subdiretory }}',
                '{{ rootNamespace }}',
                '{{ nameClass }}',
                '{{ fields }}'
            ],
            [
                $subdiretory,
                'App\\',
                $name->nameClass,
                $fields
            ],
            self::getStub('factory')
        );
        $basedir = FileUtils::baseDirFile('', 'database','factories');
        FileUtils::createFolder($basedir);

        if (!file_exists("{$basedir}Faker.md")) self::createFakerMd($basedir);
  
        $create = file_put_contents("$basedir{$name->nameClass}Factory.php", $template);
        return $create;
    }

    public static function getStub($type)
    {
        return file_get_contents(__DIR__."/stubs/$type.stub");
    }

    public static function createFakerMd($basedir)
    {
        $file = file_get_contents(__DIR__."/files/Faker.md");
        $create = file_put_contents("{$basedir}Faker.md", $file);
        if($create) return true;
        return false;
    }
}