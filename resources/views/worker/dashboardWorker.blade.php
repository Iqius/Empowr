@include('General.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


<div class="p-4 ">
    <div class="p-4 mt-14">
       
        @if($workerProfile->empowr_affiliate != true)
            @if($hasAffiliation)
                <a href="{{ route('progress-affiliate.view', ['id' => $affiliation]) }}) }}" 
                class="inline-block bg-gray-600 text-white px-8 py-2 rounded-md shadow mb-6 cursor-pointer">
                    Cek Pengajuan Affiliasi
                </a>
            @else
                <a onclick="document.getElementById('modalDaftarAffiliator').classList.remove('hidden')" 
                class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow mb-6 cursor-pointer">
                    Bergabung Affiliator
                </a>
            @endif
        @endif


        <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
            Tugas Kamu
            <span class="text-gray-400 text-base">
                <i class="fas fa-info-circle"></i>
            </span>
        </h2>

        @php
            $worker = Auth::user()->workerProfile;
            $lamarTasks = \App\Models\TaskApplication::where('profile_id', $worker->id)
                ->where('status', 'pending')
                ->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Task Dilamar -->
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-desktop text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Tugas Dilamar</p>
                    <p class="text-4xl font-bold">{{ $lamarTasks }}</p>
                </div>
            </div>

            @php
                $worker = Auth::user()->workerProfile;
                $progressTasks = \App\Models\Task::where('profile_id', $worker->id)
                    ->where('status', 'in progress')
                    ->count();
            @endphp

            <!-- Sedang Berjalan -->
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-handshake text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Sedang Berjalan</p>
                    <p class="text-4xl font-bold">{{ $progressTasks }}</p>
                </div>
            </div>

            @php
                $worker = Auth::user()->workerProfile;
                $completedTasks = \App\Models\Task::where('profile_id', $worker->id)
                    ->where('status', 'completed')
                    ->count();
            @endphp

            <!-- Task Selesai -->
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-clipboard-check text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Tugas Selesai</p>
                    <p class="text-4xl font-bold">{{ $completedTasks }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $worker = Auth::user()->workerProfile;
                $appliedTasks = \App\Models\Task::whereIn(
                    'id',
                    \App\Models\TaskApplication::where('profile_id', $worker->id)->pluck('task_id')
                )->paginate(5);  // Menampilkan 5 item per halaman
            @endphp
            <!-- Applied Jobs -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Tugas Dilamar</h2>
                @if($appliedTasks->isEmpty())
                    <p class="text-center text-gray-500">Tidak ada task yang sedang dilamar</p>
                @else
                    <ul class="space-y-1">
                        @foreach ($appliedTasks as $job)
                            <li class="flex items-center justify-between hover:bg-gray-100 hover:rounded p-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                        <i class="fas fa-briefcase text-[#1F4482]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm md:text-base">{{ $job->title }}</p>
                                        <p class="text-gray-400 text-xs">Applied
                                            {{ \Carbon\Carbon::parse($job->updated_at)->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</button>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Pagination -->
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        <!-- Previous Button -->
                        @if($appliedTasks->onFirstPage())
                            <button class="border px-3 py-1 text-sm rounded disabled opacity-50" disabled>
                                <i class="fas fa-angle-left"></i>
                            </button>
                        @else
                            <a href="{{ $appliedTasks->previousPageUrl() }}" class="border px-3 py-1 text-sm rounded">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        @endif

                        <!-- Pagination Links -->
                        @foreach ($appliedTasks->links()->elements[0] as $page => $url)
                            <button
                                class="border px-3 py-1 text-sm rounded {{ $page == $appliedTasks->currentPage() ? 'bg-[#1F4482] text-white' : 'text-[#1F4482]' }}">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </button>
                        @endforeach

                        <!-- Next Button -->
                        @if($appliedTasks->hasMorePages())
                            <a href="{{ $appliedTasks->nextPageUrl() }}" class="border px-3 py-1 text-sm rounded">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        @else
                            <button class="border px-3 py-1 text-sm rounded disabled opacity-50" disabled>
                                <i class="fas fa-angle-right"></i>
                            </button>
                        @endif
                    </nav>
                </div>
            </div>

            @php
                $worker = Auth::user()->workerProfile;
                $accTasks = \App\Models\Task::where('profile_id', $worker->id)
                    ->where('status', 'in progress') // pastikan status task diterima
                    ->paginate(5);  // Menampilkan 1 item per halaman
            @endphp
            <!-- Accept Jobs -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Tugas Diterima</h2>
                @if($accTasks->isEmpty())
                    <p class="text-center text-gray-500">Tidak ada task yang sedang diterima</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($accTasks as $job)
                            <li class="flex items-center justify-between hover:bg-gray-100 hover:rounded p-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                        <i class="fas fa-briefcase text-[#1F4482]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm md:text-base">{{ $job->title }}</p>
                                        <p class="text-gray-400 text-xs">Applied
                                            {{ \Carbon\Carbon::parse($job->updated_at)->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</button>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <!-- Pagination -->
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        <!-- Previous Button -->
                        @if($accTasks->onFirstPage())
                            <button class="border px-3 py-1 text-sm rounded disabled opacity-50" disabled>
                                <i class="fas fa-angle-left"></i>
                            </button>
                        @else
                            <a href="{{ $accTasks->previousPageUrl() }}" class="border px-3 py-1 text-sm rounded">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        @endif

                        <!-- Pagination Links -->
                        @foreach ($accTasks->links()->elements[0] as $page => $url)
                            <button
                                class="border px-3 py-1 text-sm rounded {{ $page == $accTasks->currentPage() ? 'bg-[#1F4482] text-white' : 'text-[#1F4482]' }}">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </button>
                        @endforeach

                        <!-- Next Button -->
                        @if($accTasks->hasMorePages())
                            <a href="{{ $accTasks->nextPageUrl() }}" class="border px-3 py-1 text-sm rounded">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        @else
                            <button class="border px-3 py-1 text-sm rounded disabled opacity-50" disabled>
                                <i class="fas fa-angle-right"></i>
                            </button>
                        @endif
                    </nav>
                </div>
            </div>
        </div>


        <div class="mt-10">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Rekomendasi Task</h2>
                <a href="{{ route('jobs.index') }}" class="text-sm text-[#1F4482] font-medium hover:underline">View
                    More</a>
            </div>


            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- Task Card -->
                <!-- Job Card -->
                @php
                    $worker = Auth::user()->workerProfile;
                    $task = \App\Models\Task::where('status', 'open')->get();
                @endphp


                @foreach ($task as $job)
                    @php
                        // Hapus tanda kurung dan tanda kutip dari kategory
                        $category = str_replace(['[', ']', '"'], '', $job->kategory);
                    @endphp

                    @if(strtolower(trim($category)) == strtolower(trim($worker->keahlian)))
                        <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative"
                            data-price="{{ $job->price }}">
                            <!-- Save Button -->
                            <button class="absolute top-3 right-3 text-gray-400 hover:text-[#1F4482] transition">
                                <i class="fa-regular fa-bookmark text-lg"></i>
                            </button>

                            <!-- User Info -->
                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                                    alt="User" class="w-9 h-9 rounded-full object-cover" />
                                <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                                    {{ $job->user->nama_lengkap ?? 'Unknown' }}
                                    <span class="text-[#1F4482]">✔</span>
                                </p>
                            </div>

                            <!-- Job Title -->
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">
                                {{ $job->title }}
                            </h3>

                            <!-- Description -->
                            <div class="text-xs text-gray-500 mb-4 leading-relaxed">
                                @php
                                    // Check if the description contains ordered or unordered lists
                                    $hasLists = preg_match('/<ol[^>]*>|<ul[^>]*>/i', $job->description);

                                    // Get the text before any list appears
                                    $textBeforeLists = preg_split('/<ol[^>]*>|<ul[^>]*>/i', $job->description)[0];

                                    // Strip any HTML tags from this text
                                    $plainTextBeforeLists = strip_tags($textBeforeLists);

                                    // Create the preview - if there are lists, add ellipsis
                                    if ($hasLists) {
                                        // Limit the text before the list and add ellipsis
                                        $previewText = Str::limit($plainTextBeforeLists, 10, '...');
                                    } else {
                                        // If no lists, just use normal limit
                                        $previewText = Str::limit(strip_tags($job->description), 150, '...');
                                    }
                                @endphp
                                {{ $previewText }}
                            </div>

                            <!-- Bottom Row: Price + Button -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Rp
                                        {{ number_format($job->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-400">Penutupan <span
                                            class="font-semibold text-gray-500">{{ \Carbon\Carbon::parse($job->deadline_promotion)->translatedFormat('d F Y') }}
                                        </span></p>
                                </div>
                                <a href="{{ route('jobs.show', $job->id) }}">
                                    <button
                                        class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                                        View
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</div>


<!-- modal affiliated -->
<!-- Modal -->
<div id="modalDaftarAffiliator" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-full max-w-lg shadow-lg animate__animated animate__fadeIn">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Form Pendaftaran Affiliator</h2>
            <button onclick="document.getElementById('modalDaftarAffiliator').classList.add('hidden')" class="text-gray-500 hover:text-red-500">&times;</button>
        </div>

        <!-- Alert -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 px-4 py-3 mt-4 mx-6 rounded" role="alert">
            <p class="text-sm font-medium">Mendaftar ini berarti patuh kepada persyaratan <strong>Empowr</strong>.</p>
        </div>

        <form action="{{ route('progress-affiliate.submited')}}" method="POST" enctype="multipart/form-data" class="px-6 pb-4 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kartu Identitas</label>
                <input type="file" name="identity_photo" required class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Selfie dengan Kartu Identitas</label>
                <input type="file" name="selfie_with_id" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-gray-600 mb-1 block">Kategori Task</label>
                <select id="keahlian-select" name="kategoriWorker[]" multiple class="w-full p-2 border rounded">
                    @php
                        $selectedSkills = json_decode(optional(Auth::user()->keahlian)->keahlian, true) ?? [];
                        $categories = [
                            "Web Development", "Mobile Development", "Game Development", "Software Engineering",
                            "Frontend Development", "Backend Development", "Full Stack Development", "DevOps",
                            "QA Testing", "Automation Testing", "API Integration", "WordPress Development",
                            "Data Science", "Machine Learning", "AI Development", "Data Engineering", "Data Entry",
                            "SEO", "Content Writing", "Technical Writing", "Blog Writing", "Copywriting",
                            "Scriptwriting", "Proofreading", "Translation", "Transcription", "Resume Writing",
                            "Ghostwriting", "Creative Writing", "Social Media Management", "Digital Marketing",
                            "Email Marketing", "Affiliate Marketing", "Influencer Marketing", "Community Management",
                            "Search Engine Marketing", "Branding", "Graphic Design", "UI/UX Design", "Logo Design",
                            "Motion Graphics", "Illustration", "Video Editing", "Video Production", "Animation",
                            "3D Modeling", "Video Game Design", "Audio Editing", "Photography", "Photo Editing",
                            "Presentation Design", "Project Management", "Virtual Assistant", "Customer Service",
                            "Lead Generation", "Market Research", "Business Analysis", "Human Resources",
                            "Event Planning", "Bookkeeping", "Accounting", "Tax Preparation", "Financial Analysis",
                            "Legal Advice", "Contract Drafting", "Startup Consulting", "Investment Research",
                            "Real Estate Consulting", "Personal Assistant", "Clerical Work", "Data Analysis",
                            "Business Coaching", "Career Coaching", "Life Coaching", "Consulting", "Other"
                        ];
                    @endphp

                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ in_array($category, $selectedSkills) ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-[#183E74] hover:bg-[#1a4a91] text-white px-6 py-2 rounded-md shadow">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>





<!-- UNTUK MODAL AFFILIATED -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect('#keahlian-select', {
        plugins: ['remove_button'],
        placeholder: 'Pilih Kategori Keahlian...',
        persist: false,
        create: false,
        maxItems: null,
        hideSelected: true
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ✅ SweetAlert for Success Message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Login!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1F4482',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href;
            });
        @endif
        @if(session('success-order-affiliated'))
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran berhasil dikirim!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1F4482',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href;
            });
        @endif
    });
</script>
@include('General.footer')