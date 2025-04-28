<!-- JS FLOWBITE -->
<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // === Logout Logic ===
        document.getElementById("logoutBtn").addEventListener("click", function () {
            Swal.fire({
                title: 'Yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#d1d5db'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil logout',
                        showConfirmButton: false,
                        timer: 1500,
                        didClose: () => {
                            document.getElementById("logoutForm").submit();
                        }
                    });
                }
            });
        });

        // === Sidebar Toggle Logic ===
        const toggleButton = document.querySelector('[data-drawer-toggle="logo-sidebar"]');
        const sidebar = document.getElementById('logo-sidebar');
        const content = document.querySelector('.main-content');

        if (toggleButton && sidebar && content) {
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                content.classList.toggle('ml-64');
            });
        }
    });
    function toggleDropdown() {
        document.getElementById("dropdown-notif").classList.toggle("hidden");
    }
</script>

</body>

</html>