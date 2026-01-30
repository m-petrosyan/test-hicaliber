<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('db/property-data.csv');
        if (!File::exists($csvFile)) {
            $this->command->error("CSV file not found at: {$csvFile}. Seeding aborted.");
            return;
        }
        $handle = fopen($csvFile, "r");
        if (!$handle) {
            $this->command->error("Failed to open CSV file: {$csvFile}.");
            return;
        }
        fgetcsv($handle);
        $batch = [];
        $batchSize = 1000;
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 6) {
                continue;
            }
            $batch[] = [
                'name' => trim($data[0]),
                'price' => (float) str_replace(',', '', $data[1]),
                'bedrooms' => (int) $data[2],
                'bathrooms' => (int) $data[3],
                'storeys' => (int) $data[4],
                'garages' => (int) $data[5],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (count($batch) >= $batchSize) {
                Property::query()->insert($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) {
            Property::query()->insert($batch);
        }
        fclose($handle);
    }
}
