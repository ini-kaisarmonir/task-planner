        <aside class="w-64 bg-white border-r hidden md:block">
            <nav class="p-4 space-y-2 text-sm">

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-gray-100 font-medium">
                    Dashboard
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Tasks
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Calendar
                </a>

                @can('admin-only')
                    <a href="#"
                       class="block px-4 py-2 rounded hover:bg-gray-100 text-blue-600">
                        Admin Panel
                    </a>
                @endcan

            </nav>
        </aside>