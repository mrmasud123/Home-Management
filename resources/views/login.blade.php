<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bachelor Meal — Sign in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,600;1,9..144,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>


    <div class="relative min-h-screen w-full flex items-center justify-center overflow-hidden bg-gradient-to-br from-[#FFF8EF] via-[#F6F9EE] to-[#FDECD8] dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 px-4 py-10 font-sans">

        <!-- Animated background blobs -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -left-20 w-80 h-80 rounded-full bg-[#9CC5A1]/40 blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-28 -right-16 w-96 h-96 rounded-full bg-[#F2A65A]/35 blur-3xl animate-pulse [animation-delay:1.5s]"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 rounded-full bg-[#E8674B]/25 blur-3xl animate-pulse [animation-delay:3s]"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">

            <!-- Animated bowl mark -->
            <div class="flex justify-center mb-3">
                <div class="relative flex items-center justify-center w-20 h-20">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-[#E8674B]/20 animate-ping"></span>
                    <span class="absolute inline-flex h-[88%] w-[88%] rounded-full bg-[#E8674B]/10 animate-pulse"></span>
                    <div class="relative z-10 flex items-center justify-center w-16 h-16 rounded-full bg-[#E8674B] shadow-lg shadow-[#E8674B]/30 animate-bounce [animation-duration:3s]">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 12C4 12 5 17 12 17C19 17 20 12 20 12" stroke="#FFF8EF" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M4 12H20" stroke="#FFF8EF" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M9 8C8.6 6.8 8.8 5.6 9.6 4.6" stroke="#F2A65A" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 8.2C11.6 6.6 11.9 5.2 12.9 4" stroke="#F2A65A" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M15 8C14.9 6.9 15.3 5.8 16.1 4.9" stroke="#F2A65A" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="text-center mb-6">
                <span class="text-[11px] font-semibold tracking-widest text-[#E8674B] uppercase">Bachelor Meal Management</span>
                <h1 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white/90">Welcome back</h1>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-gray-200/60 dark:shadow-none border border-gray-100 dark:border-gray-700 p-7 sm:p-8">

                <a href="{{route('auth.google.redirect')}}"
                   class="inline-flex items-center justify-center gap-2 w-full h-11 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/5 text-sm font-medium text-gray-700 dark:text-white/90 hover:border-[#E8674B] hover:bg-[#FFF6F1] dark:hover:bg-white/10 transition-colors mb-5">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.7511 10.1944C18.7511 9.47495 18.6915 8.94995 18.5626 8.40552H10.1797V11.6527H15.1003C15.0011 12.4597 14.4654 13.675 13.2749 14.4916L13.2582 14.6003L15.9087 16.6126L16.0924 16.6305C17.7788 15.1041 18.7511 12.8583 18.7511 10.1944Z" fill="#4285F4" />
                        <path d="M10.1788 18.75C12.5895 18.75 14.6133 17.9722 16.0915 16.6305L13.274 14.4916C12.5201 15.0068 11.5081 15.3666 10.1788 15.3666C7.81773 15.3666 5.81379 13.8402 5.09944 11.7305L4.99473 11.7392L2.23868 13.8295L2.20264 13.9277C3.67087 16.786 6.68674 18.75 10.1788 18.75Z" fill="#34A853" />
                        <path d="M5.10014 11.7305C4.91165 11.186 4.80257 10.6027 4.80257 9.99992C4.80257 9.3971 4.91165 8.81379 5.09022 8.26935L5.08523 8.1534L2.29464 6.02954L2.20333 6.0721C1.5982 7.25823 1.25098 8.5902 1.25098 9.99992C1.25098 11.4096 1.5982 12.7415 2.20333 13.9277L5.10014 11.7305Z" fill="#FBBC05" />
                        <path d="M10.1789 4.63331C11.8554 4.63331 12.9864 5.34303 13.6312 5.93612L16.1511 3.525C14.6035 2.11528 12.5895 1.25 10.1789 1.25C6.68676 1.25 3.67088 3.21387 2.20264 6.07218L5.08953 8.26943C5.81381 6.15972 7.81776 4.63331 10.1789 4.63331Z" fill="#EB4335" />
                    </svg>
                    Continue with Google
                </a>

                <div class="relative flex items-center justify-center mb-5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <span class="relative bg-white dark:bg-gray-800 px-3 text-xs uppercase tracking-wider text-gray-400">or continue with email</span>
                </div>

                <form action="#" method="post" id="loginForm">
                    @csrf
                    <div class="space-y-5">

                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email<span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" placeholder="you@kitchen.com"
                                   class="h-11 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent dark:bg-gray-900 px-4 text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 focus:outline-none focus:ring-3 focus:ring-[#E8674B]/15 focus:border-[#E8674B]" />
                        </div>

                        <button type="submit" class="w-full h-11 rounded-lg bg-[#E8674B] hover:bg-[#D65B3F] text-white text-sm font-semibold transition-colors">
                            Continue
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>


{{--@push('scripts')--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('app:ready', function () {

            window.$(function () {

                var form = $("#loginForm");

                form.on("submit", function (e) {
                    e.preventDefault();

                    let email = $("#email").val();

                    if (!email) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Field',
                            text: 'Please enter your email'
                        });
                        return;
                    }

                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr("method"),
                        data: form.serialize(),
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Signing in...',
                                text: 'Please wait',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                window.location.href = "/";
                            }, 1500);
                        },
                        error: function (xhr) {
                            let message = "Sign in failed";

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: message
                            });
                        }
                    });

                });

            });

        });
    </script>
{{--@endpush--}}

</body>
</html>
