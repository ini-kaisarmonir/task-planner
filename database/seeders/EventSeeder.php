<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Team standup meeting',
            'date' => now()->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
        ]);

        Event::create([
            'name' => 'Client presentation',
            'date' => now()->addDays(1)->format('Y-m-d'),
            'start_time' => '14:00:00',
            'end_time' => '15:30:00',
        ]);

        Event::create([
            'name' => 'Sprint planning session',
            'date' => now()->addDays(2)->format('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '11:30:00',
        ]);

        Event::create([
            'name' => 'Code review meeting',
            'date' => now()->addDays(3)->format('Y-m-d'),
            'start_time' => '16:00:00',
            'end_time' => '16:45:00',
        ]);

        Event::create([
            'name' => 'Project deadline',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'start_time' => '17:00:00',
            'end_time' => '18:00:00',
        ]);
    }
}
