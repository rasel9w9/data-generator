<?php namespace rasel9w9\DataGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class GenerateDataCommand extends Command
{
    protected $signature = "alauddin:generate-data";
    protected $description = "To Generate All Data As Array";
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        ini_set("memory_limit", "-1");
        ini_set("max_execution_time", 0);
        $connection = DB::getPdo();
        $result = $connection->query("SHOW TABLES");
        $tables = $result->fetchall();
        $tablesCount = count($tables);
        if (PHP_SAPI == "cli") {
            echo "Data are exporting...\n\n";
            $this->output->progressStart($tablesCount);
        }
        $i = 0;
        $dateAndTime = date("d-M-Y h-i-s");
        $dir = base_path("database/seeders/data");
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        foreach ($tables as $key => $table) {
            $phpFile = "<?php \n";
            $phpFile .=
                "/* \nData Exported By Md. Alauddin.\nDate&Time: " .
                $dateAndTime .
                "\n";
            $phpFile .=
                "Contact: email:rasel9w9@gmail.com,Phone:01817241707,01517189226\n";
            $phpFile .= "\t--IsDB BISEW Round 42(WDPF NVIT) \n*/ \n\n";
            $connection = DB::getPdo();
            $result = $connection->query("SELECT * FROM $table[0]");
            $data = $result->fetchall(\PDO::FETCH_ASSOC);
            $phpFile .= "\$$table[0] = " . var_export($data, true) . ";\n\n";
            if (PHP_SAPI == "cli") {
                $this->output->progressAdvance();
            }
            $connection = null;
            file_put_contents($dir . "/$table[0]", $phpFile);
        }
        if (PHP_SAPI == "cli") {
            $this->output->progressFinish();
            echo "Data Successfully Exported \n";
        }
    }
}