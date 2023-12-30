<?php namespace rasel9w9\DataGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class GenerateTableDataCommand extends Command
{
    protected $signature = "alauddin:generate-table-data {--table=}";
    protected $description = "To Generate Provided table Data As Array";
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        ini_set("memory_limit", "-1");
        ini_set("max_execution_time", 0);
        $table = $this->option("table");
        if (!$table) {
            $this->error(
                "Please Provide a Table name (Ex: --table=table_name)"
            );
            exit();
        }
        $connectionObj = DB::connection();
        $connectionName = $connectionObj->getName();
        $dbName = $connectionObj->getDatabaseName();
        $connection = DB::getPdo();
        if($connectionName=='mysql'){
            $result = $connection->query(
                "SELECT table_name FROM INFORMATION_SCHEMA.tables WHERE TABLE_SCHEMA='$dbName' AND TABLE_NAME='$table'"
            );
        }elseif($connectionName=='oracle'){
            $result = $connection->query(
                "SELECT TABLE_NAME FROM USER_TABLES WHERE TABLE_NAME = '$table'"
            );
        }else{
            if (PHP_SAPI == "cli") {
                $this->error(
                    "$connectionName Not Supported"
                );
                exit();
            } else {
                echo "<p style='color:red'>$connectionName Not Supported</p>";
                exit();
            }
        }
        if (!$result->fetch()) {
            if (PHP_SAPI == "cli") {
                $this->error(
                    "The table You provided is not exists in your database"
                );
                exit();
            } else {
                echo "<p style='color:red'>The table You provided is not exists in your database</p>";
                exit();
            }
        }
        $phpFile = "<?php \n";
        $phpFile .=
            "/* \nData Exported By Md. Alauddin.\nDate&Time: " .
            date("d-M-Y h-i-s") .
            "\n";
        $phpFile .=
            "Contact: email:rasel9w9@gmail.com,Phone:01817241707,01517189226\n";
        $phpFile .= "\t--IsDB BISEW Round 42(WDPF NVIT) \n*/ \n\n";
        if (PHP_SAPI == "cli") {
            echo "$table Data are exporting...\n\n";
            $this->output->progressStart(1);
        }
        $connection = DB::getPdo();
        $result = $connection->query("SELECT * FROM $table");
        $data = $result->fetchall(\PDO::FETCH_ASSOC);
        $phpFile .= "\$$table = " . var_export($data, true) . ";\n\n";
        $connection = null;
        file_put_contents(
            base_path("database/seeders/data") . "/$table",
            $phpFile
        );
        if (PHP_SAPI == "cli") {
            $this->output->progressAdvance();
            $this->output->progressFinish();
            echo "$table Successfully Exported \n";
        }
    }
}