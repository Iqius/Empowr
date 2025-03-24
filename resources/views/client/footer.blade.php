<!-- JS FLOWBITE -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
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
    });
</script>

</body>
</html>