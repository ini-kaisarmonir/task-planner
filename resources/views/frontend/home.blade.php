@extends('frontend.app')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="bg-white rounded-xl shadow p-8 text-center mb-8 border border-gray-100">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Welcome to the Task Planner & Calendar Application</h1>
<h3>Live check url: <span class="text-blue-900"><a href="https://beta.reworqx.com" target="_blank">https://beta.reworqx.com</a></span></h3>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Technical Assessment: Task Planner & Calendar</h2>
    
        <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-700">1. Installation Guide</h3>
        <p class="mb-2 text-gray-600">Follow these steps to get the application running locally:</p>
        <pre class="bg-gray-100 rounded p-3 text-sm mb-4 overflow-x-auto">
    # 1. Clone the repository
    git clone https://github.com/ini-kaisarmonir/task-planner.git

    # 2. Install PHP dependencies
    composer install

    # 3. Folder Permissions
    (If you use linux or vps)
    chmod -R 775 storage/logs/
    chmod -R 775 storage/framework/
    chmod -R 775 bootstrap/cache/
    (If you use cpanel or other panel change it manually)

    # 4. Install and compile Frontend assets
    npm install
    npm run build

    # 5. Environment Setup
    Copy the example env file and name it (.env) by running `cp .env.example .env` command (If you use cpanel or other panel copy it manually).

    # 6. Database Setup (Ensure your .env has correct DB credentials)(Currently using mysql, you can change it as per your need)
    run `php artisan migrate:fresh --seed` (If you use cpanel or other panel import the `task.sql` (it's in project root) file manually in the database)
    </pre>

    <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-700">2. Authentication & Roles</h3>
        <p class="mb-2 text-gray-600">I have used a <span class="font-medium text-blue-700">Manual Guard-based approach</span> with a <span class="bg-gray-200 px-1 rounded text-xs">role</span> column in the <span class="bg-gray-200 px-1 rounded text-xs">users</span> table. I have added four user in the seeder, here is the credentials to test:</p>
        <ul class="list-disc list-inside mb-4 text-gray-700">
            <li><span class="font-semibold">Admin:</span> <span class="bg-gray-100 px-1 rounded text-xs">admin@example.com</span> / <span class="bg-gray-100 px-1 rounded text-xs">123456</span></li>
            <li><span class="font-semibold">Employee:</span> <span class="bg-gray-100 px-1 rounded text-xs">employee@example.com</span> / <span class="bg-gray-100 px-1 rounded text-xs">123456</span></li>
            <li><span class="font-semibold">Employee 2:</span> <span class="bg-gray-100 px-1 rounded text-xs">employee2@example.com</span> / <span class="bg-gray-100 px-1 rounded text-xs">123456</span></li>
            <li><span class="font-semibold">Customer:</span> <span class="bg-gray-100 px-1 rounded text-xs">customer@example.com</span> / <span class="bg-gray-100 px-1 rounded text-xs">123456</span></li>
        </ul>

        <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-700">3. Authorization Logic</h3>
        <p class="mb-2 text-gray-600">Implemented <span class="font-medium text-blue-700">Raw Laravel Authorization</span> (no external packages used) as requested.</p>

        <div class="mb-2">
            <div class="font-semibold text-gray-700">Gates (defined in <span class="bg-gray-200 px-1 rounded text-xs">AuthServiceProvider</span>):</div>
            <ul class="list-disc list-inside text-gray-700 ml-4">
                <li><span class="bg-gray-100 px-1 rounded text-xs">'manage-tasks', 'manage-event', 'admin-only', 'view-dashboard'</span>: For access control. Customer can't access to the dashboard.</li>
            </ul>
        </div>

        <div class="mb-2">
            <div class="font-semibold text-gray-700">Policies (Model-based):</div>
            <ul class="list-disc list-inside text-gray-700 ml-4">
                <li><span class="font-semibold">TaskPolicy:</span>
                    <ul class="list-disc ml-6">
                    <li><span class="bg-blue-100 text-blue-800 px-1 rounded text-xs">create</span>: Restricted to <span class="font-semibold text-blue-700">Admin</span> only.</li>
                     <li><span class="bg-blue-100 text-blue-800 px-1 rounded text-xs">update</span>: Restricted to <span class="font-semibold text-blue-700">Admin</span> and task owner.</li>
                    
                    </ul>
                </li>
                <li><span class="font-semibold">EventPolicy:</span>
                    <ul class="list-disc ml-6">
                        <li>Ensures a user can only view events linked to tasks they own.</li>
                    </ul>
                </li>
        </li>
            </ul>
        </div>

        <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-700">4. Calendar Integration</h3>
        <p class="mb-2 text-gray-600">I have used <span class="font-medium text-blue-700">FullCalendar.js v6</span>. It fetches data via a JSON feed from the <span class="bg-gray-200 px-1 rounded text-xs">EventController which used a service for logic</span>, ensuring "time-wise" display of both scheduled events and task.</p>

    </div>
</div>
@endsection