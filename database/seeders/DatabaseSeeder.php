<?php

namespace Database\Seeders;

use App\Models\News;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(3)->create();
        foreach(range(1, 20) as $number){
            $date = $this->randomDate("2022-11-01 00:00:00", "2022-12-08 07:17:06");
            News::factory()->create([
                "user_id" => rand(1, 3),
                "created_at" => $date,
            ]);
        }
    }

    private function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }

}
