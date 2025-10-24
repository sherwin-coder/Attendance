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
    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.4s;
        }

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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
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

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-3px);
            }
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
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Bounce animation for close button */
        @keyframes bounce-gentle {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
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

        /* Responsive scanner sizing */
        .scanner-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            max-width: 100%;
        }

        @media (min-width: 640px) {
            .scanner-box {
                max-width: 24rem;
            }
        }

        @media (min-width: 768px) {
            .scanner-box {
                max-width: 20rem;
            }
        }

        @media (min-width: 1024px) {
            .scanner-box {
                max-width: 20rem;
            }
        }

        /* Responsive text sizing */
        .responsive-text {
            font-size: clamp(1rem, 4vw, 1.5rem);
        }

        .responsive-subtext {
            font-size: clamp(0.875rem, 3vw, 1rem);
        }

        /* Optimized Modal form transitions - FIXED */
        .auth-form {
            transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
            opacity: 1;
            transform: translateX(0);
        }

        .auth-form.hidden {
            display: none !important;
        }

        .auth-form:not(.active) {
            opacity: 0;
            transform: translateX(10px);
            pointer-events: none;
        }

        .auth-form.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
        }

        /* Tab navigation */
        .auth-tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }

        .auth-tab {
            flex: 1;
            padding: 0.75rem 1rem;
            text-align: center;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .auth-tab:hover {
            color: #4f46e5;
            background-color: #f8fafc;
        }

        .auth-tab.active {
            color: #4f46e5;
            border-bottom-color: #4f46e5;
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
                        <a href="{{ url('/admin_dashboard') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-white bg-gray-100 hover:bg-indigo-600 rounded-lg transition duration-200 flex items-center space-x-1 btn-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <button id="login-modal-btn"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-white bg-gray-100 hover:bg-indigo-600 rounded-lg transition duration-200 flex items-center space-x-1 btn-hover float-animation">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Login</span>
                        </button>
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Authentication Modal -->
    <div id="auth-modal" class="modal-overlay">
        <div
            class="modal-content absolute top-1/2 left-1/2 w-full max-w-md bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Modal Header -->
            <div class="shimmer-bg px-6 py-4 relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <h3 id="auth-modal-title" class="text-xl font-bold text-white">Login to Dashboard</h3>
                    <button id="close-modal" class="text-white hover:text-indigo-200 transition-colors bounce-hover">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Authentication Forms -->
            <div class="px-6 py-6">
                <!-- Tab Navigation -->
                <div class="auth-tabs">
                    <div class="auth-tab active" data-tab="login">Login</div>
                    <div class="auth-tab" data-tab="register">Register</div>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="login-form" class="auth-form active">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4 form-group">
                        <label for="login-email" class="block text-sm font-medium text-gray-700 mb-2">Email
                            Address</label>
                        <input id="login-email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('email') border-red-500 @enderror"
                            placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6 form-group">
                        <label for="login-password"
                            class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="login-password" type="password" name="password" required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('password') border-red-500 @enderror"
                            placeholder="Enter your password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6 flex items-center justify-between form-group">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors cursor-pointer">
                            <span
                                class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Remember
                                me</span>
                        </label>

                        <button type="button" id="show-forgot-password"
                            class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">
                            Forgot your password?
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors btn-hover form-group"
                        id="login-submit">
                        <span class="flex items-center justify-center">
                            <svg id="login-spinner" class="hidden w-5 h-5 mr-2 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Sign In
                        </span>
                    </button>
                </form>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" id="register-form" class="auth-form">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4 form-group">
                        <label for="register-name" class="block text-sm font-medium text-gray-700 mb-2">Full
                            Name</label>
                        <input id="register-name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('name') border-red-500 @enderror"
                            placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4 form-group">
                        <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">Email
                            Address</label>
                        <input id="register-email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('email') border-red-500 @enderror"
                            placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4 form-group">
                        <label for="register-password"
                            class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="register-password" type="password" name="password" required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('password') border-red-500 @enderror"
                            placeholder="Create a password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6 form-group">
                        <label for="register-password-confirmation"
                            class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input id="register-password-confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus"
                            placeholder="Confirm your password">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors btn-hover form-group"
                        id="register-submit">
                        <span class="flex items-center justify-center">
                            <svg id="register-spinner" class="hidden w-5 h-5 mr-2 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Create Account
                        </span>
                    </button>
                </form>

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" id="forgot-password-form" class="auth-form">
                    @csrf

                    <div class="mb-6 form-group">
                        <p class="text-sm text-gray-600 mb-4">
                            Enter your email address and we'll send you a link to reset your password.
                        </p>

                        <label for="forgot-email" class="block text-sm font-medium text-gray-700 mb-2">Email
                            Address</label>
                        <input id="forgot-email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors input-focus @error('email') border-red-500 @enderror"
                            placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-3 form-group">
                        <button type="button" id="back-to-login"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 px-4 rounded-xl font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors btn-hover">
                            Back to Login
                        </button>
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors btn-hover"
                            id="forgot-submit">
                            <span class="flex items-center justify-center">
                                <svg id="forgot-spinner" class="hidden w-5 h-5 mr-2 animate-spin" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Send Reset Link
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 form-group">
                <p id="auth-footer-text" class="text-sm text-gray-600 text-center">
                    Don't have an account?
                    <button type="button" id="switch-to-register"
                        class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">
                        Create one here
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-8 px-4">
        <div class="bg-white/95 backdrop-blur-sm p-4 sm:p-6 md:p-8 rounded-2xl card-shadow w-full max-w-md mx-auto">
            <!-- Scanner Header -->
            <div class="text-center mb-4 sm:mb-6">
                <div
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-indigo-600"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 responsive-text">Scan Your Student ID</h2>
                <p class="text-gray-500 mt-1 sm:mt-2 text-sm sm:text-base responsive-subtext">Position QR code within
                    the frame</p>
            </div>

            <!-- Camera Selector -->
            <div class="mb-4 sm:mb-6">
                <label for="camera-select" class="block text-sm font-medium text-gray-700 mb-2">Select Camera:</label>
                <div class="relative">
                    <select id="camera-select"
                        class="w-full py-2 sm:py-3 px-3 sm:px-4 pr-8 sm:pr-10 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white input-focus text-sm sm:text-base">
                        <option value="">Loading cameras...</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Subject Selector -->
            <div class="mb-4 sm:mb-6">
                <label for="subject-select" class="block text-sm font-medium text-gray-700 mb-2">Select Subject:</label>
                <div class="relative">
                    <select id="subject-select"
                        class="w-full py-2 sm:py-3 px-3 sm:px-4 pr-8 sm:pr-10 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white input-focus text-sm sm:text-base">
                        <option value="">Select a subject...</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->code }}">
                                {{ $subject->code }} - {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex flex-col items-center space-y-2">
                    <label for="qr-file-input"
                        class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                        📁 Upload QR Image
                    </label>
                    <input id="qr-file-input" type="file" accept="image/*" class="hidden">
                    <small class="text-gray-500 text-sm">You can upload a photo of a QR code if camera scanning isn’t
                        available.</small>
                </div>
            </div>

            <!-- Scanner Frame -->
            <div id="scanner-box"
                class="scanner-box relative mx-auto border-4 border-indigo-500 rounded-2xl overflow-hidden transition-all duration-300 scanner-glow">
                <div id="reader" class="absolute inset-0"></div>
                <div id="scan-line" class="absolute top-0 left-0 w-full h-1 bg-indigo-500 animate-scan"></div>

                <!-- Scanner corners -->
                <div
                    class="absolute top-0 left-0 w-4 h-4 sm:w-6 sm:h-6 border-t-4 border-l-4 border-indigo-500 rounded-tl-lg">
                </div>
                <div
                    class="absolute top-0 right-0 w-4 h-4 sm:w-6 sm:h-6 border-t-4 border-r-4 border-indigo-500 rounded-tr-lg">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-4 h-4 sm:w-6 sm:h-6 border-b-4 border-l-4 border-indigo-500 rounded-bl-lg">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-4 h-4 sm:w-6 sm:h-6 border-b-4 border-r-4 border-indigo-500 rounded-br-lg">
                </div>
            </div>

            <!-- Status -->
            <div id="status" class="mt-4 sm:mt-6 bg-gray-50 rounded-xl p-3 sm:p-4">
                <div class="flex items-center justify-center space-x-2 sm:space-x-3">
                    <div id="loading-spinner"
                        class="hidden w-4 h-4 sm:w-5 sm:h-5 border-2 border-gray-300 border-t-indigo-500 rounded-full animate-spin">
                    </div>
                    <span id="status-text" class="text-gray-700 font-medium text-sm sm:text-base">Waiting for QR
                        code...</span>
                </div>
            </div>

            <!-- Result Message -->
            <div id="result" class="mt-3 sm:mt-4 font-semibold text-sm sm:text-lg text-center"></div>
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
        let isProcessing = false;
        let currentCameraId = null;

        // Enhanced Modal functionality with animations
        const authModal = document.getElementById('auth-modal');
        const loginModalBtn = document.getElementById('login-modal-btn');
        const closeModalBtn = document.getElementById('close-modal');
        const authModalTitle = document.getElementById('auth-modal-title');
        const authFooterText = document.getElementById('auth-footer-text');

        // Form elements
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const forgotPasswordForm = document.getElementById('forgot-password-form');

        // Tab elements
        const authTabs = document.querySelectorAll('.auth-tab');
        const authForms = document.querySelectorAll('.auth-form');

        // Navigation buttons
        const switchToRegister = document.getElementById('switch-to-register');
        const showForgotPassword = document.getElementById('show-forgot-password');
        const backToLogin = document.getElementById('back-to-login');

        function openAuthModal(initialTab = 'login') {
            authModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            switchAuthTab(initialTab);

            // Reset form animations
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach(group => {
                group.style.animation = 'none';
                setTimeout(() => {
                    group.style.animation = '';
                }, 10);
            });
        }

        function closeAuthModal() {
            authModal.classList.add('closing');
            setTimeout(() => {
                authModal.classList.remove('active', 'closing');
                document.body.style.overflow = 'auto';
                // Reset to login form when closing
                switchAuthTab('login');
            }, 200);
        }

        // OPTIMIZED: Faster tab switching without lag
        function switchAuthTab(tabName) {
            // Update tabs immediately
            authTabs.forEach(tab => {
                tab.classList.toggle('active', tab.dataset.tab === tabName);
            });

            // Update forms - much faster approach
            authForms.forEach(form => {
                const isActive = form.id === `${tabName}-form`;
                form.classList.toggle('active', isActive);
                form.classList.toggle('hidden', !isActive);
            });

            // Update modal title and footer immediately
            updateModalContent(tabName);

            // Re-attach event listeners immediately
            attachDynamicEventListeners();
        }

        function updateModalContent(tabName) {
            switch (tabName) {
                case 'login':
                    authModalTitle.textContent = 'Login to Dashboard';
                    authFooterText.innerHTML = `Don't have an account? <button type="button" id="switch-to-register" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">Create one here</button>`;
                    break;
                case 'register':
                    authModalTitle.textContent = 'Create Account';
                    authFooterText.innerHTML = `Already have an account? <button type="button" id="switch-to-login" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">Sign in here</button>`;
                    break;
                case 'forgot-password':
                    authModalTitle.textContent = 'Reset Password';
                    authFooterText.innerHTML = `Remember your password? <button type="button" id="switch-to-login-from-forgot" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors hover:underline">Back to login</button>`;
                    break;
            }
        }

        function attachDynamicEventListeners() {
            // Re-attach event listeners for dynamically created buttons
            const switchToRegisterBtn = document.getElementById('switch-to-register');
            const switchToLoginBtn = document.getElementById('switch-to-login');
            const switchToLoginFromForgotBtn = document.getElementById('switch-to-login-from-forgot');

            if (switchToRegisterBtn) {
                switchToRegisterBtn.onclick = () => switchAuthTab('register');
            }
            if (switchToLoginBtn) {
                switchToLoginBtn.onclick = () => switchAuthTab('login');
            }
            if (switchToLoginFromForgotBtn) {
                switchToLoginFromForgotBtn.onclick = () => switchAuthTab('login');
            }
        }

        // Event Listeners
        loginModalBtn.addEventListener('click', () => openAuthModal('login'));
        closeModalBtn.addEventListener('click', closeAuthModal);

        // Tab navigation
        authTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                switchAuthTab(tab.dataset.tab);
            });
        });

        // Form navigation
        switchToRegister.addEventListener('click', () => switchAuthTab('register'));
        showForgotPassword.addEventListener('click', () => switchAuthTab('forgot-password'));
        backToLogin.addEventListener('click', () => switchAuthTab('login'));

        // Close modal when clicking outside
        authModal.addEventListener('click', (e) => {
            if (e.target === authModal) {
                closeAuthModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && authModal.classList.contains('active')) {
                closeAuthModal();
            }
        });

        // Form submission handlers
        function handleFormSubmission(form, submitBtn, spinner) {
            form.addEventListener('submit', function (e) {
                spinner.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75');

                // In a real application, you would let the form submit naturally
                // This timeout is just for visual feedback
                setTimeout(() => {
                    spinner.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75');
                }, 2000);
            });
        }

        // Apply form submission handlers
        handleFormSubmission(loginForm, document.getElementById('login-submit'), document.getElementById('login-spinner'));
        handleFormSubmission(registerForm, document.getElementById('register-submit'), document.getElementById('register-spinner'));
        handleFormSubmission(forgotPasswordForm, document.getElementById('forgot-submit'), document.getElementById('forgot-spinner'));

        // Enhanced input interactions
        document.querySelectorAll('.input-focus').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.classList.add('transform', 'scale-105');
            });

            input.addEventListener('blur', function () {
                this.parentElement.classList.remove('transform', 'scale-105');
            });
        });

        // Scanner functions
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
            const selectedSubject = document.getElementById("subject-select").value;

            if (!selectedSubject) {
                flashBorder("warning");
                showResult("⚠️ Please select a subject first.", "text-yellow-600");
                showStatus("Select a subject to continue.", "text-yellow-700");
                isProcessing = false;
                await startCamera(currentCameraId);
                return;
            }

            fetch("{{ route('attendance.scan.post') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    studentno: decodedText,
                    subject_code: selectedSubject
                })
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

        function onScanError(errorMessage) {
            /* silent */
        }

        // Responsive QR box configuration
        function getQRBoxSize() {
            const scannerWidth = scannerBox.offsetWidth;
            const size = Math.min(scannerWidth * (window.innerWidth < 768 ? 0.8 : 0.7), 250);
            return { width: size, height: size };
        }

        const config = {
            fps: 60,
            qrbox: getQRBoxSize,
            aspectRatio: 1.0,
            videoConstraints: {
                facingMode: "environment",
                width: {
                    min: 640,
                    ideal: 1280,
                    max: 1920
                },
                height: {
                    min: 480,
                    ideal: 720,
                    max: 1080
                },
                focusMode: "continuous"
            }
        };

        // Update QR box size on window resize
        window.addEventListener('resize', function () {
            if (reader && reader.isScanning) {
                // The qrbox function will be called again automatically
                // when the scanner restarts
            }
        });

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
                    const selectedCameraId = e.target.value;
                    if (selectedCameraId && selectedCameraId !== currentCameraId) {
                        await startCamera(selectedCameraId);
                    }
                });

            } else {
                showResult("⚠️ No camera found.", "text-yellow-600");
            }
        }).catch(err => {
            console.error("Camera initialization failed", err);
            showResult("⚠️ Unable to access camera.", "text-yellow-600");
        });

        async function startCamera(deviceId) {
            try {
                // stop any existing session safely
                if (reader._isScanning) await reader.stop();

                await reader.start({ deviceId: { exact: deviceId } }, config, onScanSuccess, onScanError);
                showStatus("Camera ready. Aim at QR code.", "text-gray-700");
            } catch (err) {
                console.error("Error starting camera:", err);
                showResult("⚠️ Failed to start camera.", "text-yellow-600");
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

        // Initialize dynamic event listeners
        attachDynamicEventListeners();
    </script>
    <script>
        // 🧩 Image Upload QR Scanning
        const qrFileInput = document.getElementById("qr-file-input");

        qrFileInput.addEventListener("change", async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            showStatus("Processing uploaded image...", "text-indigo-600");
            spinner.classList.remove("hidden");
            flashBorder("warning");

            try {
                // 🧠 Stop camera temporarily to avoid “ongoing scan” conflict
                try { await reader.stop(); } catch (_) { }

                // ✅ Scan QR code from image (requires html5-qrcode@2.3.9+)
                const result = await reader.scanFileV2(file, true);

                if (result?.decodedText) {
                    await processDecodedQRCode(result.decodedText);
                } else {
                    flashBorder("error");
                    showResult("❌ Unable to scan QR from image.", "text-red-600");
                    showStatus("Invalid or unreadable image.", "text-red-700");
                }

            } catch (err) {
                console.error("Image scan failed:", err);
                flashBorder("error");
                showResult("❌ Failed to scan image.", "text-red-600");
                showStatus("Upload a clear image of a valid QR code.", "text-red-700");
            } finally {
                spinner.classList.add("hidden");
                // Restart camera after a short delay
                setTimeout(async () => {
                    try { await startCamera(currentCameraId); } catch (_) { }
                }, 2000);
            }

            // Reset file input so user can upload again
            qrFileInput.value = "";
        });
    </script>
</body>

</html>