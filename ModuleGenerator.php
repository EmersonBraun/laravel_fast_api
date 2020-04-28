<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Utils\Format;
use Illuminate\Support\Str; // laravel < 6 remove this line

use App\Console\Commands\Generators\Generator;

class ModuleGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:module 
                            {name : Class (singular) for example User} 
                            {--sub= : Subdirectory where the resource will be placed for example \Models}
                            {--controller : No create Controller}
                            {--factory : No create Factory}
                            {--migration : No create Migration}
                            {--model : No create Model}
                            {--observer : No create Observer}
                            {--repository : No create Repository}
                            {--request : No create Request}
                            {--route : No create Route}
                            {--seeder : No create Seeder}
                            {--test : No create Test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resources (Model, Controller, etc)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $name;
    protected $opt;
    protected $generator;
    public function __construct(Generator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     * 
     * OBS: in laravel < 6 change Str:: to Str::
     *
     * @return mixed
     */
    public function handle()
    {
        $this->name = Format::name($this->argument('name'));
        $this->formatOptions($this->options());   
        $options =['controller','factory','migration','model','observer','repository','request','route','seeder','test'];
        $this->generate($options);

    }

    public function generate($options)
    {
        foreach ($options as $option) {
            if(!$this->option($option)) {
                $generated = $this->generator->$option($this->name, $this->opt, null);
                if($generated) $this->info("Generated {$option}!");
                else $this->error("Error to generate {$option}!");
            }
            else $this->error("Not generated {$option}!");
        }
    }

    public function formatOptions($options)
    {
        $this->opt = (object) $options;
        $this->opt->sub = Format::subdiretory($options['sub']);
    }

}
