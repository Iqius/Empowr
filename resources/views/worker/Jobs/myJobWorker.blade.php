@include('General.header')

<div class="p-4 sm:p-6 md:p-8  mt-16">
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <!-- Search Input -->
        <input type="text" placeholder="Cari Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">

        <!-- Status Dropdown -->
        <select class="p-2 border rounded w-full md:w-auto" id="statusFilter">
            <option disabled selected>Filter Status</option>
            <option value="belum">Belum Diterima</option>
            <option value="sedang">Sedang Dikerjakan</option>
            <option value="selesai">Selesai Dikerjakan</option>
        </select>

    </div>

    <!-- List Job yang Dilamar oleh Worker (berasal dari task_applications) -->
    <div class="grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full" id="jobContainer">

        @foreach ($taskApplied as $job)
        <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative"
            data-status="{{ $job->status }}">
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ $job->task->client->profile_image ? asset('storage/' . $job->task->client->profile_image) : asset('assets/images/avatar.png') }}"
                    alt="Client Profile" class="w-9 h-9 rounded-full object-cover">
                <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                    {{ $job->task->client->nama_lengkap ?? 'Unknown' }}
                    <span class="text-[#1F4482]">✔</span>
                </p>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 mb-1">
                {{ $job->task->title }}
            </h3>
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
                                $previewText = Str::limit($plainTextBeforeLists, 77, '...');
                                } else {
                                // If no lists, just use normal limit
                                $previewText = Str::limit(strip_tags($job->task->description), 150, '...');
                                }
                                @endphp
                                {{ $previewText }}
            </div>
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        Rp {{ number_format($job->bidPrice, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400 capitalize">
                        Status: <span class="text-gray-500 font-semibold">{{ $job->status }}</span>
                    </p>
                </div>
                @if ($job->status === 'in progress')
                <a href="{{ route('inProgress.jobs', $job->id) }}">
                    @else
                    <a href="{{ route('manage.worker', $job->task_id) }}">
                        @endif
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            Lihat Lamaran
                        </button>
                    </a>
            </div>
        </div>
        @endforeach

        @foreach ($task as $job)
        <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative"
            data-status="{{ $job->status }}">
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                    alt="Client Profile" class="w-9 h-9 rounded-full object-cover">
                <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                    {{ $job->user->nama_lengkap ?? 'Unknown' }}
                    <span class="text-[#1F4482]">✔</span>
                </p>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 mb-1">
                {{ $job->title }}
            </h3>
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
                                $previewText = Str::limit($plainTextBeforeLists, 77, '...');
                                } else {
                                // If no lists, just use normal limit
                                $previewText = Str::limit(strip_tags($job->description), 150, '...');
                                }
                                @endphp
                                {{ $previewText }}
            </div>
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        Rp {{ number_format($job->price, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400 capitalize">
                        Status: <span class="text-gray-500 font-semibold">{{ $job->status }}</span>
                    </p>
                </div>
                <a href="{{ route('inProgress.jobs', $job->id) }}">
                    <button
                        class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                        Lihat Progres
                    </button>
                </a>
            </div>
        </div>
        {{--@endif--}}
        @endforeach
    </div>
</div>

@include('General.footer')

<!-- Script: Filter -->
<script>
    function filterByStatus() {
        const selectedStatus = document.getElementById('statusFilter').value;
        const jobCards = document.querySelectorAll('#jobContainer > div');

        jobCards.forEach(card => {
            card.style.display = card.dataset.status === selectedStatus ? 'block' : 'none';
        });
    }
</script>