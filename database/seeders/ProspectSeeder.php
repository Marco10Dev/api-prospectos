<?php

namespace Database\Seeders;
use App\Models\Prospect;
use App\Models\FollowUp;
use Illuminate\Database\Seeder;

class ProspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea 25 prospectos
        Prospect::factory()->count(25)->create()->each(function ($prospect) {
            // Si el estado no es 'new' se crea un estado ficticio de seguimiento para el prospecto
            if ($prospect->status !== 'new') {
                FollowUp::factory()->count(rand(1, 3))->create([
                    'prospect_id' => $prospect->id
                ]);
            }
        });
    }
}
