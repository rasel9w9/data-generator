<?php

namespace rasel9w9\data_generator;
use Illuminate\Support\ServiceProvider;
class DataGeneratorServiceProvider extends ServiceProvider{

    public function register(){
        $this->commands([
            GenerateTableData::class,
            GenerateData::class,
        ]);
    }

    public function boot(){
    }
    
}
