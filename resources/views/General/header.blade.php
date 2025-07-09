<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Empowr - Connect, Collaborate, Succeed!</title>

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
      href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Liter&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prata&display=swap"
      rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
   <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <link rel="icon" href="{{ asset('assets/images/logosaja.png') }}" type="image/png">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
      data-client-key="{{config('midtrans.client_key')}}"></script>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
   <script src="https://cdn.tailwindcss.com"></script>

   <!-- swiper js untuk scroll gambar -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


   <style>
      body {
         font-family: "Poppins", sans-serif;
      }
   </style>

   <style>
      .job-description ol,
      .job-qualification ol,
      .rules ol {
         list-style-type: decimal;
         margin-left: 1.5rem;
      }

      .job-description ul,
      .job-qualification ul,
      .rules ul {
         list-style-type: disc;
         margin-left: 1.5rem;
      }

      .job-description li,
      .job-qualification li,
      .rules li {
         margin-top: 0.25rem;
         margin-bottom: 0.25rem;
      }

      .job-description.text-gray-600.leading-relaxed ol,
      .job-qualification.text-gray-600.leading-relaxed ol,
      .rules.text-gray-600.leading-relaxed ol,
      .job-description.text-gray-600.leading-relaxed ul,
      .job-qualification.text-gray-600.leading-relaxed ul,
      .rules.text-gray-600.leading-relaxed ul {
         list-style-position: outside !important;
         padding-left: 2rem !important;
         margin-top: 0.5rem !important;
         margin-bottom: 0.5rem !important;
      }

      .job-description.text-gray-600.leading-relaxed li,
      .job-qualification.text-gray-600.leading-relaxed li,
      .rules.text-gray-600.leading-relaxed li {
         margin-bottom: 0.5rem !important;
         display: list-item !important;
      }

      .job-description.text-gray-600.leading-relaxed ol,
      .job-qualification.text-gray-600.leading-relaxed ol,
      .rules.text-gray-600.leading-relaxed ol {
         list-style-type: decimal !important;
      }

      .job-description.text-gray-600.leading-relaxed ul,
      .job-qualification.text-gray-600.leading-relaxed ul,
      .rules.text-gray-600.leading-relaxed ul {
         list-style-type: disc !important;
      }
   </style>

   <style>
      .sidebar-item {
         transition: background-color 0.3s ease, color 0.3s ease;
      }

      .sidebar-item.active {
         background-color: #1F4482;
         color: white;
      }

      .sidebar-item.active i {
         color: white;
      }

      .sidebar-item:hover,
      .sidebar-item:focus {
         background-color: #18346a;
         color: white;
      }

      .sidebar-item:hover i {
         color: white;
      }

      .sidebar-item:focus i {
         color: white;
      }
   </style>


</head>

