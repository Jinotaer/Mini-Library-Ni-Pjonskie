 <!-- Sidebar -->
 <aside class="w-64 bg-[#0f0f23] flex flex-col border-r border-white/5 h-full">
     <!-- Logo Section -->
     <div class="p-6 flex items-center space-x-3 border-b border-white/5">
         <div
             class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex-shrink-0 flex items-center justify-center shadow-lg">
             <span class="text-white font-bold text-sm">BU</span>
         </div>
         <div>
             <h1 class="text-sm font-bold text-white leading-tight">BukSU</h1>
             <p class="text-[10px] text-gray-400 uppercase tracking-wider">Library Management</p>
         </div>
     </div>

     <!-- Navigation -->
     <nav class="flex-1 px-4 space-y-1 mt-6">
    @php
        if (isset($activePage)) {
            $currentPage = $activePage;
        } else {
            if (request()->routeIs('dashboard')) {
                $currentPage = 'dashboard';
            } elseif (request()->routeIs('students.*')) {
                $currentPage = 'students';
            } elseif (request()->routeIs('books.*')) {
                $currentPage = 'books';
            } elseif (request()->routeIs('authors.*')) {
                $currentPage = 'authors';
            } elseif (request()->routeIs('borrows.*')) {
                $currentPage = 'borrows'; // Use 'borrowing' to match the nav item key
            }
             elseif (request()->routeIs('profile.*')) {
                $currentPage = 'settings';
            } else {
                $currentPage = 'dashboard';
            }
        }

        $navItems = [
            [
                'label' => 'Dashboard',
                'key' => 'dashboard',
                'href' => route('dashboard'),
                'icon' =>
                    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            ],
            [
                'label' => 'Student Management',
                'key' => 'students',
                'href' => route('students.index'),
                'icon' =>
                    'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            ],
            [
                'label' => 'Books Inventory',
                'key' => 'books',
                'href' => route('books.index'),
                'icon' =>
                    'M12 6.042A8.967 8.967 0 006 3.75c-1.153 0-2.23.23-3.25.645A1.5 1.5 0 002 5.793v11.914a1.5 1.5 0 001.5 1.5c1.153 0 2.23-.23 3.25-.645A8.967 8.967 0 0112 17.25a8.967 8.967 0 015.25 1.312c1.02.415 2.097.645 3.25.645a1.5 1.5 0 001.5-1.5V5.793a1.5 1.5 0 00-.75-1.298A8.963 8.963 0 0018 3.75c-2.074 0-4.017.655-5.25 1.792M12 6.042v11.208',
            ],
            [
                'label' => 'Authors Management',
                'key' => 'authors',
                'href' => route('authors.index'),
                'icon' =>
                    'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
            ],
            [
                'label' => 'Borrowing Records',
                'key' => 'borrows',
                'href' => route('borrows.index'),
                'icon' =>
                    'M9 12.75h6m-6 3h6m-6-9h6m-3-4.5h-3.75a1.5 1.5 0 00-1.5 1.5v.75H6a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0015.75 4.5h-.75V3.75a1.5 1.5 0 00-1.5-1.5z',
            ],
            [
                'label' => 'Settings',
                'key' => 'settings',
                'href' => route('profile.edit'),
                'icon' => [
                    'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                    'M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                ],
            ],
        ];
    @endphp

         @foreach ($navItems as $item)
             <a href="{{ $item['href'] }}"
                 class="nav-link flex items-center space-x-3 p-3 rounded-xl transition-all {{ $currentPage === $item['key'] ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 font-semibold' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     @if (is_array($item['icon']))
                         @foreach ($item['icon'] as $path)
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="{{ $path }}" />
                         @endforeach
                     @else
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="{{ $item['icon'] }}" />
                     @endif
                 </svg>
                 <span class="font-medium text-sm">{{ $item['label'] }}</span>
             </a>
         @endforeach
     </nav>

     <!-- Logout -->
    <div class="p-4 border-t border-white/5">
        <form action="{{ route('logout') }}" method="POST"
            class="nav-link flex items-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 p-3 rounded-xl transition-all">
             @csrf
             <button type="submit" class="w-full flex items-center space-x-3">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                 </svg>
                 <span class="font-medium text-sm">Logout</span>
             </button>
         </form>
     </div>
 </aside>
