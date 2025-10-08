<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Attendance Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12 flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md text-center">
            <h3 class="text-lg font-semibold mb-4">Scan Your Student ID</h3>

            <!-- Scanner Frame -->
            <div id="scanner-box" class="relative mx-auto w-80 h-80 border-4 border-indigo-500 rounded-xl overflow-hidden transition-all duration-300">
                <div id="reader" class="absolute inset-0"></div>
                <div id="scan-line" class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-scan"></div>
            </div>

            <!-- Status -->
            <div id="status" class="mt-5 text-gray-600 font-medium">
                <div class="flex items-center justify-center space-x-2">
                    <div id="loading-spinner" class="hidden w-5 h-5 border-2 border-gray-300 border-t-indigo-500 rounded-full animate-spin"></div>
                    <span id="status-text">Waiting for QR code...</span>
                </div>
            </div>

            <!-- Result Message -->
            <div id="result" class="mt-5 font-semibold text-lg"></div>
        </div>
    </div>

    {{-- QR Scanner Script --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        /* Scanner animation line */
        @keyframes scan {
            0% { top: 5%; }
            100% { top: 95%; }
        }
        .animate-scan {
            animation: scan 2s ease-in-out infinite alternate;
        }

        /* Smooth fade-in for text */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }

        /* Improve video sharpness */
        #reader video {
            object-fit: cover;
            image-rendering: -webkit-optimize-contrast;
            filter: brightness(1.05) contrast(1.1);
        }

        /* Flash animations for visual feedback */
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
        .flash-success { animation: flash-green 1s ease; }
        .flash-error { animation: flash-red 1s ease; }
        .flash-warning { animation: flash-yellow 1s ease; }
    </style>

    <script>
        const reader = new Html5Qrcode("reader");
        const statusText = document.getElementById("status-text");
        const spinner = document.getElementById("loading-spinner");
        const resultBox = document.getElementById("result");
        const scannerBox = document.getElementById("scanner-box");
        let isProcessing = false; // Prevent multiple scans

        function showStatus(message, color = "text-gray-600") {
            statusText.textContent = message;
            statusText.className = `${color} font-medium fade-in`;
        }

        function showResult(message, color) {
            resultBox.innerHTML = `<span class="${color} fade-in">${message}</span>`;
        }

        function flashBorder(type) {
            scannerBox.classList.remove("flash-success", "flash-error", "flash-warning");
            void scannerBox.offsetWidth; // Force reflow for reanimation
            if (type === "success") scannerBox.classList.add("flash-success");
            else if (type === "error") scannerBox.classList.add("flash-error");
            else if (type === "warning") scannerBox.classList.add("flash-warning");
        }

        async function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            await reader.pause();
            showStatus("QR detected — capturing frame...", "text-indigo-600");
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
            .then(data => {
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
                    showStatus("Ready for next scan.", "text-gray-600");
                    resultBox.innerHTML = "";
                    await reader.resume();
                    isProcessing = false;
                }, 3500);
            })
            .catch(async (err) => {
                spinner.classList.add("hidden");
                flashBorder("error");
                showResult("❌ Network error. Please try again.", "text-red-600");
                console.error(err);
                setTimeout(async () => {
                    await reader.resume();
                    isProcessing = false;
                }, 3500);
            });
        }

        function onScanError(errorMessage) {
            // silent scan errors ignored
        }

        const config = {
            fps: 15,
            qrbox: 250,
            aspectRatio: 1.0,
            videoConstraints: {
                facingMode: "environment",
                focusMode: "continuous",
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                reader.start(
                    { deviceId: { exact: devices[0].id } },
                    config,
                    onScanSuccess,
                    onScanError
                );
            } else {
                showResult("⚠️ No camera found.", "text-red-600");
            }
        }).catch(err => {
            console.error("Camera initialization failed", err);
            showResult("⚠️ Unable to access camera.", "text-red-600");
        });
    </script>
</x-app-layout>
