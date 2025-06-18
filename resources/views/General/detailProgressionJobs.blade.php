@include('General.header')


<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="flex flex-wrap gap-4 text-sm sm:text-base overflow-x-auto">
            <button
                class="tab-button text-white font-semibold py-2 px-4 rounded-md transition-all duration-300 bg-[#1F4482] focus:outline-none"
                data-tab="progres">
                Detail Progres
            </button>
            <button
                class="tab-button text-gray-600 font-semibold py-2 px-4 rounded-md transition-all duration-300 hover:bg-[#1F4482] hover:text-white focus:outline-none active:bg-[#1F4482] active:text-white"
                data-tab="detail">
                Informasi Task
            </button>
        </div>
    </div>


    <div id="progres" class=" tab-content p-4 rounded h-full">
        <!-- Button Complete -->
        @if(auth()->user()->role == 'client')
        <div class="flex justify-end space-x-4 mb-7">

            <button type="button" onclick="openModal()"
                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 ease-in-out transform hover:scale-105 mt-4">
                Selesaikan Task
            </button>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border flex flex-col h-full space-y-6">
            <div class="flex flex-col gap-4 py-6 px-4">
                <div class="flex justify-between items-center relative">
                    @php
                    $stepsData = [
                    ['label' => 'Progres Ke-1', 'key' => 'step1'],
                    ['label' => 'Progres Ke-2', 'key' => 'step2'],
                    ['label' => 'Progres Ke-3', 'key' => 'step3'],
                    ['label' => 'Selesai', 'key' => 'step4']
                    ];
                    @endphp

                    @foreach ($stepsData as $index => $step)
                    @php
                    $status = $steps[$step['key']] ?? 'pending';
                    $isCompleted = $status === 'approved';
                    $isRejected = $status === 'rejected';
                    $isCurrent = $status === 'pending';
                    @endphp

                    <div class="flex-1 flex flex-col items-center z-10 relative">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center
                                @if($isCompleted)
                                    bg-green-500 text-white
                                @elseif($isRejected)
                                    bg-red-500 text-white
                                @elseif($isCurrent)
                                    bg-blue-500 text-white animate-pulse
                                @else
                                    bg-gray-300 text-gray-600
                                @endif
                                shadow-md transition-all">
                            @if($isCompleted)
                            <i class="fas fa-check"></i>
                            @elseif($isRejected)
                            <i class="fas fa-times"></i>
                            @else
                            <i class="fas fa-dot-circle"></i>
                            @endif
                        </div>
                        <p class="mt-2 text-sm font-semibold text-center 
                                @if($isCompleted) text-green-600
                                @elseif($isRejected) text-red-600
                                @elseif($isCurrent) text-blue-600
                                @else text-gray-500 @endif">
                            {{ $step['label'] }}
                        </p>
                    </div>

                    @if($index < count($stepsData) - 1)
                        <div class="flex-1 h-1 bg-gradient-to-r from-blue-200 via-gray-300 to-blue-200">
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <!-- Card Section: selalu di bawah -->
        <div class="flex flex-col gap-4 p-4">
            <!-- Single Card for Worker -->
            @if(auth()->user()->role == 'worker')
            @php
            $currentStep = $progressionsByStep->count() + 1;
            $maxSteps = 3 + $task->revisions; // 3 progression + jumlah revisi yang dibolehkan
            $latestProgression = $progressionsByStep->last();

            // Fix for initial submission - ensure canSubmit is true for first submission
            $canSubmitInitial = ($progressionsByStep->isEmpty() || ($latestProgression && $latestProgression->status_approve !== 'waiting'));
            @endphp

            <div class="flex flex-col gap-4 py-6 px-4">
                <!-- Current Status Section (simplified) -->
                <div class="mb-4">
                    <h2 class="font-bold text-lg mb-2">Status Progres</h2>

                    @if($progressionsByStep->count() > 0)
                    <div class="border-b pb-3 mb-3">
                        <p class="text-gray-700">Tahap saat ini:
                            <span class="text-red-600 font-semibold">
                                @if($currentStep > 3)
                                Revisi Ke-{{ $currentStep - 3 }}
                                @else
                                Progression Ke-{{ $currentStep }}
                                @endif
                            </span>
                        </p>

                        @if($latestProgression)
                        <p class="text-gray-700 mt-2">Status terakhir:
                            <span
                                class="font-semibold {{ $latestProgression->status_approve === 'approved' ? 'text-green-600' :
                                                ($latestProgression->status_approve === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                {{ ucfirst($latestProgression->status_approve) }}
                            </span>
                        </p>

                        @if($latestProgression->note)
                        <p class="text-gray-700 mt-1">Note: {{ $latestProgression->note }}</p>
                        @endif
                        @endif
                    </div>
                    @else
                    <div class="border-b pb-3 mb-3">
                        <p>Tahap saat ini:
                            <span class="text-red-600 font-semibold">Progression Ke-1</span>
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Submission Section -->
                @if($canSubmitInitial && $currentStep <= $maxSteps)
                    <div>
                    <h2 class="font-bold text-lg mb-2">
                        @if($currentStep > 3)
                        Submit Revisi Ke-{{ $currentStep - 3 }}
                        @else
                        Submit Progression Ke-{{ $currentStep }}
                        @endif
                    </h2>

                    <form action="{{ route('task-progression.store', $task->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="file-upload"
                            class="group cursor-pointer bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-300 w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                            <div
                                class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                                📄</div>
                            <p class="text-gray-700 font-medium">Klik untuk mengunggah file</p>
                        </label>

                        <input id="file-upload" type="file" name="file" class="hidden" required>

                        <div id="file-name-display" class="mt-2 text-sm text-gray-600 hidden">
                            File dipilih: <span id="selected-file-name" class="font-medium"></span>
                        </div>

                        <p class="mt-4 text-sm text-gray-600">Tanggal di submit:
                            {{ now()->format('d-m-Y H:i')}}
                        </p>

                        <button type="submit"
                            class="mt-4 w-full py-3 bg-[#1F4482] rounded text-white hover:bg-[#18346a] font-semibold transition-colors">Submit</button>
                    </form>
            </div>
            @else
            <div class="bg-gray-100 rounded p-4 text-center">
                @if($currentStep > $maxSteps)
                <p class="text-gray-700">Semua tahap sudah diselesaikan</p>
                @else
                <p class="text-gray-700">Menunggu review dari client untuk melanjutkan</p>
                @endif
            </div>
            @endif
        </div>
        @endif

        <!-- Card untuk Client -->
        @if(auth()->user()->role == 'client')
        @php
        $lastProgression = $progressions->sortByDesc('progression_ke')->first();
        @endphp

        <div class="flex flex-col gap-4 py-6 px-4">
            <h2 class="font-bold text-lg mb-4">Review Progress</h2>

            @if($progressions->count() == 0)
            <p class="text-gray-700">Belum ada progress yang diupload.</p>
            @else
            <!-- Latest Submission Only -->
            <div>
                <h3 class="font-semibold text-md">
                    @if($lastProgression->progression_ke > 3)
                    Revisi Ke-{{ $lastProgression->progression_ke - 3 }}
                    @else
                    Progression Ke-{{ $lastProgression->progression_ke }}
                    @endif
                </h3>

                <a href="{{ asset('storage/' . $lastProgression->path_file) }}" target="_blank"
                    class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100 mt-2">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                        📄</div>
                    <p class="text-gray-700 font-medium">{{ basename($lastProgression->path_file) }}</p>
                </a>

                <p class="mt-2 text-sm text-gray-500">Tanggal Submit:
                    {{ $lastProgression->date_upload?->format('d M Y H:i') ?? '-' }}
                </p>

                <p class="text-sm text-gray-500">Status:
                    <span
                        class="font-semibold {{ $lastProgression->status_approve === 'approved' ? 'text-green-600' : ($lastProgression->status_approve === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                        {{ ucfirst($lastProgression->status_approve) }}
                    </span>
                </p>

                @if($lastProgression->note)
                <p class="text-sm text-gray-500">Note: {{ $lastProgression->note }}</p>
                @endif

                @if($lastProgression->status_approve === 'waiting')
                <form id="reviewForm-{{ $lastProgression->id }}" method="POST"
                    action="{{ route('task-progression.review', $lastProgression->id) }}">
                    @csrf
                    <input type="hidden" name="status_approve" id="statusApprove-{{ $lastProgression->id }}">
                    <input type="hidden" name="note" id="noteHidden-{{ $lastProgression->id }}">
                </form>

                <div class="flex gap-2 mt-4">
                    <button type="button" onclick="openModalWithStatus('approved', {{ $lastProgression->id }})"
                        class="flex-1 py-3 bg-[#1F4482] text-white rounded-lg rounded-md hover:bg-[#18346a] transition-colors">Approve</button>
                    @if($lastProgression->progression_ke !== $task->revisions + 3)
                        <button type="button" onclick="openModalWithStatus('rejected', {{ $lastProgression->id }})"
                        class="flex-1 py-3 bg-red-600 rounded text-white hover:bg-red-700 transition-colors">Reject</button>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>
</div>


@if (auth()->user()->role == 'client')
<div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6 my-5">
    <div class="flex items-center justify-between">
        <!-- Card Profile (Kiri) -->
        <div class="flex items-center space-x-4">
            <!-- Avatar -->
            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                <img src="{{ asset('storage/' . ($task->worker->user->profile_image ?? 'default.jpg')) }}"
                    alt="" class="w-full h-full object-cover rounded-full">
            </div>

            <!-- User Info -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800">{{$task->worker->user->nama_lengkap}}
                </h3>
                <p class="text-gray-600">{{$task->worker->user->role}}</p>
            </div>
        </div>

        <!-- Action Buttons (Di sebelah kanan Profil) -->
        <div class="flex flex-col gap-2">
            <!-- Laporkan Button -->
            <button onclick="openModalLapor()"
                class="w-32 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                Laporkan
            </button>

            <!-- Chat Button -->
            <a href="{{ url('chat/' . $task->worker->user->id) }}"
                class="bg-[#1F4482] text-white px-4 py-2 rounded-md hover:bg-[#18346a] flex items-center justify-center">
                Chat
            </a>
        </div>
    </div>
</div>
@elseif (auth()->user()->role == 'worker')
<div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6 my-5">
    <div class="flex items-center justify-between">
        <!-- Card Profile (Kiri) -->
        <div class="flex items-center space-x-4">
            <!-- Avatar -->
            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                <img src="{{ asset('storage/' . ($task->client->profile_image ?? 'default.jpg')) }}" alt=""
                    class="w-full h-full object-cover rounded-full">
            </div>

            <!-- User Info -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800">{{$task->client->nama_lengkap}}</h3>
                <p class="text-gray-600">{{$task->client->role}}</p>
            </div>
        </div>

        <!-- Action Buttons (Di sebelah kanan Profil) -->
        <div class="flex flex-col gap-2">
            <!-- Laporkan Button -->
            <button onclick="openModalLapor()"
                class="w-32 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                Laporkan
            </button>

            <!-- Chat Button -->
            <a href="{{ url('chat/' . $task->client->id) }}"
                class="bg-[#1F4482] text-white px-4 py-2 rounded-md hover:bg-[#18346a] flex items-center justify-center">
                Chat
            </a>

        </div>
    </div>
</div>
@elseif (auth()->user()->role == 'admin')
<div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6 my-5">
    <div class="flex items-center justify-between">
        <!-- Card Profile (Kiri) -->
        <div class="flex items-center space-x-4">
            <!-- Avatar -->
            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                <img src="{{ asset('storage/' . ($task->worker->user->profile_image ?? 'default.jpg')) }}"
                    alt="" class="w-full h-full object-cover rounded-full">
            </div>

            <!-- User Info -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800">{{$task->worker->user->nama_lengkap}}
                </h3>
                <p class="text-gray-600">{{$task->worker->user->role}}</p>
            </div>
        </div>

        <!-- Action Buttons (Di sebelah kanan Profil) -->
        <div class="flex flex-col gap-2">
            <!-- Laporkan Button -->
            <button
                class="w-32 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                Laporkan
            </button>

            <!-- Chat Button -->
            <a href="{{ url('chat/' . $task->worker->user->id) }}"
                class="bg-[#1F4482] text-white px-4 py-2 rounded-md hover:bg-[#18346a] flex items-center justify-center">
                Chat
            </a>
        </div>
    </div>
</div>
<div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6 my-5">
    <div class="flex items-center justify-between">
        <!-- Card Profile (Kiri) -->
        <div class="flex items-center space-x-4">
            <!-- Avatar -->
            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                <img src="{{ asset('storage/' . ($task->client->profile_image ?? 'default.jpg')) }}" alt=""
                    class="w-full h-full object-cover rounded-full">
            </div>

            <!-- User Info -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800">{{$task->client->nama_lengkap}}</h3>
                <p class="text-gray-600">{{$task->client->role}}</p>
            </div>
        </div>

        <!-- Action Buttons (Di sebelah kanan Profil) -->
        <div class="flex flex-col gap-2">
            <!-- Laporkan Button -->
            <button onclick="openModalLapor()"
                class="w-32 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                Laporkan
            </button>

            <!-- Chat Button -->
            <a href="{{ url('chat/' . $task->client->id) }}"
                class="bg-[#1F4482] text-white px-4 py-2 rounded-md hover:bg-[#18346a] flex items-center justify-center">
                Chat
            </a>
        </div>
    </div>
</div>
@endif



<!-- TABEL SECTION -->
<div class="bg-white p-6 rounded-xl shadow-md border mb-5">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas</h1>
        <div class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </span>
            <input type="text" id="table-search-users"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 text-sm"
                placeholder="Cari berdasarkan nama...">
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-[#1F4482] text-white text-left">
                <tr>
                    <th class="px-6 py-3 font-medium tracking-wider">Nama</th>
                    <th class="px-6 py-3 font-medium tracking-wider">Aksi</th>
                    <th class="px-6 py-3 font-medium tracking-wider">Note / File</th>
                    <th class="px-6 py-3 font-medium tracking-wider">Progres</th>
                    <th class="px-6 py-3 font-medium tracking-wider">Waktu</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($progressions as $progress)
                @if($progress->action_by_worker)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-6 py-3 flex items-center gap-3">
                        <img src="{{ asset('storage/' . ($progress->worker->profile_image ?? 'default.jpg')) }}"
                            alt="Profile" class="w-8 h-8 rounded-full object-cover">
                        <span class="font-medium">{{ $progress->worker->nama_lengkap ?? 'Unknown' }}</span>
                    </td>
                    <td class="px-6 py-3">
                        <span
                            class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">
                            {{ $progress->status_upload }}
                        </span>
                    </td>
                    <td class="px-6 py-3">
                        <a href="{{ asset('storage/' . $progress->path_file) }}" target="_blank"
                            title="{{ basename($progress->path_file) }}"
                            class="text-blue-600 hover:underline truncate inline-block max-w-[150px]">
                            📄 {{ \Illuminate\Support\Str::limit(basename($progress->path_file), 25) }}
                        </a>
                    </td>
                    <td class="px-6 py-3 font-medium">{{ $progress->progression_ke }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $progress->date_upload->format('d M Y H:i') }}</td>
                </tr>
                @endif

                @if($progress->action_by_client)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-6 py-3 flex items-center gap-3">
                        <img src="{{ asset('storage/' . ($progress->client->profile_image ?? 'default.jpg')) }}"
                            alt="Profile" class="w-8 h-8 rounded-full object-cover">
                        <span class="font-medium">{{ $progress->client->nama_lengkap ?? 'Unknown' }}</span>
                    </td>
                    <td class="px-6 py-3">
                        <span
                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                                                                                                                            @if($progress->status_approve === 'approved') bg-green-100 text-green-700
                                                                                                                                            @elseif($progress->status_approve === 'rejected') bg-red-100 text-red-700
                                                                                                                                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($progress->status_approve) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-800">{{ $progress->note ?? '-' }}</td>
                    <td class="px-6 py-3 font-medium">{{ $progress->progression_ke }}</td>
                    <td class="px-6 py-3 text-gray-600">
                        {{ $progress->date_approve?->format('d M Y H:i') ?? '-' }}
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<div id="detail" class="tab-content p-4 rounded h-full hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Section -->
        <div class="lg:col-span-2 flex flex-col h-full">
            <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $task->title }}</h1>
                    </div>
                </div>

                <!-- User Info and Budget Info -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $task->user->profile_image ? asset('storage/' . $task->user->profile_image) : asset('assets/images/avatar.png') }}"
                            alt="User" class="w-16 h-16 sm:w-24 sm:h-24 rounded-full object-cover">

                        <div>
                            <p class="font-semibold text-gray-800 flex items-center gap-1 mb-2">
                                {{ $task->user->nama_lengkap }}
                                <span class="text-[#1F4482]">&#10004;</span>
                            </p>
                            <p class="text-xs flex items-center gap-1">
                                <i class="fa-solid fa-pen text-gray-500"></i>
                                <span class="text-gray-500">Task diposting</span>
                                <span class="text-gray-600 font-semibold">
                                    {{ \Carbon\Carbon::parse($task->created_at)->translatedFormat('d F Y') }}
                                </span>
                            </p>
                        </div>

                    </div>

                    <div class="text-left mr-6">
                        <p class="text-sm font-medium text-gray-500">Budget</p>
                        <p class="text-lg font-semibold text-gray-800">IDR
                            {{ number_format($task->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- About Task -->
                <div class="space-y-6 flex-1">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Tentang Task</h2>
                        <div class="job-description text-sm text-gray-800 leading-relaxed">
                            {!! $task->description !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Kualifikasi</h2>
                        <div class="job-qualification text-sm text-gray-800 leading-relaxed">
                            {!! $task->qualification !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Aturan Task</h2>
                        <div class="rules text-sm text-gray-800 leading-relaxed">
                            {!! $task->provisions !!}
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Attachment Files</h2>
                        @if ($task->job_file)
                        <a href="{{ asset('storage/' . $task->job_file) }}" download
                            class="inline-block mt-2 px-4 py-2 bg-[#1F4482] text-white text-sm rounded-md hover:bg-[#18346a]">
                            Download File
                        </a>
                        @else
                        <p class="text-sm text-gray-500">No attachment available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div>
            <div class="bg-white p-6 rounded-xl shadow-sm border space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Task Detail</h2>

                <div>
                    <p class="text-gray-500">Masa Pengerjaan Task (Deadline)</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($task->start_date)->translatedFormat('d F Y') }} -
                        {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y') }}
                    </p>
                    <p class="font-semibold">
                        ({{ \Carbon\Carbon::parse($task->start_date)->diffInDays($task->deadline) }} Hari)
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Penutupan Lamaran</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($task->deadline_promotion)->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Permintaan Jatah Revisi</p>
                    <p class="font-semibold capitalize">{{ $task->revisions }} kali revisi</p>
                </div>

                <div>
                    <p class="text-gray-500 mb-2">Kategori Task</p>
                    <div>
                        @php
                        $categories = json_decode($task->kategory, true) ?? [];
                        @endphp
                        @foreach($categories as $category)
                        <span
                            class="inline-block bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">
                            {{ $category }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="chat" class="tab-content p-4 rounded h-full hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    </div>
</div>

</div>


<!-- Modal Review -->
<div id="ratingModal"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300">
    <div id="modalContent"
        class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 opacity-0 scale-95 transform transition-all duration-300 relative">
        <!-- Close Modal -->
        <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-600" onclick="closeModalRating()">
            <i class="bi bi-x-lg text-xl"></i>
        </button>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Beri Rating & Ulasan Untuk Worker Sebelum Menyelesaikan
        </h2>
        <form id="completeJobForm" action="{{ route('complite.job', $task->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('POST')

            <!-- Rating -->
            <div class="flex items-center gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <label>
                    <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                    <i class="bi bi-star text-3xl text-gray-400 hover:text-yellow-400 cursor-pointer"></i>
                    </label>
                    @endfor
            </div>

            <!-- Review -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ulasan</label>
                <textarea name="review" rows="4" class="w-full p-2 border rounded-lg mb-4"
                    placeholder="Tulis ulasanmu..."></textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Kirim & Selesaikan
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Form Submit-->
<div id="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Masukkan Catatan</h2>
        <textarea id="noteInput" rows="4" class="w-full p-2 border rounded-lg mb-4"
            placeholder="Masukkan catatan progres untuk Worker"></textarea>
        <div class="flex justify-end">
            <button id="submitNote"
                class="py-2 px-4 bg-[#1F4482] text-white rounded-lg rounded-md hover:bg-[#18346a] focus:outline-none focus:ring-2 focus:ring-blue-300">Kirim</button>
            <button id="closeModal" onclick="closeModalCatatan()"
                class="ml-2 py-2 px-4 py-2 px-4 bg-gray-500 text-white rounded-lg rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Batal</button>
        </div>
    </div>
</div>

<!-- Modal Laporkan -->
<div id="laporModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Ajukan Arbitrase</h2>
        <form id="laporForm" method="POST" action="{{ route('arbitrase.store') }}">
            @csrf
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <input type="hidden" name="client_id" value="{{ $task->client_id }}"> <!-- atau tarik dari relasi -->
            <input type="hidden" name="worker_id" value="{{ $task->worker->user_id }}"> <!-- atau tarik dari relasi -->

            <label for="reason" class="block mb-2 text-sm font-medium text-gray-700">Alasan Pelaporan</label>
            <textarea name="reason" rows="4" class="w-full p-2 border rounded-lg"
                placeholder="Masukkan alasan pelaporan untuk transaksi ini sebagai pertimbangan admin dalam review"
                required></textarea>

            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="py-2 px-4 bg-[#1F4482] text-white rounded-lg rounded-md hover:bg-[#18346a] focus:outline-none focus:ring-2 focus:ring-blue-300">Kirim</button>
                <button type="button" onclick="closeModalLapor()"
                    class="ml-2 py-2 px-4 py-2 px-4 bg-gray-500 text-white rounded-lg rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal
    function openModalLapor() {
        document.getElementById('laporModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModalLapor() {
        document.getElementById('laporModal').classList.add('hidden');
    }
</script>


<!-- buat quilbot -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Quill Editor Initialized");

        // 🔹 Konfigurasi toolbar Quill
        const toolbarOptions = [
            [{
                'header': [1, 2, false]
            }],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            ['bold', 'italic', 'underline'],
            ['link', 'image'],
            ['clean']
        ];

        // 🔹 Inisialisasi Quill Editor di halaman ini
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // Jika ingin memuat data yang sudah ada (misalnya dari database)
        const contentFromDB = "{!! $dataFromDB ?? '' !!}"; // Misalnya isi dari database
        quill.root.innerHTML = contentFromDB; // Menyisipkan HTML dari database
    });
</script>



<!-- script untuk modal review -->
<script>
    function openModal() {
        const modal = document.getElementById('ratingModal');
        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('opacity-0', 'scale-95');
            content.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeModalRating() {
        const modal = document.getElementById('ratingModal');
        const content = document.getElementById('modalContent');

        modal.classList.remove('opacity-100');
        content.classList.remove('opacity-100', 'scale-100');
        content.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // tunggu animasi selesai dulu (300ms)
    }

    function closeModalCatatan() {
        const modal = document.getElementById('modal');
        const content = document.getElementById('modalContent');

        modal.classList.remove('opacity-100');
        content.classList.remove('opacity-100', 'scale-100');
        content.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // tunggu animasi selesai dulu (300ms)
    }

    // Highlight stars saat pilih rating
    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const stars = document.querySelectorAll('#ratingModal i.bi-star');
            stars.forEach((star, index) => {
                if (index < this.value) {
                    star.classList.add('text-yellow-400');
                    star.classList.remove('text-gray-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-400');
                }
            });
        });
    });
</script>

<script>
    function openModalWithStatus(status, id) {
        approvalStatus = status;
        currentProgressId = id;
        document.getElementById('modal').classList.remove('hidden');
        setTimeout(() => document.getElementById('modal').classList.remove('opacity-0'), 10);
    }

    document.getElementById('submitNote').addEventListener('click', () => {
        document.getElementById('statusApprove-' + currentProgressId).value = approvalStatus;
        document.getElementById('noteHidden-' + currentProgressId).value = document.getElementById('noteInput').value;
        document.getElementById('reviewForm-' + currentProgressId).submit();
    });
</script>


<script>
    // Display filename when selected
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name-display');
        const selectedFileName = document.getElementById('selected-file-name');

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileNameDisplay.classList.remove('hidden');
                    selectedFileName.textContent = this.files[0].name;
                } else {
                    fileNameDisplay.classList.add('hidden');
                }
            });
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');

                // Sembunyikan semua tab
                tabContents.forEach(content => content.classList.add('hidden'));

                // Tampilkan tab yang sesuai
                document.getElementById(tabId).classList.remove('hidden');

                // Update gaya tombol
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-[#1F4482]', 'text-white');
                    btn.classList.add('text-gray-600');
                });
                this.classList.remove('text-gray-600');
                this.classList.add('bg-[#1F4482]', 'text-white');
            });
        });
    });
</script>


@include('General.footer')
<script>
    // ✅ SweetAlert for Success Message
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Arbitrase Berhasil Dikirim!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#1F4482',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = window.location.href;
    });
    @elseif(session('success-progression'))
    Swal.fire({
        icon: 'success',
        title: 'Progression Berhasil Diupload!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#1F4482',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = window.location.href;
    });
    @elseif(session('success-review'))
    Swal.fire({
        icon: 'success',
        title: 'Review Berhasil Dikirim!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#1F4482',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = window.location.href;
    });
    @endif
</script>