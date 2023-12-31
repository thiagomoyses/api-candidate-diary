<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidates;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidates::factory()->count(80)->create();
    }
}
