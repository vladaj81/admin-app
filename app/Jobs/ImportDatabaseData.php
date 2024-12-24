<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportDatabaseData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fileData;
    public $fileConfig;
    private $row = 0;

    /**
     * Create a new job instance.
     */
    public function __construct($fileData, $fileConfig)
    {
        $this->fileData = $fileData;
        $this->fileConfig = $fileConfig;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->importDataToDatabase();
    }

    /**
     * Method is not finished
     */
    public function importDataToDatabase()
    {
        $dbTable = $this->fileConfig['db_table'];
        $tableColumns = array();
        $rulesAndCasts = array();
        $castTypes = array();

        $fileHeaders = $this->fileData[0];

        foreach ($this->fileConfig['headers_to_db'] as $key => $dbColumn) {
            
            foreach ($fileHeaders as $header) {

                if ($header == $key) {
                    $rulesAndCasts[$header]['validation_rules'] = $dbColumn['validation'];
                    $rulesAndCasts[$header]['cast_type'] = $dbColumn['type'];
                }
            }
        }

        dd($rulesAndCasts);
    }
}
