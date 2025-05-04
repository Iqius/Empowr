@include('General.header')

<div class="p-6 mt-16">
    <form id="job-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <div class="flex flex-col gap-6 mb-6">
                        <!-- Title -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Judul Task</label>
                            <input type="text" name="title"
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300 mb-4"
                                required>
                        </div>

                        <!-- About Task -->
                        <label class="text-sm font-medium text-gray-600 ">Tentang Task</label>
                        <div id="editor-about" class="bg-white mb-4" style="height: 200px;"></div>
                        <input type="hidden" name="description" id="description">

                        <label class="text-sm font-medium text-gray-600">Kualifikasi</label>
                        <div id="editor-qualification" class="bg-white mb-4" style="height: 200px;">
                        </div>
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

                    <!-- Task Period -->
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Tanggal Mulai Task</label>
                        <input type="date" name="start_date"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Target Selesai Task</label>
                        <input type="date" name="deadline"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Tanggal Penutupan Lamaran</label>
                        <input type="date" name="deadline_promotion"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Kategori Task</label>
                        <div>
                            <div class="col-span-2 ">
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
                                <select id="keahlian-select" name="kategoriWorker[]" multiple
                                    class="w-full p-2 border rounded">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ in_array($category, $selectedSkills) ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Permintaan Jumlah Revisi</label>
                        <input type="number" name="revisions" min="0"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Budget (IDR)</label>
                        <input type="number" name="price"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#1F4482] transition-all duration-300"
                            required>
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

        // 🔹 Inisialisasi Quill Editor untuk semua bidang
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

        // 🔹 Fungsi yang SANGAT diperbaiki untuk memastikan list terformat dengan benar
        function cleanContent(content) {
            // If content is empty, return empty string
            if (!content.trim()) return '';

            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = content;

            // Special handling for ordered lists to ensure they're preserved properly
            tempDiv.querySelectorAll('*').forEach(function (node) {
                // Pertahankan atribut penting untuk list
                if (node.tagName === 'OL' || node.tagName === 'UL') {
                    // Keep class attribute for list type but remove style
                    node.removeAttribute('style');
                }
                else if (node.tagName === 'LI') {
                    // For list items, keep necessary attributes but remove style
                    node.removeAttribute('style');
                }
                else {
                    // For non-list elements, remove both class and style
                    node.removeAttribute('class');
                    node.removeAttribute('style');
                }
            });

            return tempDiv.innerHTML.trim();
        }

        // 🔹 Tombol submit event handler
        document.querySelector('#submit-btn').addEventListener('click', function (event) {
            event.preventDefault(); // ✅ Mencegah submit otomatis sebelum data tersimpan

            console.log("Submit button clicked!");

            // 🔹 Ambil isi dari Quill dan simpan di input hidden
            document.querySelector('input[name="description"]').value = cleanContent(quillDescription.root.innerHTML);
            document.querySelector('input[name="qualification"]').value = cleanContent(quillQualification.root.innerHTML);
            document.querySelector('input[name="rules"]').value = cleanContent(quillRules.root.innerHTML);

            // 🔹 Debugging untuk memastikan data benar sebelum submit
            console.log('Description:', document.querySelector('input[name="description"]').value);
            console.log('Qualification:', document.querySelector('input[name="qualification"]').value);
            console.log('Rules:', document.querySelector('input[name="rules"]').value);

            // 🔹 Validasi apakah semua input tidak kosong
            if (
                document.querySelector('input[name="description"]').value.trim() &&
                document.querySelector('input[name="qualification"]').value.trim() &&
                document.querySelector('input[name="rules"]').value.trim()
            ) {
                console.log("Form is valid, submitting...");
                document.querySelector('#job-form').action = "{{ route('jobs.store') }}"; // ✅ Tentukan route
                document.querySelector('#job-form').submit(); // ✅ Submit form
            } else {
                alert('Please complete all required fields before submitting.');
                console.log("Form validation failed.");
            }
        });

        // 🔹 Disable paste menjadi plaintext (untuk mencegah stripping format)
        quillDescription.clipboard.addMatcher(Node.ELEMENT_NODE, function (node, delta) {
            return delta;
        });

        quillQualification.clipboard.addMatcher(Node.ELEMENT_NODE, function (node, delta) {
            return delta;
        });

        quillRules.clipboard.addMatcher(Node.ELEMENT_NODE, function (node, delta) {
            return delta;
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