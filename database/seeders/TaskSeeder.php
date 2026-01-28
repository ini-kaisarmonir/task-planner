<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use App\Enums\Priority;
use App\Enums\Status;
use App\Models\User;
use App\Models\Event;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'title' => 'Complete project documentation',
            'description' => 'Write comprehensive documentation for the task planner project',
            'user_id' => User::where('email', 'employee@example.com')->first()->id,
            'event_id' => Event::inRandomOrder()->value('id'),
            'priority' => Priority::HIGH,
            'status' => Status::PENDING,
            'due_at' => now()->addDays(2),
        ]);

        Task::create([
            'title' => 'Review team tasks',
            'description' => 'Review and approve pending team tasks',
            'user_id' => User::where('email', 'employee@example.com')->first()->id,
            'event_id' => Event::inRandomOrder()->value('id'),
            'priority' => Priority::MEDIUM,
            'status' => Status::IN_PROGRESS,
            'due_at' => now()->addDays(1),
        ]);

        Task::create([
            'title' => 'Fix calendar event bug',
            'description' => 'Debug and fix the calendar event display issue',
            'user_id' => User::where('email', 'employee2@example.com')->first()->id,
            'event_id'    => Event::inRandomOrder()->value('id'),
            'priority' => Priority::HIGH,
            'status' => Status::PENDING,
            'due_at' => now()->addDays(3),
        ]);

        Task::create([
            'title' => 'Database optimization',
            'description' => 'Optimize database queries for better performance',
            'user_id' => User::where('email', 'employee@example.com')->first()->id,
            'event_id' => Event::inRandomOrder()->value('id'),
            'priority' => Priority::MEDIUM,
            'status' => Status::PENDING,
            'due_at' => now()->addDays(5),
        ]);

        Task::create([
            'title' => 'User testing session',
            'description' => 'Conduct user testing session with stakeholders',
            'user_id' => User::where('email', 'employee2@example.com')->first()->id,
            'event_id' => Event::inRandomOrder()->value('id'),
            'priority' => Priority::HIGH,
            'status' => Status::COMPLETED,
            'due_at' => now()->subDays(1),
        ]);

        Task::create([
            'title' => 'Update API documentation',
            'description' => 'Update REST API documentation with new endpoints',
            'user_id' => User::where('email', 'employee2@example.com')->first()->id,
            'event_id'    => Event::inRandomOrder()->value('id'),
            'priority' => Priority::LOW,
            'status' => Status::PENDING,
            'due_at' => now()->addDays(7),
        ]);

        Task::create([
            'title' => 'Deploy to production',
            'description' => 'Deploy latest version to production server',
            'user_id' => User::where('email', 'employee2@example.com')->first()->id,
            'event_id'    => Event::inRandomOrder()->value('id'),
            'priority' => Priority::HIGH,
            'status' => Status::PENDING,
            'due_at' => now()->addDays(4),
        ]);

        Task::create([
            'title' => 'Setup monitoring alerts',
            'description' => 'Configure monitoring and alert system for production',
            'user_id' => User::where('email', 'employee@example.com')->first()->id,
            'event_id'    => Event::inRandomOrder()->value('id'),
            'priority' => Priority::MEDIUM,
            'status' => Status::IN_PROGRESS,
            'due_at' => now()->addDays(2),
        ]);
    }
}
