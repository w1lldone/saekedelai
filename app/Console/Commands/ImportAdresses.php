<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportAdresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import adresses schema and data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('subdistricts');

        try {
            DB::transaction(function ()
            {
                DB::unprepared(file_get_contents(
                    base_path('database/sql/addresses.sql')
                ));
            });

            $this->info('Import success');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }

        return Command::SUCCESS;
    }
}
