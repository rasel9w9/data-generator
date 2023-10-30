<?php

namespace rasel9w9\DataGenerator;
use Illuminate\Support\ServiceProvider;
class DataGeneratorServiceProvider extends ServiceProvider{

    public function register(){
        $this->commands([
            GenerateTableDataCommand::class,
            GenerateDataCommand::class,
        ]);
    }

    public function boot(){
    }
    
}
