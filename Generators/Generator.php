<?php
namespace App\Console\Commands\Generators;

use App\Console\Commands\Generators\MakeController;
use App\Console\Commands\Generators\MakeFactory;
use App\Console\Commands\Generators\MakeMigration;
use App\Console\Commands\Generators\MakeModel;
use App\Console\Commands\Generators\MakeObserver;
use App\Console\Commands\Generators\MakeRepository;
use App\Console\Commands\Generators\MakeRequest;
use App\Console\Commands\Generators\MakeRoute;
use App\Console\Commands\Generators\MakeSeeder;
use App\Console\Commands\Generators\MakeTest;

class Generator
{
    public function controller($name, $opt)
    {
        return MakeController::create($name, $opt);
    }

    public function factory($name, $opt)
    {
        return MakeFactory::create($name, $opt);
    }

    public function migration($name, $opt)
    {
        return MakeMigration::create($name, $opt);
    }

    public function model($name, $opt)
    {
        return MakeModel::create($name, $opt);
    }

    public function observer($name, $opt)
    {
        return MakeObserver::create($name, $opt);
    }

    public function repository($name, $opt)
    {
        return MakeRepository::create($name, $opt);
    }

    public function request($name, $opt)
    {
        return MakeRequest::create($name, $opt);
    }

    public function route($name, $opt)
    {
        return MakeRoute::create($name, $opt);
    }

    public function seeder($name, $opt)
    {
        return MakeSeeder::create($name, $opt);
    }

    public function test($name, $opt)
    {
        return MakeTest::create($name, $opt);
    }
}
