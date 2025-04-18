<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Penting untuk mobile -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 text-black px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-sm sm:max-w-md md:max-w-lg bg-white p-6 sm:p-8 rounded-lg shadow text-center">
        <h2 class="text-2xl sm:text-3xl font-semibold mb-3 text-gray-800">Verification Code</h2>
        <p class="mb-6 text-sm sm:text-base text-gray-600">
            Please type the verification code sent to <strong>{{ session('email') }}</strong>
        </p>

        <form method="POST" action="{{ route('forgot-password.verify-otp-check') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <div class="flex justify-between space-x-2 mb-6">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" name="otp[]" maxlength="1" pattern="[0-9]*"
                        class="otp-input w-10 h-12 sm:w-12 sm:h-12 text-center text-xl rounded border border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                @endfor
            </div>

            <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-600 text-white font-semibold py-2 rounded transition">
                VALIDATE
            </button>
        </form>

        <div class="mt-5 text-sm">
            <span id="resendText" class="text-gray-600">
                Resend in <span id="timer" class="font-semibold text-black">30</span> detik...
            </span>

            <form id="resendForm" method="POST" action="{{ route('forgot-password.resend-otp') }}" class="hidden inline">
                @csrf
                <button type="submit" class="text-blue-600 underline hover:text-blue-800">
                    Resend OTP
                </button>
            </form>
        </div>
    </div>

    <script>
        // Input OTP per kotak
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
        inputs[0].focus();

        // Countdown
        let timeLeft = 30;
        const timerEl = document.getElementById("timer");
        const resendText = document.getElementById("resendText");
        const resendForm = document.getElementById("resendForm");

        const countdown = setInterval(() => {
            timeLeft--;
            timerEl.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                resendText.style.display = "none";
                resendForm.classList.remove("hidden");
            }
        }, 1000);
        
        // Handle paste 6 digit sekaligus ke input pertama
        inputs[0].addEventListener('paste', function(e) {
            e.preventDefault();
            const data = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (/^\d{6}$/.test(data)) {
                for (let i = 0; i < 6; i++) {
                    inputs[i].value = data[i];
                }
                inputs[5].focus();
            }
        });
    </script>
</body>
</html>
