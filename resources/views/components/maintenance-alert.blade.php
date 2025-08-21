@if(config('app.maintenance_mode') && (!auth()->check() || auth()->user()->role !== 'admin'))
    <div class="bg-yellow-500 text-white p-4 text-center">
        ⚠️ Website sedang dalam pemeliharaan. Beberapa fitur mungkin tidak tersedia.
    </div>
@endif
