@foreach ($jobs as $job)
    @if($job->status == 'open')
        <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative" data-price="{{ $job->price }}">
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
                    $hasLists = preg_match('/<ol[^>]*>|<ul[^>]*>/i', $job->description);
                    $textBeforeLists = preg_split('/<ol[^>]*>|<ul[^>]*>/i', $job->description)[0];
                    $plainTextBeforeLists = strip_tags($textBeforeLists);
                    $previewText = $hasLists
                        ? Str::limit($plainTextBeforeLists, 10, '...')
                        : Str::limit(strip_tags($job->description), 150, '...');
                @endphp
                {{ $previewText }}
            </div>

            <!-- Bottom Row: Price + Button -->
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($job->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">Penutupan <span
                            class="font-semibold text-gray-500">{{ \Carbon\Carbon::parse($job->deadline_promotion)->translatedFormat('d F Y') }}
                        </span></p>
                </div>
                <a href="{{ route('jobs.show', $job->id) }}">
                    <button
                        class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                        Lihat Detail
                    </button>
                </a>
            </div>
        </div>
    @endif
@endforeach