<body class="bg-gray-100" style="font-family: sans-serif;">
   <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
         <div class="flex items-center justify-between">
            <!-- Kiri: Toggle Sidebar & Logo -->
            <div class="flex items-center">
               <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                  type="button"
                  class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                  <span class="sr-only">Open sidebar</span>
                  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                     </path>
                  </svg>
               </button>
               <a href="{{ Auth::user()->role === 'client' ? route('client.dashboardClient') : route('worker.dashboardWorker') }}" class="flex items-center ms-2">
                  <img src="{{ asset('assets/images/Logo.png') }}" class="h-5" alt="Empowr Logo">
               </a>
            </div>

            <div class="flex items-center space-x-3">
               <button class="w-8 h-8 bg-gray-300 text-[#1F4482] rounded-full flex items-center justify-center">
                  <i class="fa-solid fa-bookmark"></i>
               </button>

               <div class="relative inline-block">
                  <button onclick="toggleDropdown()"
                     class="w-8 h-8 bg-gray-300 text-[#1F4482] rounded-full flex items-center justify-center relative">
                     <i class="fa-solid fa-bell"></i>
                     @if ($unreadCount > 0)
                     <span
                        class="absolute -top-1 -right-1 bg-red-400 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center border border-white">
                        {{ $unreadCount }}
                     </span>
                     @endif
                  </button>
                  <div id="dropdown-notif"
                     class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                     <div class="px-4 py-2 font-semibold text-[#1F4482] border-b">Notification</div>

                     @foreach ($notifications as $notif)
                     @php
                     // Dapatkan user pengirim
                     $sender = \App\Models\User::where('nama_lengkap', $notif->sender_name)->first();
                     @endphp

                     <a
                        @if($notif->jenis === 'chat' && $sender)
                        href="{{ url('chat/' . $sender->id) }}"
                        @else
                        href="{{ route('notifications.index') }}"
                        @endif
                        class="block px-4 py-2 border-b hover:bg-gray-50"
                        >
                        <p class="font-semibold">{{ $notif->sender_name }}</p>
                        <p class="text-sm text-gray-700">{!! $notif->message !!}</p>
                        <p class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</p>
                     </a>
                     @endforeach

                     <a href="{{ route('notifications.index') }}"
                        class="block px-4 py-2 text-center text-[#1F4482] hover:underline">
                        Lihat Semua Notifikasi
                     </a>
                  </div>

               </div>

               <!-- User -->
               <div class="relative">
                  <button type="button"
                     class="flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                     data-dropdown-toggle="dropdown-user">
                     <img class="w-8 h-8 rounded-full"
                        src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/images/avatar.png') }}"
                        alt="User photo">
                     <div class="ml-2 text-left hidden sm:block">
                        <div class="text-sm font-medium text-gray-900 leading-none font-semibold">
                           {{ Auth::user()->nama_lengkap }}
                        </div>
                        <div class="text-xs text-gray-500"> {{ Auth::user()->role }}</div>
                     </div>
                  </button>
                  <div
                     class="z-50 min-w-[200px] max-w-[300px] hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm"
                     id="dropdown-user">
                     <div class="px-4 py-3" role="none">
                        <p class="text-sm font-medium text-gray-900 truncate font-semibold" role="none">
                           {{ Auth::user()->email }}
                        </p>
                     </div>

                     <ul class="py-1" role="none">
                        @if(Auth::user()->role !== 'admin')
                        <li>
                           <a href="{{route('profil')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                              role="menuitem">Profile</a>
                        </li>
                        <li>
                           <a href="{{ route('ewallet.index', Auth::user()->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                              Wallet <span class="text-blue-500">IDR {{ Auth::user()->ewallet?->balance }}</span>
                           </a>
                        </li>
                        @endif
                        <li>
                           <form id="logoutForm" action="{{ route('logout') }}" method="POST">@csrf</form>
                           <button id="logoutBtn" type="button"
                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                              Sign out
                           </button>
                        </li>
                     </ul>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </nav>

   @if(auth()->check() && (auth()->user()->role === 'worker' || auth()->user()->role === 'client'))
   <aside id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200"
      aria-label="Sidebar">
      <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
         <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
               <a href="{{ Auth::user()->role === 'client' ? route('client.dashboardClient') : route('worker.dashboardWorker') }}"
                  class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-house text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Beranda</span>
               </a>
            </li>

            <!-- Jobs -->
            <li>
               <a href="{{ route('jobs.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-briefcase text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Semua Tugas</span>
               </a>
            </li>

            <!-- My Job -->
            <li>
               <a href="{{ Auth::user()->role === 'client' ? route('jobs.my') : route('jobs.Worker') }}"
                  class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-person-workspace text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Tugas Saya</span>
               </a>
            </li>

            <!-- Chat -->
            <li>
               <a href="{{ route('chat.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-chat-dots text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Chat</span>
               </a>
            </li>

            <!-- Arbitrase -->
            <li>
               <a href="{{ url('/arbitrase') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-person-lines-fill text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Arbitrase</span>
               </a>
            </li>

            <!-- Guide -->
            <li>
               <a href="{{ url('/guide') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-book text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Petunjuk</span>
               </a>
            </li>

            <!-- Affiliate -->
            <li>
               <a href="{{ url('/affiliate') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-currency-dollar text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Affiliasi</span>
               </a>
            </li>

            <!-- Contact Admin -->
            <li>
               <a href="{{ url('/contact-admin') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-telephone text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Hubungi Admin</span>
               </a>
            </li>
         </ul>
      </div>
   </aside>
   @elseif (auth()->user()->role === 'admin')
   <aside id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200"
      aria-label="Sidebar">
      <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
         <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
               <a href="{{ route('admin.dashboardAdmin') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-house text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Dashboard</span>
               </a>
            </li>

            <!-- Jobs -->
            <li>
               <a href="{{ route('jobs.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-briefcase text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Jobs</span>
               </a>
            </li>


            <!-- Pencairan dana -->
            <li>
               <a href="{{ route('withdraw.view') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-currency-dollar text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Pencairan dana</span>
               </a>
            </li>

            <!-- Chat -->
            <li>
               <a href="{{ route('chat.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-chat-dots text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Chat</span>
               </a>
            </li>

            <!-- Arbitrase -->
            <li>
               <a href="{{ route('arbitrase.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-person-lines-fill text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Arbitrase</span>
               </a>
            </li>

            <!-- User Control -->
            <li>
               <a href="{{ route('user.control') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-person-lines-fill text-lg text-[#1F4482]"></i>
                  <span class="ml-3">User Control</span>
               </a>
            </li>

            <!-- Affiliate -->
            <li>
               <a href="{{ route('List-pengajuan-task-affiliate.view') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-people text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Affiliate</span>
               </a>
            </li>
            <li>
               <a href="{{ route('List-pengajuan-worker-affiliate.view') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                  <i class="bi bi-people text-lg text-[#1F4482]"></i>
                  <span class="ml-3">Pendaftaran Affiliate</span>
               </a>
            </li>
         </ul>
      </div>
   </aside>
   @endif

   <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" onclick="closeSidebar()">
   </div>

   <!-- Logout Modal -->
   <div id="logoutModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
      <div class="bg-white p-6 rounded shadow-md w-80">
         <h2 class="text-lg font-semibold mb-4">Konfirmasi Keluar</h2>
         <p class="mb-4">Kamu yakin ingin keluar?</p>
         <div class="flex justify-end gap-2">
            <button id="cancelLogout" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button id="confirmLogout" class="px-4 py-2 bg-red-600 text-white rounded">Keluar</button>
         </div>
      </div>
   </div>

   <script>
      document.addEventListener("DOMContentLoaded", function() {
         const currentUrl = window.location.href;
         const sidebarItems = document.querySelectorAll('.sidebar-item');

         sidebarItems.forEach(item => {
            const link = item.getAttribute('href'); // Ambil href dari link
            if (currentUrl.includes(link)) {
               item.classList.add('active'); // Tambahkan kelas active pada item yang sesuai
            } else {
               item.classList.remove('active'); // Hapus kelas active pada item yang tidak sesuai
            }
         });
      });
   </script>