<?php

namespace rasel9w9\DataGenerator;
use Illuminate\Support\Facades\Artisan;
class GenerateData{
    public function generateTableData($table){
        Artisan::call("alauddin:generate-table-data --table=$table");
    }

    public function generateAllData(){
    }
}
