@include('General.header')

<div class="p-6 mt-16">
    <form id="job-form" method="POST" enctype="multipart/form-data" action="{{ route('jobs.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <div class="flex flex-col gap-6 mb-6">
                        <!-- Title -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Judul Task</label>
                            <input type="text" name="title" id="title" placeholder="Masukkan judul task"
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300 mb-4">
                            <span class="error-message text-red-500 text-sm"></span>
                        </div>

                        <!-- About Task -->
                        <label class="text-sm font-medium text-gray-600 ">Tentang Task</label>
                        <div id="editor-about" class="bg-white mb-4" style="height: 200px;"></div>
                        <input type="hidden" name="description" id="description">

                        <label class="text-sm font-medium text-gray-600">Kualifikasi</label>
                        <div id="editor-qualification" class="bg-white mb-4" style="height: 200px;"></div>
                        <input type="hidden" name="qualification" id="qualification">

                        <label class="text-sm font-medium text-gray-600">Aturan Task</label>
                        <div id="editor-rules" class="bg-white p-2 mb-4" style="height: 200px;"></div>
                        <input type="hidden" name="rules" id="rules">

                        <!-- Upload -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Attachment Files</label>
                            <input type="file" name="job_file"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1F4482] hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div>
                <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Task Detail</h2>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Tanggal Mulai Task</label>
                        <input type="date" name="start_date" id="start_date"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300">
                        <span class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Target Selesai Task</label>
                        <input type="date" name="deadline" id="deadline"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300">
                        <span class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Tanggal Penutupan Lamaran</label>
                        <input type="date" name="deadline_promotion" id="deadline_promotion"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300">
                        <span class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Kategori Task</label>
                        <select id="keahlian-select" name="kategory" multiple class="w-full p-2 border rounded">
                            @php
                            $selectedSkills = json_decode(optional(Auth::user()->keahlian)->keahlian, true) ?? [];
                            $categories = [
                            "Web Development",
                            "Mobile Development",
                            "Game Development",
                            "Software Engineering",
                            "Frontend Development",
                            "Backend Development",
                            "Full Stack Development",
                            "DevOps",
                            "QA Testing",
                            "Automation Testing",
                            "API Integration",
                            "WordPress Development",
                            "Data Science",
                            "Machine Learning",
                            "AI Development",
                            "Data Engineering",
                            "Data Entry",
                            "SEO",
                            "Content Writing",
                            "Technical Writing",
                            "Blog Writing",
                            "Copywriting",
                            "Scriptwriting",
                            "Proofreading",
                            "Translation",
                            "Transcription",
                            "Resume Writing",
                            "Ghostwriting",
                            "Creative Writing",
                            "Social Media Management",
                            "Digital Marketing",
                            "Email Marketing",
                            "Affiliate Marketing",
                            "Influencer Marketing",
                            "Community Management",
                            "Search Engine Marketing",
                            "Branding",
                            "Graphic Design",
                            "UI/UX Design",
                            "Logo Design",
                            "Motion Graphics",
                            "Illustration",
                            "Video Editing",
                            "Video Production",
                            "Animation",
                            "3D Modeling",
                            "Video Game Design",
                            "Audio Editing",
                            "Photography",
                            "Photo Editing",
                            "Presentation Design",
                            "Project Management",
                            "Virtual Assistant",
                            "Customer Service",
                            "Lead Generation",
                            "Market Research",
                            "Business Analysis",
                            "Human Resources",
                            "Event Planning",
                            "Bookkeeping",
                            "Accounting",
                            "Tax Preparation",
                            "Financial Analysis",
                            "Legal Advice",
                            "Contract Drafting",
                            "Startup Consulting",
                            "Investment Research",
                            "Real Estate Consulting",
                            "Personal Assistant",
                            "Clerical Work",
                            "Data Analysis",
                            "Business Coaching",
                            "Career Coaching",
                            "Life Coaching",
                            "Consulting",
                            "Other"
                            ];
                            @endphp
                            @foreach ($categories as $kategory)
                            <option value="{{ $kategory }}" {{ in_array($kategory, $selectedSkills) ? 'selected' : '' }}>
                                {{ $kategory }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Permintaan Jumlah Revisi</label>
                        <input type="number" name="revisions" min="0" id="revisions"
                            placeholder="Masukkan maksimal jumlah revisi"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300">
                        <span class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Budget (IDR)</label>
                        <input type="text" name="price" id="price" placeholder="Masukkan harga task"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300">
                        <span class="error-message text-red-500 text-sm"></span>
                    </div>
                </div>

                <!-- Button Submit -->
                <div class="flex justify-center mt-6">
                    <button type="button" id="submit-btn"
                        class="w-full bg-[#1F4482] hover:bg-[#18346a] text-white text-sm sm:text-base font-semibold px-6 py-3 rounded-md shadow transition">
                        Tambahkan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script Quill -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi Quill Editor
        const toolbarOptions = [
            [{
                header: [1, 2, false]
            }],
            [{
                list: 'ordered'
            }, {
                list: 'bullet'
            }],
            ['bold', 'italic', 'underline'],
            ['link', 'image'],
            ['clean']
        ];
        const priceInput = document.getElementById('price');

        var quillDescription = new Quill('#editor-about', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });
        var quillQualification = new Quill('#editor-qualification', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });
        var quillRules = new Quill('#editor-rules', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // Fungsi untuk bersihkan konten Quill (hapus tag kosong dan whitespace)
        function cleanContent(content) {
            return content.replace(/<(.|\n)*?>/g, '').trim();
        }

        // Fungsi format angka dengan pemisah ribuan
        function formatNumberWithSeparator(value) {
            // Hilangkan semua selain angka dan titik (jika ingin mendukung decimal)
            let cleanValue = value.replace(/[^0-9.]/g, '');

            // Pisah integer dan decimal
            let parts = cleanValue.split('.');
            let integerPart = parts[0];
            let decimalPart = parts[1] || '';

            // Format integer dengan ribuan
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            return decimalPart.length > 0 ? integerPart + '.' + decimalPart : integerPart;
        }

        // Event saat mengetik di input price, agar format ribuan muncul
        priceInput.addEventListener('input', function(e) {
            let cursorPosition = this.selectionStart;
            let originalLength = this.value.length;

            this.value = formatNumberWithSeparator(this.value);

            // Sesuaikan posisi cursor agar tetap nyaman saat mengetik
            let newLength = this.value.length;
            cursorPosition += newLength - originalLength;
            this.setSelectionRange(cursorPosition, cursorPosition);
        });

        document.querySelector('#submit-btn').addEventListener('click', function(e) {
            e.preventDefault();

            // Ambil input hidden dari Quill
            document.querySelector('input[name="description"]').value = quillDescription.root.innerHTML.trim();
            document.querySelector('input[name="qualification"]').value = quillQualification.root.innerHTML.trim();
            document.querySelector('input[name="rules"]').value = quillRules.root.innerHTML.trim();

            // Ambil nilai semua input
            let fields = {
                title: document.getElementById('title'),
                description: document.querySelector('input[name="description"]'),
                qualification: document.querySelector('input[name="qualification"]'),
                rules: document.querySelector('input[name="rules"]'),
                start_date: document.getElementById('start_date'),
                deadline: document.getElementById('deadline'),
                deadline_promotion: document.getElementById('deadline_promotion'),
                kategoriWorker: document.getElementById('keahlian-select'),
                revisions: document.getElementById('revisions'),
                price: document.getElementById('price')
            };

            // Hapus semua error message dan class error sebelumnya
            Object.values(fields).forEach(field => {
                let errorSpan = field.parentElement.querySelector('.error-message');
                if (errorSpan) errorSpan.textContent = '';
                field.classList.remove('border-red-500');
            });

            // Fungsi cek konten Quill (untuk hidden input)
            function cleanContent(content) {
                return content.replace(/<(.|\n)*?>/g, '').trim();
            }

            // Validasi setiap field
            let errors = [];

            if (fields.title.value.trim() === '') {
                errors.push({
                    field: fields.title,
                    message: 'Judul Task harus diisi.'
                });
            }
            if (fields.start_date.value.trim() === '') {
                errors.push({
                    field: fields.start_date,
                    message: 'Tanggal Mulai Task harus diisi.'
                });
            }
            if (fields.deadline.value.trim() === '') {
                errors.push({
                    field: fields.deadline,
                    message: 'Target Selesai Task harus diisi.'
                });
            }
            if (fields.deadline_promotion.value.trim() === '') {
                errors.push({
                    field: fields.deadline_promotion,
                    message: 'Tanggal Penutupan Lamaran harus diisi.'
                });
            }
            let kategoriSelected = [...fields.kategoriWorker.options].filter(option => option.selected).map(option => option.value);
            if (kategoriSelected.length === 0) {
                errors.push({
                    field: fields.kategoriWorker,
                    message: 'Kategori Task harus dipilih.'
                });
            }
            if (fields.revisions.value.trim() === '') {
                errors.push({
                    field: fields.revisions,
                    message: 'Permintaan Jumlah Revisi harus diisi.'
                });
            }
            if (fields.price.value.trim() === '') {
                errors.push({
                    field: fields.price,
                    message: 'Budget Task harus diisi.'
                });
            }

            if (errors.length > 0) {
                // Tampilkan pesan error di masing-masing field
                errors.forEach(err => {
                    let errorSpan = err.field.parentElement.querySelector('.error-message');
                    if (errorSpan) errorSpan.textContent = err.message;
                    err.field.classList.add('border-red-500');
                });

                // Scroll ke error pertama agar user langsung melihatnya
                errors[0].field.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

                return false; // jangan submit
            }

            // Submit form jika validasi lolos
            fields.price.value = fields.price.value.replace(/,/g, '');
            document.getElementById('job-form').submit();
        });
    });
</script>


<script>
    new TomSelect('#keahlian-select', {
        plugins: ['remove_button'],
        placeholder: 'Pilih Kategori',
        persist: false,
        create: false,
        maxItems: null
    });
</script>

@include('General.footer')