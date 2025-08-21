<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === Logout Logic ===
        document.getElementById("logoutBtn").addEventListener("click", function() {
            Swal.fire({
                title: 'Kamu yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#1F4482',
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

<script>
    setInterval(() => {
        fetch('/check-session')
            .then(response => response.json())
            .then(data => {
                if (!data.valid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Kamu Terlogout Paksa!',
                        text: 'Akunmu sudah login di perangkat lain.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        window.location.href = "{{ route('login') }}";
                    });
                }
            });
    }, 10000); //set auto logout 10 sec
</script>


</body>

</html>