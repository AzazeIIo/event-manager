<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['type_name' => 'Art and culture'],
            ['type_name' => 'Charity'],
            ['type_name' => 'Conference'],
            ['type_name' => 'Educational'],
            ['type_name' => 'Festival'],
            ['type_name' => 'Social'],
            ['type_name' => 'Sport'],
            ['type_name' => 'Virtual'],
            ['type_name' => 'Workshop'],
        ];

        DB::table('types')->insert($data);
    }
}
