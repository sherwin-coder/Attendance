<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Attendance Scanner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- QR Scanner Scripts --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

    <style>
        @keyframes scan {
            0% { top: 5%; }
            100% { top: 95%; }
        }

        .animate-scan {
            animation: scan 2s ease-in-out infinite alternate;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }

        #reader video {
            object-fit: cover;
            image-rendering: -webkit-optimize-contrast;
            filter: brightness(1.05) contrast(1.1);
        }

        @keyframes flash-green {
            0%, 100% { border-color: #6366f1; }
            50% { border-color: #22c55e; }
        }

        @keyframes flash-red {
            0%, 100% { border-color: #6366f1; }
            50% { border-color: #ef4444; }
        }

        @keyframes flash-yellow {
            0%, 100% { border-color: #6366f1; }
            50% { border-color: #facc15; }
        }

        .flash-success {
            animation: flash-green 1s ease;
        }

        .flash-error {
            animation: flash-red 1s ease;
        }

        .flash-warning {
            animation: flash-yellow 1s ease;
        }

        .gradient-bg {
            background: #ebf8ff;
        }

        .scanner-glow {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Enhanced Modal Animations */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
            backdrop-filter: blur(8px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-content {
            transform: translate(-50%, -50%) scale(0.7) rotateX(12deg);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
            animation: overlayFadeIn 0.3s ease-out;
        }

        .modal-overlay.active .modal-content {
            transform: translate(-50%, -50%) scale(1) rotateX(0);
            opacity: 1;
        }

        .modal-overlay.closing {
            opacity: 0;
            animation: overlayFadeOut 0.2s ease-in;
        }

        .modal-overlay.closing .modal-content {
            transform: translate(-50%, -50%) scale(0.8) rotateX(-8deg);
            opacity: 0;
        }

        @keyframes overlayFadeIn {
            from { 
                opacity: 0; 
                backdrop-filter: blur(0px);
            }
            to { 
                opacity: 1; 
                backdrop-filter: blur(8px);
            }
        }

        @keyframes overlayFadeOut {
            from { 
                opacity: 1; 
                backdrop-filter: blur(8px);
            }
            to { 
                opacity: 0; 
                backdrop-filter: blur(0px);
            }
        }

        /* Form element animations */
        .form-group {
            opacity: 0;
            transform: translateY(20px);
            animation: formSlideUp 0.6s ease forwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }

        @keyframes formSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button hover animations */
        .btn-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-hover:hover::before {
            left: 100%;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .btn-hover:active {
            transform: translateY(0);
        }

        /* Input focus animations */
        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px -3px rgba(99, 102, 241, 0.3);
        }

        /* Floating animation for login button */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Shimmer effect for modal header */
        .shimmer-bg {
            background: linear-gradient(90deg, #4f46e5, #6366f1, #4f46e5);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Bounce animation for close button */
        @keyframes bounce-gentle {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0, -8px, 0);
            }
            70% {
                transform: translate3d(0, -4px, 0);
            }
            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .bounce-hover:hover {
            animation: bounce-gentle 1s ease;
        }

        /* Success checkmark animation */
        @keyframes checkmark {
            0% {
                stroke-dashoffset: 50;
                opacity: 0;
                transform: scale(0.8);
            }
            50% {
                opacity: 1;
                transform: scale(1.1);
            }
            100% {
                stroke-dashoffset: 0;
                opacity: 1;
                transform: scale(1);
            }
        }

        .checkmark-animate {
            animation: checkmark 0.6s ease-in-out forwards;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-sm py-4 px-6 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between">
            <!-- Title -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/images/smart-icon.jpg') }}" alt="Scanner Icon" class="h-8 w-8 rounded-lg">
                <h1 class="text-2xl font-bold text-gray-800">
                    QR Attendance Scanner
                </h1>
            </div>

            <!-- Navigation -->
            @if (Route::has('login'))
            <nav class="mt-3 md:mt-0 flex flex-wrap gap-2 justify-center md:justify-end">
                @auth
                    <a
                        href="{{ url('/admin_dashboard') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-white bg-gray-100 hover:bg-indigo-600 rounded-lg transition duration-200 flex items-center space-x-1 btn-hover"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                @else
                    <button
                        id="login-modal-btn"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-white bg-gray-100 hover:bg-indigo-600 rounded-lg transition duration-200 flex items-center space-x-1 btn-hover float-animation"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Login</span>
                    </button>
                @endauth
            </nav>
            @endif
        </div>
    </header>

    <!-- Login Modal -->
    <div id="login-modal" class="modal-overlay">
        <div class="modal-content absolute top-1/2 left-1/2 w-full max-w-md bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Modal Header -->
            <div class="shimmer-bg px-6 py-4 relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <h3 class="text-xl font-bold text-white">Login to Dashboard</h3>
                    <button id="close-modal" class="text-white hover:text-indigo-200 transition-colors bounce-hover">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Laravel Login Form -->
            <div class="px-6 py-6">
                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4 form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('email') border-red-500 @enderror"
                            placeholder="Enter your email"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6 form-group">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('password') border-red-500 @enderror"
                            placeholder="Enter your password"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6 flex items-center justify-between form-group">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors cursor-pointer"
                            >
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors btn-hover form-group"
                        id="login-submit"
                    >
                        <span class="flex items-center justify-center">
                            <svg id="login-spinner" class="hidden w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sign in to Dashboard
                        </span>
                    </button>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 form-group">
                <p class="text-sm text-gray-600 text-center">
                    Don't have an account? 
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">
                            Create one here
                        </a>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-8 px-4">
        <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl card-shadow w-full max-w-md">
            <!-- Your existing scanner content remains the same -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Scan Your Student ID</h2>
                <p class="text-gray-500 mt-2">Position QR code within the frame</p>
            </div>

            <!-- Camera Selector -->
            <div class="mb-6">
                <label for="camera-select" class="block text-sm font-medium text-gray-700 mb-2">Select Camera:</label>
                <div class="relative">
                    <select id="camera-select"
                        class="w-full py-3 px-4 pr-10 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white input-focus">
                        <option value="">Loading cameras...</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Scanner Frame -->
            <div id="scanner-box"
                class="mt-2 relative mx-auto w-80 h-80 border-4 border-indigo-500 rounded-2xl overflow-hidden transition-all duration-300 scanner-glow">
                <div id="reader" class="absolute inset-0"></div>
                <div id="scan-line" class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-scan"></div>
                
                <!-- Scanner corners -->
                <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-indigo-500 rounded-tl-lg"></div>
                <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-indigo-500 rounded-tr-lg"></div>
                <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-indigo-500 rounded-bl-lg"></div>
                <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-indigo-500 rounded-br-lg"></div>
            </div>

            <!-- Status -->
            <div id="status" class="mt-6 bg-gray-50 rounded-xl p-4">
                <div class="flex items-center justify-center space-x-3">
                    <div id="loading-spinner"
                        class="hidden w-5 h-5 border-2 border-gray-300 border-t-indigo-500 rounded-full animate-spin"></div>
                    <span id="status-text" class="text-gray-700 font-medium">Waiting for QR code...</span>
                </div>
            </div>

            <!-- Result Message -->
            <div id="result" class="mt-4 font-semibold text-lg text-center"></div>

            <!-- OR Divider -->
            <!-- <div class="my-6 text-gray-500 text-sm font-medium flex items-center justify-center gap-3">
                <span class="block flex-1 border-t border-gray-300"></span>
                <span>OR</span>
                <span class="block flex-1 border-t border-gray-300"></span>
            </div> -->

            <!-- Manual Entry Option -->
            <!-- <div class="text-center">
                <button id="manual-entry-btn" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors btn-hover">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Enter Student ID Manually
                </button>
            </div> -->
        </div>
    </main>

    <!-- Scanner Script -->
    <script>
        const reader = new Html5Qrcode("reader");
        const cameraSelect = document.getElementById("camera-select");
        const statusText = document.getElementById("status-text");
        const spinner = document.getElementById("loading-spinner");
        const resultBox = document.getElementById("result");
        const scannerBox = document.getElementById("scanner-box");
        const fileInput = document.getElementById("file-input");
        let isProcessing = false;
        let currentCameraId = null;

        // Enhanced Modal functionality with animations
        const loginModal = document.getElementById('login-modal');
        const loginModalBtn = document.getElementById('login-modal-btn');
        const closeModalBtn = document.getElementById('close-modal');
        const loginForm = document.getElementById('login-form');
        const loginSubmit = document.getElementById('login-submit');
        const loginSpinner = document.getElementById('login-spinner');

        function openLoginModal() {
            loginModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Reset form animations
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach(group => {
                group.style.animation = 'none';
                setTimeout(() => {
                    group.style.animation = '';
                }, 10);
            });
        }

        function closeLoginModal() {
            loginModal.classList.add('closing');
            setTimeout(() => {
                loginModal.classList.remove('active', 'closing');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        loginModalBtn.addEventListener('click', openLoginModal);
        closeModalBtn.addEventListener('click', closeLoginModal);

        // Close modal when clicking outside
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                closeLoginModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && loginModal.classList.contains('active')) {
                closeLoginModal();
            }
        });

        // Form submission animation
        loginForm.addEventListener('submit', function(e) {
            loginSpinner.classList.remove('hidden');
            loginSubmit.disabled = true;
            loginSubmit.classList.add('opacity-75');
            
            // Simulate loading for demo (remove in production)
            setTimeout(() => {
                loginSpinner.classList.add('hidden');
                loginSubmit.disabled = false;
                loginSubmit.classList.remove('opacity-75');
            }, 2000);
        });

        // Enhanced input interactions
        document.querySelectorAll('.input-focus').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('transform', 'scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('transform', 'scale-105');
            });
        });

        // Your existing scanner functions remain the same...
        function showStatus(message, color = "text-gray-700") {
            statusText.textContent = message;
            statusText.className = `${color} font-medium fade-in`;
        }

        function showResult(message, color) {
            resultBox.innerHTML = `<span class="${color} fade-in">${message}</span>`;
        }

        function flashBorder(type) {
            scannerBox.classList.remove("flash-success", "flash-error", "flash-warning");
            void scannerBox.offsetWidth;
            if (type === "success") scannerBox.classList.add("flash-success");
            else if (type === "error") scannerBox.classList.add("flash-error");
            else if (type === "warning") scannerBox.classList.add("flash-warning");
        }

        async function processDecodedQRCode(decodedText) {
            showStatus("QR detected — processing...", "text-indigo-600");
            spinner.classList.remove("hidden");

            fetch("{{ route('attendance.scan.post') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ studentno: decodedText })
            })
                .then(response => response.json())
                .then(async (data) => {
                    spinner.classList.add("hidden");
                    if (data.status === 'success') {
                        flashBorder("success");
                        showResult(`✅ ${data.message}`, "text-green-600");
                        showStatus("Scan complete — attendance updated!", "text-green-700");
                    } else if (data.status === 'info') {
                        flashBorder("warning");
                        showResult(`⚠️ ${data.message}`, "text-yellow-600");
                        showStatus("Already logged for today.", "text-yellow-700");
                    } else {
                        flashBorder("error");
                        showResult(`❌ ${data.message}`, "text-red-600");
                        showStatus("Invalid QR code or student not found.", "text-red-700");
                    }

                    setTimeout(async () => {
                        resultBox.innerHTML = "";
                        showStatus("Ready for next scan.", "text-gray-700");
                        await startCamera(currentCameraId);
                        isProcessing = false;
                    }, 3500);
                })
                .catch(async (err) => {
                    spinner.classList.add("hidden");
                    flashBorder("error");
                    showResult("❌ Network error. Please try again.", "text-red-600");
                    console.error(err);
                    setTimeout(async () => {
                        await startCamera(currentCameraId);
                        isProcessing = false;
                    }, 3500);
                });
        }

        async function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            try {
                await reader.stop();
            } catch (err) {
                console.error("Error stopping scanner:", err);
            }

            await processDecodedQRCode(decodedText);
        }

        function onScanError(errorMessage) { /* silent */ }

        const config = {
            fps: 60,
            qrbox: 250,
            aspectRatio: 1.0,
            videoConstraints: {
                facingMode: "environment",
                width: { ideal: 1920 },
                height: { ideal: 1080 },
                focusMode: "continuous",
                advanced: [
                    { focusMode: "continuous" },
                    { focusDistance: 5 },
                    { zoom: 2.0 }
                ]
            }
        };

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                cameraSelect.innerHTML = "";
                devices.forEach((device, index) => {
                    const option = document.createElement("option");
                    option.value = device.id;
                    option.text = device.label || `Camera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                currentCameraId = devices[0].id;
                startCamera(currentCameraId);

                cameraSelect.addEventListener("change", async (e) => {
                    const newId = e.target.value;
                    if (!newId || newId === currentCameraId) return;
                    await switchCamera(newId);
                });
            } else {
                showResult("⚠️ No camera found. Please upload an image instead.", "text-yellow-600");
            }
        }).catch(err => {
            console.error("Camera initialization failed", err);
            showResult("⚠️ Unable to access camera. Please upload an image instead.", "text-yellow-600");
        });

        async function startCamera(deviceId) {
            try {
                await reader.start({ deviceId: { exact: deviceId } }, config, onScanSuccess, onScanError);
                showStatus("Camera ready. Aim at QR code.", "text-gray-700");
            } catch (err) {
                console.error("Error starting camera:", err);
                showResult("⚠️ Failed to start camera. Try uploading an image instead.", "text-yellow-600");
            }
        }

        async function switchCamera(deviceId) {
            showStatus("Switching camera...", "text-indigo-600");
            spinner.classList.remove("hidden");

            try {
                await reader.stop();
                currentCameraId = deviceId;
                await startCamera(deviceId);
            } catch (err) {
                console.error("Camera switch failed:", err);
                showResult("⚠️ Failed to switch camera.", "text-red-600");
            } finally {
                spinner.classList.add("hidden");
            }
        }

        // Manual entry functionality (placeholder)
        document.getElementById('manual-entry-btn').addEventListener('click', function() {
            const studentId = prompt("Please enter your Student ID:");
            if (studentId) {
                processDecodedQRCode(studentId);
            }
        });
    </script>
</body>
</html>