@include('General.header')


<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="grid grid-cols-1 min-h-screen">
            <div class="p-4 rounded h-full">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col md:flex-row items-center justify-center p-4 gap-4">
                            <!-- Step 1 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step1'] == 'approved') bg-green-500 
                                    @elseif($steps['step1'] == 'rejected') bg-red-500 
                                    @else bg-blue-500 @endif">
                                    <span class="text-lg">
                                        @if($steps['step1'] == 'approved') ✅ 
                                        @elseif($steps['step1'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step1'] == 'approved') text-green-500 
                                    @elseif($steps['step1'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">One</p>
                            </div>

                            <!-- Connector -->
                            <div class="h-10 w-1 md:h-1 md:w-12 
                                @if($steps['step1'] == 'approved') bg-green-500 
                                @elseif($steps['step1'] == 'rejected') bg-red-500 
                                @else bg-blue-500 @endif"></div>

                            <!-- Step 2 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step2'] == 'approved') bg-green-500 
                                    @elseif($steps['step2'] == 'rejected') bg-red-500 
                                    @else bg-blue-500 @endif">
                                    <span class="text-lg">
                                        @if($steps['step2'] == 'approved') ✅ 
                                        @elseif($steps['step2'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step2'] == 'approved') text-green-500 
                                    @elseif($steps['step2'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">Two</p>
                            </div>

                            <!-- Connector -->
                            <div class="h-10 w-1 md:h-1 md:w-12 
                                @if($steps['step2'] == 'approved') bg-green-500 
                                @elseif($steps['step2'] == 'rejected') bg-red-500 
                                @else bg-gray-300 @endif"></div>

                            <!-- Step 3 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step3'] == 'approved') bg-green-500 
                                    @elseif($steps['step3'] == 'rejected') bg-red-500 
                                    @else bg-gray-300 @endif">
                                    <span class="text-lg">
                                        @if($steps['step3'] == 'approved') ✅ 
                                        @elseif($steps['step3'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step3'] == 'approved') text-green-500 
                                    @elseif($steps['step3'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">Three</p>
                            </div>

                            <!-- Connector -->
                            <div class="h-10 w-1 md:h-1 md:w-12 
                                @if($steps['step3'] == 'approved') bg-green-500 
                                @elseif($steps['step3'] == 'rejected') bg-red-500 
                                @else bg-gray-300 @endif"></div>

                            <!-- Step 4 -->
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-10 h-10 text-white rounded-full flex items-center justify-center 
                                    @if($steps['step4'] == 'approved') bg-green-500 
                                    @elseif($steps['step4'] == 'rejected') bg-red-500 
                                    @else bg-gray-300 @endif">
                                    <span class="text-lg">
                                        @if($steps['step4'] == 'approved') ✅ 
                                        @elseif($steps['step4'] == 'rejected') ❌ 
                                        @else ⭕ @endif
                                    </span>
                                </div>
                                <p class="mt-2 md:mt-0 md:ml-3 text-lg font-semibold 
                                    @if($steps['step4'] == 'approved') text-green-500 
                                    @elseif($steps['step4'] == 'rejected') text-red-500 
                                    @else text-gray-500 @endif">Complete</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card Section: selalu di bawah -->
                    <div class="flex flex-col md:grid md:grid-cols-4 gap-4 p-4"> <!-- Ini kalau mau satu aja buttonnya <div class="flex flex-col gap-4 p-4">-->
                        <!-- Card untuk Worker -->
                        @if(auth()->user()->role == 'worker')
                            @for($step = 1; $step <= 4; $step++)
                                @php
                                    $current = $progressionsByStep[$step] ?? null;
                                    $prev = $progressionsByStep[$step - 1] ?? null;

                                    // Default rules for step 1–3
                                    $canSubmit = !$current && (
                                        $step == 1 ||
                                        ($step > 1 && $step <= 3 && $prev && $prev->status_approve === 'approved')
                                    );

                                    // Special rules for step 4 (revisi)
                                    $third = $progressionsByStep[3] ?? null;
                                    $fourth = $progressionsByStep[4] ?? null;
                                    $taskRevisions = $third?->task?->revisions ?? 0;
                                    $taskRevisions = $taskRevisions - 1;
                                    if ($step == 4) {
                                        $canSubmit = !$fourth && $third && $third->status_approve === 'rejected' && $taskRevisions > 0;
                                    }
                                @endphp

                                @if($current)
                                    <!-- Sudah Submit: tampilkan informasi file dan status -->
                                    <div class="bg-white rounded-lg p-4 shadow w-full">
                                        @if($step > 3 && $current->status_approve === 'rejected' && $taskRevisions+1 <= $task->revisions)
                                            @if($taskRevisions != $task->revisions)
                                                <!-- Form Upload -->
                                                <h2 class="font-bold text-lg">Revisi Ke-{{ $taskRevisions }}</h2>
                                                <form action="{{ route('task-progression.store', $task->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="bg-white rounded-lg p-4 shadow w-full">
                                                        <h2 class="font-bold text-lg">Submit Revisi Ke-{{ $taskRevisions + 1 }}</h2>
                                                        <label for="file-upload-{{ $step }}" class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                                                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">📄</div>
                                                            <p class="text-gray-700 font-medium">Inputkan file Progress</p>
                                                        </label>
                                                        <input id="file-upload-{{ $step }}" type="file" name="file" class="hidden" required>
                                                        <p class="pt-5">Tanggal di submit: {{ now()->format('d-m-Y H:i') }}</p>
                                                        <button type="submit" class="mt-2 w-full py-3 bg-blue-500 rounded text-white">Submit</button>
                                                    </div>
                                                </form>
                                            @elseif($taskRevisions+1 == $task->revisions)
                                                <h2 class="font-bold text-lg">Revisi Ke-{{ $taskRevisions+1 }}</h2>
                                                <p class="text-gray-700 mb-2">
                                                    File:
                                                    <a href="{{ asset('storage/' . $current->path_file) }}"
                                                    class="text-blue-500 underline"
                                                    target="_blank">
                                                        {{ basename($current->path_file) }}
                                                    </a>
                                                </p>

                                                <!-- Status Upload -->
                                                <p class="text-gray-700">
                                                    Status Upload:
                                                    <span class="font-semibold {{ $current->status_upload === 'uploaded' ? 'text-green-600' : 'text-yellow-600' }}">
                                                        {{ ucfirst($current->status_upload) }}
                                                    </span>
                                                </p>
                                                <p class="text-gray-500 text-sm">Tanggal Upload: {{ $current->date_upload?->format('d M Y H:i') }}</p>

                                                <!-- Status Approve -->
                                                <p class="text-gray-700">
                                                    Status Approve:
                                                    <span class="font-semibold 
                                                        {{ $current->status_approve === 'approved' ? 'text-green-600' : 
                                                        ($current->status_approve === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                                        {{ ucfirst($current->status_approve) }}
                                                    </span>
                                                </p>
                                                <p class="text-gray-500 text-sm">Tanggal Approve: {{ $current->date_approve?->format('d M Y H:i') ?? '-' }}</p>
                                                <!-- Note -->
                                                <p class="text-gray-700">Note: <span class="font-medium">{{ $current->note ?? '-' }}</span></p>
                                                <p class="text-xs italic text-red-500 mt-1">
                                                    Ini adalah revisi dari Progression Ke-{{ $taskRevisions+1 }}.
                                                </p>
                                            @endif
                                        @else
                                            @if($step > 3)
                                                <h2 class="font-bold text-lg">Revisi Ke-{{ $taskRevisions }}</h2>
                                            @else
                                                <h2 class="font-bold text-lg">Progression Ke-{{ $step }}</h2>
                                            @endif
                                            <p class="text-gray-700 mb-2">
                                                File:
                                                <a href="{{ asset('storage/' . $current->path_file) }}"
                                                class="text-blue-500 underline"
                                                target="_blank">
                                                    {{ basename($current->path_file) }}
                                                </a>
                                            </p>

                                            <!-- Status Upload -->
                                            <p class="text-gray-700">
                                                Status Upload:
                                                <span class="font-semibold {{ $current->status_upload === 'uploaded' ? 'text-green-600' : 'text-yellow-600' }}">
                                                    {{ ucfirst($current->status_upload) }}
                                                </span>
                                            </p>
                                            <p class="text-gray-500 text-sm">Tanggal Upload: {{ $current->date_upload?->format('d M Y H:i') }}</p>

                                            <!-- Status Approve -->
                                            <p class="text-gray-700">
                                                Status Approve:
                                                <span class="font-semibold 
                                                    {{ $current->status_approve === 'approved' ? 'text-green-600' : 
                                                    ($current->status_approve === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                                    {{ ucfirst($current->status_approve) }}
                                                </span>
                                            </p>
                                            <p class="text-gray-500 text-sm">Tanggal Approve: {{ $current->date_approve?->format('d M Y H:i') ?? '-' }}</p>
                                            <!-- Note -->
                                            <p class="text-gray-700">Note: <span class="font-medium">{{ $current->note ?? '-' }}</span></p>
                                        @endif
                                        
                                    </div>
                                    
                                @elseif($canSubmit)
                                    <!-- Form Upload -->
                                    <form action="{{ route('task-progression.store', $task->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="bg-white rounded-lg p-4 shadow w-full">
                                            <h2 class="font-bold text-lg">Submit Progression Ke-{{ $step }}</h2>
                                            <label for="file-upload-{{ $step }}" class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">📄</div>
                                                <p class="text-gray-700 font-medium">Inputkan file Progress</p>
                                            </label>
                                            <input id="file-upload-{{ $step }}" type="file" name="file" class="hidden" required>
                                            <p class="pt-5">Tanggal di submit: {{ now()->format('d-m-Y H:i') }}</p>
                                            <button type="submit" class="mt-2 w-full py-3 bg-blue-500 rounded text-white">Submit</button>
                                        </div>
                                    </form>
                                @endif
                            @endfor
                        @endif

                        <!-- Card untuk Client -->
                        @if(auth()->user()->role == 'client')
                            @php
                                $revisions = $progressions->filter(fn($p) => $p->progression_ke > 3);
                                $grouped = $progressions->where('progression_ke', '<=', 3);
                            @endphp

                            {{-- Progression Ke-1 sampai Ke-3 --}}
                            @foreach($grouped as $progress)
                                <div class="bg-white rounded-lg p-4 shadow w-full">
                                    <h2 class="font-bold text-lg">Review Progression Ke-{{ $progress->progression_ke }}</h2>
                                    <a href="{{ asset('storage/' . $progress->path_file) }}" target="_blank"
                                    class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                                        <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">📄</div>
                                        <p class="text-gray-700 font-medium">{{ basename($progress->path_file) }}</p>
                                    </a>
                                    <p class="pt-5 text-sm text-gray-500">Tanggal Submit: {{ $progress->date_upload?->format('d M Y H:i') ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">Status Approve:
                                        <span class="font-semibold {{ $progress->status_approve === 'approved' ? 'text-green-600' : ($progress->status_approve === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                            {{ ucfirst($progress->status_approve) }}
                                        </span>
                                    </p>
                                    <p class="text-sm text-gray-500">Note: {{ $progress->note ?? '-' }}</p>
                                    @if($progress->date_approve)
                                        <p class="text-sm text-gray-500">Tanggal Approve: {{ $progress->date_approve->format('d M Y H:i') }}</p>
                                    @endif
                                    @if($progress->status_approve === 'waiting')
                                        <form id="reviewForm-{{ $progress->id }}" method="POST" action="{{ route('task-progression.review', $progress->id) }}">
                                            @csrf
                                            <input type="hidden" name="status_approve" id="statusApprove-{{ $progress->id }}">
                                            <input type="hidden" name="note" id="noteHidden-{{ $progress->id }}">
                                        </form>
                                        <button type="button" onclick="openModalWithStatus('approved', {{ $progress->id }})" class="w-full py-3 bg-blue-500 rounded text-white mt-2">Approve</button>
                                        <button type="button" onclick="openModalWithStatus('rejected', {{ $progress->id }})" class="w-full py-3 bg-red-500 rounded text-white mt-2">Reject</button>
                                    @endif
                                </div>
                            @endforeach

                            {{-- Revisi dari Progression Ke-3 --}}
                            @if($revisions->count())
                                <div class="bg-white rounded-lg p-4 shadow w-full">
                                    <h2 class="font-bold text-lg">Review Revisi dari Progression Ke-3</h2>
                                    @foreach($revisions as $rev)
                                        <div class="border-t pt-4 mt-4">
                                            <a href="{{ asset('storage/' . $rev->path_file) }}" target="_blank"
                                            class="group cursor-pointer bg-white rounded-lg p-4 shadow w-full flex items-center justify-start gap-4 transition-all duration-300 hover:bg-gray-100">
                                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">📄</div>
                                                <p class="text-gray-700 font-medium">{{ basename($rev->path_file) }}</p>
                                            </a>
                                            <p class="pt-2 text-sm text-gray-500">Tanggal Submit: {{ $rev->date_upload?->format('d M Y H:i') ?? '-' }}</p>
                                            <p class="text-sm text-gray-500">Status Approve:
                                                <span class="font-semibold {{ $rev->status_approve === 'approved' ? 'text-green-600' : ($rev->status_approve === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                                    {{ ucfirst($rev->status_approve) }}
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-500">Note: {{ $rev->note ?? '-' }}</p>
                                            @if($rev->date_approve)
                                                <p class="text-sm text-gray-500">Tanggal Approve: {{ $rev->date_approve->format('d M Y H:i') }}</p>
                                            @endif
                                            @if($rev->status_approve === 'waiting')
                                                <form id="reviewForm-{{ $rev->id }}" method="POST" action="{{ route('task-progression.review', $rev->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status_approve" id="statusApprove-{{ $rev->id }}">
                                                    <input type="hidden" name="note" id="noteHidden-{{ $rev->id }}">
                                                </form>
                                                <button type="button" onclick="openModalWithStatus('approved', {{ $rev->id }})" class="w-full py-3 bg-blue-500 rounded text-white mt-2">Approve</button>
                                                <button type="button" onclick="openModalWithStatus('rejected', {{ $rev->id }})" class="w-full py-3 bg-red-500 rounded text-white mt-2">Reject</button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    <h1 class="text-xl font-semibold text-gray-700 mt-6">Deskripsi</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <p class="text-gray-600 mt-1">{{$task->description}}</p>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">Ketentuan</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <p class="text-gray-600 mt-1">{{$task->provisions}}</p>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">File Terkait tugas</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    <div class="flex items-center justify-between">
                        <!-- Card Profile (Kiri) -->
                        <div class="flex items-center space-x-4">
                            <!-- Avatar -->
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                <img src="https://via.placeholder.com/150" alt="" class="w-full h-full object-cover rounded-full">
                            </div>

                            <!-- User Info -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">John Doe</h3>
                                <p class="text-gray-600">Frontend Developer</p>
                            </div>
                        </div>

                        <!-- Action Buttons (Di sebelah kanan Profil) -->
                        <div class="flex flex-col gap-2">
                            <!-- Laporkan Button -->
                            <button class="w-32 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Laporkan
                            </button>

                            <!-- Chat Button -->
                            <button class="w-32 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                Chat
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md mb-5">
                    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
                        <h1 class="text-2xl font-semibold text-gray-700 mt-6">Log Aktivitas</h1>
                        <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search for users">
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-black bg-white">
                            <thead class="text-xs uppercase bg-gray-100 text-black border-b border-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-1/3">Name</th>
                                    <th scope="col" class="px-6 py-3 w-2/3">Note</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($progressionsByStep as $progress)
                                    <tr class="border-b border-gray-300 hover:bg-gray-100">
                                        <th scope="row" class="flex items-center px-2 py-4 whitespace-nowrap w-1/3">
                                            <img class="w-10 h-10 ps-6 rounded-full" 
                                                src="{{ asset('storage/' . ($progress->user->profile_image ?? 'default.jpg')) }}" 
                                                alt="profile">
                                            <div class="px-6">
                                                <div class="text-base font-semibold">{{ $progress->task->user->name ?? 'Unknown User' }}</div>
                                                <div class="font-normal text-gray-600">{{ $progress->task->user->email ?? '-' }}</div>
                                            </div>  
                                        </th>
                                        <td class="px-6 py-3 w-1/3">
                                            {{ $progress->note ?? 'Tidak ada catatan' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Form Submit-->
<div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden opacity-0 transition-opacity duration-500 ease-in-out">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-xl font-semibold mb-4">Enter Note</h2>
    <textarea id="noteInput" class="w-full p-2 border rounded mb-4" placeholder="Write your note here..."></textarea>
    <div class="flex justify-end">
      <button id="submitNote" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
      <button id="closeModal" class="ml-2 bg-gray-500 text-white py-2 px-4 rounded">Close</button>
    </div>
  </div>
</div>


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




@include('General.footer')
