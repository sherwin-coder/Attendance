<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Attendance Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12 flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md text-center">
            <h3 class="text-lg font-semibold mb-4">Scan Your Student ID</h3>

            <!-- Camera Selector -->
            <div class="mb-3">
                <label for="camera-select" class="text-sm font-medium text-gray-700">Select Camera:</label>
                <select id="camera-select"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Loading cameras...</option>
                </select>
            </div>

            <!-- Scanner Frame -->
            <div id="scanner-box"
                class="relative mx-auto w-80 h-80 border-4 border-indigo-500 rounded-xl overflow-hidden transition-all duration-300">
                <div id="reader" class="absolute inset-0"></div>
                <div id="scan-line" class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-scan"></div>
            </div>

            <!-- OR Divider -->
            <div class="my-4 text-gray-500 text-sm font-medium flex items-center justify-center gap-2">
                <span class="block w-16 border-t border-gray-300"></span>
                OR
                <span class="block w-16 border-t border-gray-300"></span>
            </div>

            <!-- File Upload for ID Image
            <div class="mb-3">
                <label for="file-input" class="text-sm font-medium text-gray-700">Upload ID Image:</label>
                <input type="file" id="file-input" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:ring-indigo-500 focus:border-indigo-500" />
                <p class="text-sm text-gray-400 mt-1">Upload a clear image of your QR code (JPG, PNG)</p>

            </div> -->

            <!-- Status -->
            <div id="status" class="mt-5 text-gray-600 font-medium">
                <div class="flex items-center justify-center space-x-2">
                    <div id="loading-spinner"
                        class="hidden w-5 h-5 border-2 border-gray-300 border-t-indigo-500 rounded-full animate-spin">
                    </div>
                    <span id="status-text">Waiting for QR code...</span>
                </div>
            </div>

            <!-- Result Message -->
            <div id="result" class="mt-5 font-semibold text-lg"></div>
        </div>
    </div>

    {{-- QR Scanner Script --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

    <style>
        @keyframes scan {
            0% {
                top: 5%;
            }

            100% {
                top: 95%;
            }
        }

        .animate-scan {
            animation: scan 2s ease-in-out infinite alternate;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

            0%,
            100% {
                border-color: #6366f1;
            }

            50% {
                border-color: #22c55e;
            }
        }

        @keyframes flash-red {

            0%,
            100% {
                border-color: #6366f1;
            }

            50% {
                border-color: #ef4444;
            }
        }

        @keyframes flash-yellow {

            0%,
            100% {
                border-color: #6366f1;
            }

            50% {
                border-color: #facc15;
            }
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
    </style>

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

        function showStatus(message, color = "text-gray-600") {
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

                    // Restart scanner after delay
                    setTimeout(async () => {
                        resultBox.innerHTML = "";
                        showStatus("Ready for next scan.", "text-gray-600");
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
            fps: 10,
            qrbox: 250,
            aspectRatio: 1.0,
            videoConstraints: {
                facingMode: "environment",
                width: { ideal: 1920 },
                height: { ideal: 1080 },
                focusMode: "continuous",
                advanced: [
                    { focusMode: "continuous" },
                    { focusDistance: 0 },
                    { zoom: 2.0 }
                ]
            }
        };

        // Initialize camera list
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                cameraSelect.innerHTML = "";
                devices.forEach((device, index) => {
                    const option = document.createElement("option");
                    option.value = device.id;
                    option.text = device.label || `Camera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                // Start first camera by default
                currentCameraId = devices[0].id;
                startCamera(currentCameraId);

                // Change camera when selection changes
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
                showStatus("Camera ready. Aim at QR code.", "text-gray-600");
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

        // // ✅ File Upload with jsQR Fallback
        // fileInput.addEventListener("change", async (event) => {
        //     const file = event.target.files[0];
        //     if (!file) return;

        //     if (isProcessing) {
        //         showStatus("Please wait for the current process to finish...", "text-yellow-600");
        //         return;
        //     }

        //     isProcessing = true;
        //     spinner.classList.remove("hidden");
        //     showStatus("Analyzing image...", "text-indigo-600");
        //     resultBox.innerHTML = "";

        //     try {
        //         // Display preview
        //         const img = document.createElement("img");
        //         img.src = URL.createObjectURL(file);
        //         img.alt = "QR Preview";
        //         img.style.maxWidth = "200px";
        //         img.style.borderRadius = "0.5rem";
        //         img.style.marginTop = "10px";
        //         resultBox.appendChild(img);

        //         await new Promise((resolve) => (img.onload = resolve));

        //         let decodedText = null;

        //         // --- 1️⃣ Try Html5Qrcode decoding first ---
        //         try {
        //             decodedText = await reader.scanFile(file, true);
        //         } catch (err) {
        //             console.warn("Html5-Qrcode failed, using jsQR fallback...");
        //         }

        //         // --- 2️⃣ If it fails, try jsQR fallback ---
        //         if (!decodedText) {
        //             const canvas = document.createElement("canvas");
        //             const ctx = canvas.getContext("2d");
        //             canvas.width = img.naturalWidth;
        //             canvas.height = img.naturalHeight;
        //             ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

        //             // Get image data for jsQR
        //             const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        //             const code = jsQR(imageData.data, imageData.width, imageData.height, {
        //                 inversionAttempts: "attemptBoth",
        //             });

        //             if (code) {
        //                 decodedText = code.data;
        //             }
        //         }

        //         spinner.classList.add("hidden");

        //         if (decodedText) {
        //             flashBorder("success");
        //             showStatus("QR detected — processing...", "text-green-600");
        //             await processDecodedQRCode(decodedText);
        //         } else {
        //             flashBorder("error");
        //             showResult("❌ Unable to detect QR. Try another image.", "text-red-600");
        //             showStatus("Ensure the QR is clear and centered.", "text-gray-600");
        //             isProcessing = false;
        //         }
        //     } catch (err) {
        //         spinner.classList.add("hidden");
        //         flashBorder("error");
        //         showResult("❌ Error reading image.", "text-red-600");
        //         console.error("File scan failed:", err);
        //         isProcessing = false;
        //     }
        // });

    </script>
</x-app-layout>