@include('General.header')


<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="grid grid-cols-1 min-h-screen">
            <div class="p-4 rounded h-full">
                <div class="flex justify-end space-x-4 mb-7">
                @php
                    use App\Models\TaskReview;

                    $user = auth()->user();

                    // Cek apakah role-nya worker dan task sudah selesai
                    $isWorker = $user->role === 'worker';
                    $isCompleted = $task->status === 'completed';

                    // Cek apakah task review untuk task ini dan user ini sudah ada
                    $hasReviewed = TaskReview::where('task_id', $task->id)
                                    ->where('user_id', $user->id)
                                    ->exists();
                @endphp

                @if($isWorker && $isCompleted && !$hasReviewed)
                    <button type="button" onclick="openModal()"
                        class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-300 ease-in-out transform hover:scale-105 mt-4">
                        Berikan Penilaian
                    </button>
                @endif


                </div>
                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    @if($task->status == 'arbitrase-completed')
                        <h1 class="text-xl font-semibold text-gray-700 mt-6">TASK STATUS</h1>
                        <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                        <div class="job-description text-gray-600 mt-1">TASK STATUS SELESAI DENGAN ARBITRASE</div>
                    @endif
                    <h1 class="text-xl font-semibold text-gray-700 mt-6">Deskripsi</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <div class="job-description text-gray-600 mt-1">{!!$task->description!!}</div>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">Ketentuan</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <div class="job-qualification text-gray-600 mt-1">{!!$task->qualification!!}</div>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">Rules</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <div class="rules text-gray-600 mt-1">{!!$task->provisions!!}</div>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">File Terkait tugas</>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    <div class="flex items-center justify-between">
                        <!-- Card Profile (Kiri) -->
                        <div class="flex items-center space-x-4">
                            <!-- Avatar -->
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                <img src="{{ asset('storage/' . ($task->client->profile_image ?? 'default.jpg')) }}" alt="" class="w-full h-full object-cover rounded-full">
                            </div>

                            <!-- User Info -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">{{$task->client->nama_lengkap}}</h3>
                                <p class="text-gray-600">{{$task->client->role}}</p>
                            </div>
                        </div>

                        <!-- Action Buttons (Di sebelah kanan Profil) -->
                        <div class="flex flex-col gap-2">
                            <!-- Cek Button -->
                            <button class="w-32 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                Cek Profile
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md my-5">
                    <div class="flex items-center justify-between">
                        <!-- Card Profile (Kiri) -->
                        <div class="flex items-center space-x-4">
                            <!-- Avatar -->
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                <img src="{{ asset('storage/' . ($task->worker->user->profile_image ?? 'default.jpg')) }}" alt="" class="w-full h-full object-cover rounded-full">
                            </div>

                            <!-- User Info -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">{{$task->worker->user->nama_lengkap}}</h3>
                                <p class="text-gray-600">{{$task->worker->user->role}}</p>
                            </div>
                        </div>

                        <!-- Action Buttons (Di sebelah kanan Profil) -->
                        <div class="flex flex-col gap-2">
                            <!-- Cek Button -->
                            <button class="w-32 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                Cek Profile
                            </button>
                        </div>
                    </div>
                </div>



                <!-- TABEL SECTION -->
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
                            <thead class="text-xs bg-gray-100 text-black border-b border-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-1/4">Nama</th>
                                    <th scope="col" class="px-6 py-3 w-1/7">Aksi</th>
                                    <th scope="col" class="px-6 py-3 w-1/3">Note atau file terkirim</th>
                                    <th scope="col" class="px-6 py-3 w-1/7">Progress</th>
                                    <th scope="col" class="px-6 py-3 w-1/6">Tanggal dan waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progressions as $progress)
                                    {{-- Worker submission --}}
                                    @if($progress->action_by_worker)
                                        <tr class="text-sm text-gray-700">
                                            <td class="py-2 px-4 border-b">
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ asset('storage/' . ($progress->worker->profile_image ?? 'default.jpg')) }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                                    <span>{{ $progress->worker->nama_lengkap ?? 'Unknown User' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-2 border-b">{{ $progress->status_upload }}</td>
                                            <td class="py-2 px-2 border-b">
                                                <a href="{{ asset('storage/' . $progress->path_file) }}" class="text-blue-500 underline" target="_blank">
                                                    {{ basename($progress->path_file) }}
                                                </a>
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $progress->progression_ke }}</td>
                                            <td class="py-2 px-4 border-b">{{ $progress->date_upload->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endif
                                    {{-- Client approval/rejection --}}
                                    @if($progress->action_by_client)
                                        <tr class="text-sm text-gray-700">
                                            <td class="py-2 px-4 border-b">
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ asset('storage/' . ($progress->client->profile_image ?? 'default.jpg')) }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                                    <span>{{ $progress->client->nama_lengkap ?? 'Unknown User' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-2 border-b">
                                                {{ ucfirst($progress->status_approve) }}
                                            </td>
                                            <td class="py-2 px-2 border-b">
                                                {{ $progress->note ?? '-' }}
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $progress->progression_ke }}</td>
                                            <td class="py-2 px-4 border-b">{{ $progress->date_approve?->format('d M Y H:i') ?? '-' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




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
        <form id="completeJobForm" action="{{ route('task-ulasan.store', $task->id) }}" method="POST" class="space-y-4">
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




<!-- buat quilbot -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Quill Editor Initialized");

        // 🔹 Konfigurasi toolbar Quill
        const toolbarOptions = [
            [{ 'header': [1, 2, false] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['bold', 'italic', 'underline'],
            ['link', 'image'],
            ['clean']
        ];

        // 🔹 Inisialisasi Quill Editor di halaman ini
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        // Jika ingin memuat data yang sudah ada (misalnya dari database)
        const contentFromDB = "{!! $dataFromDB ?? '' !!}"; // Misalnya isi dari database
        quill.root.innerHTML = contentFromDB; // Menyisipkan HTML dari database
    });
</script>

@include('General.footer')




<!-- rating modal -->
<script>
    function openModal() {
        const modal = document.getElementById('ratingModal');
        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('opacity-0', 'scale-95');
            content.classList.add('opacity-100', 'scale-100');
        }, 10); // tunggu sedikit supaya transisinya jalan
    }

    function closeModal() {
        const modal = document.getElementById('ratingModal');
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





<!-- Modal Form Submit
<div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden opacity-0 transition-opacity duration-500 ease-in-out">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-xl font-semibold mb-4">Enter Note</h2>
    <textarea id="noteInput" class="w-full p-2 border rounded mb-4" placeholder="Write your note here..."></textarea>
    <div class="flex justify-end">
      <button id="submitNote" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
      <button id="closeModal" class="ml-2 bg-gray-500 text-white py-2 px-4 rounded">Close</button>
    </div>
  </div>
</div> -->