# Data Generator: Export Table Data With ease.
Easily export data  using . This package has been tested since Laravel 10.

## Installation

Run this composer command in your laravel application:
Only Mysql version 1.1;
```
composer require rasel9w9/data-generator:^1.1
```

support oracle database18c in 1.2 version with mysql

```
composer require rasel9w9/data-generator:^1.2
```
To start using Laravel, add the Service Provider and the Facade to your `config/app.php`:

> **Note:** This package supports auto-discovery features of Laravel 5.5+, You only need to manually add the service provider and alias if working on Laravel version lower then 5.5.

```php
'providers' => [
    // ...
    rasel9w9\DataGenerator\DataGeneratorServiceProvider::class,
]
```

# Basic Usage

To use Data Generator add something like this to one of your controllers.

#Using Artisan Command
```php
	//to export specific table data
	php artisan alauddin:generate-table-data --table=youreTableName

	//To export All Tables Of the database
	php artisan alauddin:generate-data
```

#Using Controller
```php
//....

use rasel9w9\DataGenerator\GenerateData;

class DataController extends Controller 
{
    public function data()
    {
    	//To Generate data Of specific table
        $object = new GenerateData();
        $object->generateTableData("yourTableName");

        //To Generate data Of All The tables 
        $object->generateData();


        //The Data is saved to /database/seeders/data directory with separate table name as file name.The file(s) has no extension just open the file in a editor and you can see your table data as php array.
    }

}
```