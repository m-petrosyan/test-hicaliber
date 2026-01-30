<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class PropertiesFactoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:properties {count=10}';
    protected $description = 'Generate properties using PropertyFactory';

    public function handle(): void
    {
        $count = $this->argument('count');
        Property::factory()->count($count)->create();
        $this->info("Created $count properties successfully.");
    }
}
