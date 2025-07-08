@include('General.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


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
            )->paginate(5, ['*'], 'applied_page');

            $accTasks = \App\Models\Task::where('profile_id', $worker->id)
            ->where('status', 'in progress')
            ->paginate(5, ['*'], 'accepted_page');
            @endphp

            <!-- Tugas Dilamar -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Tugas Dilamar</h2>
                @if($appliedTasks->isEmpty())
                <p class="text-center text-gray-500">Tidak ada task yang sedang dilamar</p>
                @else
                <ul class="space-y-4 min-h-[240px]">
                    @foreach ($appliedTasks as $job)
                    <li class="flex items-center justify-between hover:bg-gray-100 hover:rounded p-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-[#1F4482]"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">{{ $job->title }}</p>
                                <p class="text-gray-400 text-xs">Applied {{ \Carbon\Carbon::parse($job->updated_at)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>
                    </li>
                    @endforeach
                </ul>
                @endif

                <!-- Pagination -->
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        @if ($appliedTasks->onFirstPage())
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
                        @else
                        <a href="{{ $appliedTasks->appends(['accepted_page' => request('accepted_page')])->previousPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
                        @endif

                        @foreach ($appliedTasks->getUrlRange(1, $appliedTasks->lastPage()) as $page => $url)
                        <a href="{{ $url }}&accepted_page={{ request('accepted_page') }}"
                            class="px-3 py-1 text-sm rounded border {{ $page == $appliedTasks->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
                            {{ $page }}
                        </a>
                        @endforeach

                        @if ($appliedTasks->hasMorePages())
                        <a href="{{ $appliedTasks->appends(['accepted_page' => request('accepted_page')])->nextPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">»</a>
                        @else
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>»</button>
                        @endif
                    </nav>
                </div>
            </div>

            <!-- Tugas Diterima -->
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Tugas Diterima</h2>
                @if($accTasks->isEmpty())
                <p class="text-center text-gray-500">Tidak ada task yang sedang diterima</p>
                @else
                <ul class="space-y-4 min-h-[240px]">
                    @foreach ($accTasks as $job)
                    <li class="flex items-center justify-between hover:bg-gray-100 hover:rounded p-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-briefcase text-[#1F4482]"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">{{ $job->title }}</p>
                                <p class="text-gray-400 text-xs">Applied {{ \Carbon\Carbon::parse($job->updated_at)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>
                    </li>
                    @endforeach
                </ul>
                @endif

                <!-- Pagination -->
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        @if ($accTasks->onFirstPage())
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
                        @else
                        <a href="{{ $accTasks->appends(['applied_page' => request('applied_page')])->previousPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
                        @endif

                        @foreach ($accTasks->getUrlRange(1, $accTasks->lastPage()) as $page => $url)
                        <a href="{{ $url }}&applied_page={{ request('applied_page') }}"
                            class="px-3 py-1 text-sm rounded border {{ $page == $accTasks->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
                            {{ $page }}
                        </a>
                        @endforeach

                        @if ($accTasks->hasMorePages())
                        <a href="{{ $accTasks->appends(['applied_page' => request('applied_page')])->nextPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">»</a>
                        @else
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>»</button>
                        @endif
                    </nav>
                </div>
            </div>
        </div>

        @php
        use Carbon\Carbon;

        $worker = Auth::user()->workerProfile;
        $recommendedTasks = \App\Models\Task::with('user')->where('status', 'open')->get();
        @endphp

        @if ($recommendedTasks->isNotEmpty())
        <div class="mt-10">
            <h2 class="text-lg font-semibold mb-4">Rekomendasi Task</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($recommendedTasks as $job)
                @php
                $showTask = true;
                $deadlinePromotion = Carbon::parse($job->deadline_promotion);

                // Sembunyikan jika deadline sudah lewat
                if ($deadlinePromotion->lt(now())) {
                $showTask = false;
                }

                // Filter berdasarkan kecocokan keahlian jika masih layak tampil
                if ($showTask && !empty($worker->keahlian)) {
                $workerSkills = json_decode($worker->keahlian, true);
                $jobCategories = json_decode($job->category, true);

                if (is_array($workerSkills) && is_array($jobCategories)) {
                $showTask = count(array_intersect(array_map('strtolower', $workerSkills), array_map('strtolower', $jobCategories))) > 0;
                } else {
                $showTask = str_contains(strtolower($job->category), strtolower($worker->keahlian));
                }
                }
                @endphp

                @if ($showTask)
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative" data-price="{{ $job->price }}">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                            alt="User" class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $job->user->nama_lengkap ?? 'Unknown' }}
                        </p>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $job->title }}</h3>

                    <div class="text-xs text-gray-500 mb-4 leading-relaxed">
                        @php
                        $hasLists = preg_match('/<ol[^>]*>|<ul[^>]*>/i', $job->description);
                                $textBeforeLists = preg_split('/<ol[^>]*>|<ul[^>]*>/i', $job->description)[0];
                                        $plainTextBeforeLists = strip_tags($textBeforeLists);
                                        $previewText = $hasLists
                                        ? Str::limit($plainTextBeforeLists, 10, '...')
                                        : Str::limit(strip_tags($job->description), 150, '...');
                                        @endphp
                                        {{ $previewText }}
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($job->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">Penutupan
                                <span class="font-semibold text-gray-500">
                                    {{ $deadlinePromotion->translatedFormat('d F Y') }}
                                </span>
                            </p>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}">
                            <button class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                                View
                            </button>
                        </a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>


<!-- modal affiliated -->
<!-- Modal -->
<div id="modalDaftarAffiliator" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center {{ $errors->any() ? '' : 'hidden' }}">
    <div class="bg-white rounded-lg w-full max-w-lg shadow-lg animate__animated animate__fadeIn mx-4 sm:mx-0 overflow-y-auto max-h-[90vh]">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Form Pendaftaran Affiliator</h2>
            <button onclick="document.getElementById('modalDaftarAffiliator').classList.add('hidden')" class="text-gray-500 hover:text-red-500">&times;</button>
        </div>

        <form action="{{ route('progress-affiliate.submited')}}" method="POST" enctype="multipart/form-data" class="px-6 pb-4 space-y-4">
            @csrf
            @php
            $user = Auth::user();

            $avgRating = $user->avg_rating; // accessor
            $countReviews = $user->receivedRatings->count(); // relasi
            $ratingError = $avgRating < 4;
                $reviewError=$countReviews < 10;
                @endphp

                <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <input type="text" readonly
                    class="w-full border rounded-md px-3 py-2 text-sm
                        {{ $ratingError ? 'border-red-500 text-red-600' : 'border-gray-300 text-gray-800' }}"
                    value="{{ number_format($avgRating, 1) }}">
                @if ($ratingError)
                <p class="text-sm text-red-600 mt-1">Rating anda lebih rendah dari 4</p>
                @endif
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan selesai</label>
        <input type="text" readonly
            class="w-full border rounded-md px-3 py-2 text-sm
                        {{ $reviewError ? 'border-red-500 text-red-600' : 'border-gray-300 text-gray-800' }}"
            value="{{ $countReviews }} ulasan">
        @if ($reviewError)
        <p class="text-sm text-red-600 mt-1">Pekerjaan yang anda selesaikan kurang dari 10</p>
        @endif
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kartu Identitas</label>
        <input type="file" name="identity_photo">
        @error('identity_photo')
        @if ($message === 'The identity photo field is required.')
        <p class="text-sm text-red-600 mt-1">Foto kartu identitas wajib diunggah.</p>
        @else
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @endif
        @enderror
    </div>


    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Selfie dengan Kartu Identitas</label>
        <input type="file" name="selfie_with_id">
        @error('selfie_with_id')
        @if ($message === 'The selfie with id field is required.')
        <p class="text-sm text-red-600 mt-1">Foto selfie dengan kartu identitas wajib diunggah.</p>
        @else
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @endif
        @enderror
    </div>


    <div class="mb-4">
        <label class="text-sm font-medium text-gray-600 mb-1 block">Kategori Task</label>
        <select id="keahlian-select" name="keahlian_affiliate[]" multiple class="w-full p-2 border rounded">
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
        @error('keahlian_affiliate')
        @if ($message === 'The keahlian affiliate field is required.')
        <p class="text-sm text-red-600 mt-1">Wajib memilih keahlian.</p>
        @else
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @endif
        @enderror
    </div>


    <!-- Checkbox persetujuan -->
    <div class="mt-4">
        <label class="inline-flex items-start space-x-2">
            <input type="checkbox" id="agreement" class="mt-1">
            <span class="text-sm text-gray-700 leading-relaxed">
                Dengan mencentang kotak ini, saya menyatakan bahwa saya telah membaca, memahami, dan menyetujui seluruh
                <a href="{{ url('/guide#sebagaiWorker') }}" class="text-blue-600 underline hover:text-blue-800 transition">
                    syarat dan ketentuan sebagai Worker
                </a>
                yang tercantum di halaman panduan.
            </span>

        </label>
    </div>

    <!-- Tombol kirim -->
    <div class="pt-4 flex justify-end">
        <button type="submit"
            id="submit-btn"
            class="bg-[#183E74] hover:bg-[#1a4a91] text-white px-6 py-2 rounded-md shadow opacity-50 cursor-not-allowed"
            disabled>
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
    document.addEventListener("DOMContentLoaded", function() {
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
<script>
    const agreementCheckbox = document.getElementById('agreement');
    const submitBtn = document.getElementById('submit-btn');

    agreementCheckbox.addEventListener('change', function() {
        if (this.checked) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;

        if (hash) {
            const tabName = hash.replace('#', '');
            showTab(tabName);
        }
    });
</script>

@include('General.footer')