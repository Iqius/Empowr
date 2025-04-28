@include('General.header')

<div class="p-6 mt-16">
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <div class="flex flex-col gap-6 mb-6">
                        <!-- Title -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Task Title</label>
                            <input type="text" name="title"
                                class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                required>
                        </div>

                        <!-- About Task -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">About Task</label>
                            <div id="editor-about" class="bg-white p-2 border rounded-md" style="height: 200px;"></div>
                            <input type="hidden" name="description">
                        </div>

                        <!-- Qualification -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Qualification</label>
                            <div id="editor-qualification" class="bg-white p-2 border rounded-md"
                                style="height: 150px;"></div>
                            <input type="hidden" name="qualification">
                        </div>

                        <!-- Rules -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Rules</label>
                            <div id="editor-rules" class="bg-white p-2 border rounded-md" style="height: 150px;"></div>
                            <input type="hidden" name="rules">
                        </div>

                        <!-- Upload -->
                        <div>
                            <label class="text-sm font-medium text-gray-600 mb-1 block">Attachment Files</label>
                            <input type="file" name="job_file"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div>
                <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Task Details</h2>

                    <!-- Task Period -->
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Start Date</label>
                        <input type="date" name="start_date"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Deadline</label>
                        <input type="date" name="deadline"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Task Closed (Deadline
                            Promotion)</label>
                        <input type="date" name="deadline_promotion"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Task Type</label>
                        <select name="taskType"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                            <option value="">Select Task Type</option>
                            <option value="Contract">Contract</option>
                            <option value="Project">Project</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Task Model</label>
                        <select name="taskModel"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                            <option value="">Select Task Model</option>
                            <option value="WFA">WFA</option>
                            <option value="WFO">WFO</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Category</label>
                        <select name="category"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                            <option value="">Select Category</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile Development">Mobile Development</option>
                            <option value="Game Development">Game Development</option>
                            <option value="Software Engineering">Software Engineering</option>
                            <option value="Frontend Development">Frontend Development</option>
                            <option value="Backend Development">Backend Development</option>
                            <option value="Full Stack Development">Full Stack Development</option>
                            <option value="DevOps">DevOps</option>
                            <option value="QA Testing">QA Testing</option>
                            <option value="Automation Testing">Automation Testing</option>
                            <option value="API Integration">API Integration</option>
                            <option value="WordPress Development">WordPress Development</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Machine Learning">Machine Learning</option>
                            <option value="AI Development">AI Development</option>
                            <option value="Data Engineering">Data Engineering</option>
                            <option value="Data Entry">Data Entry</option>
                            <option value="SEO">SEO</option>
                            <option value="Content Writing">Content Writing</option>
                            <option value="Technical Writing">Technical Writing</option>
                            <option value="Blog Writing">Blog Writing</option>
                            <option value="Copywriting">Copywriting</option>
                            <option value="Scriptwriting">Scriptwriting</option>
                            <option value="Proofreading">Proofreading</option>
                            <option value="Translation">Translation</option>
                            <option value="Transcription">Transcription</option>
                            <option value="Resume Writing">Resume Writing</option>
                            <option value="Ghostwriting">Ghostwriting</option>
                            <option value="Creative Writing">Creative Writing</option>
                            <option value="Social Media Management">Social Media Management</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="Email Marketing">Email Marketing</option>
                            <option value="Affiliate Marketing">Affiliate Marketing</option>
                            <option value="Influencer Marketing">Influencer Marketing</option>
                            <option value="Community Management">Community Management</option>
                            <option value="Search Engine Marketing">Search Engine Marketing</option>
                            <option value="Branding">Branding</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="UI/UX Design">UI/UX Design</option>
                            <option value="Logo Design">Logo Design</option>
                            <option value="Motion Graphics">Motion Graphics</option>
                            <option value="Illustration">Illustration</option>
                            <option value="Video Editing">Video Editing</option>
                            <option value="Video Production">Video Production</option>
                            <option value="Animation">Animation</option>
                            <option value="3D Modeling">3D Modeling</option>
                            <option value="Video Game Design">Video Game Design</option>
                            <option value="Audio Editing">Audio Editing</option>
                            <option value="Photography">Photography</option>
                            <option value="Photo Editing">Photo Editing</option>
                            <option value="Presentation Design">Presentation Design</option>
                            <option value="Project Management">Project Management</option>
                            <option value="Virtual Assistant">Virtual Assistant</option>
                            <option value="Customer Service">Customer Service</option>
                            <option value="Lead Generation">Lead Generation</option>
                            <option value="Market Research">Market Research</option>
                            <option value="Business Analysis">Business Analysis</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Event Planning">Event Planning</option>
                            <option value="Bookkeeping">Bookkeeping</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Tax Preparation">Tax Preparation</option>
                            <option value="Financial Analysis">Financial Analysis</option>
                            <option value="Legal Advice">Legal Advice</option>
                            <option value="Contract Drafting">Contract Drafting</option>
                            <option value="Startup Consulting">Startup Consulting</option>
                            <option value="Investment Research">Investment Research</option>
                            <option value="Real Estate Consulting">Real Estate Consulting</option>
                            <option value="Personal Assistant">Personal Assistant</option>
                            <option value="Clerical Work">Clerical Work</option>
                            <option value="Data Analysis">Data Analysis</option>
                            <option value="Business Coaching">Business Coaching</option>
                            <option value="Career Coaching">Career Coaching</option>
                            <option value="Life Coaching">Life Coaching</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Revisions</label>
                        <input type="number" name="revisions" min="0"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Location</label>
                        <input type="text" name="location"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">Budget (IDR)</label>
                        <input type="number" name="price"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Submit -->
        <div class="flex justify-end mt-6">
            <button type="submit"
                class="bg-[#1F4482] hover:bg-[#18346a] text-white text-sm sm:text-base font-semibold px-6 py-3 rounded-md shadow transition">
                Tambahkan
            </button>
        </div>
    </form>
</div>

<!-- Script Quill -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quillAbout = new Quill('#editor-about', { theme: 'snow' });
        var quillQualification = new Quill('#editor-qualification', { theme: 'snow' });
        var quillRules = new Quill('#editor-rules', { theme: 'snow' });

        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('description').value = quillAbout.root.innerHTML;
            document.getElementById('qualification').value = quillQualification.root.innerHTML;
            document.getElementById('rules').value = quillRules.root.innerHTML;
        });
    });
</script>

@include('General.footer')