<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bachelor Flat - Meal Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="relative bg-[#FBF9F4] font-sans text-[#20291F] min-h-screen">

<!-- ===== Ambient meal-themed background (fixed, behind everything) ===== -->
<div class="fixed inset-0 z-0 overflow-hidden pointer-events-none" aria-hidden="true">

    {{-- bold brand-color wash --}}
    <div class="absolute -top-32 -left-24 w-[30rem] h-[30rem] rounded-full bg-[#9CC5A1]/60 blur-[90px]"></div>
    <div class="absolute top-1/3 -right-28 w-[28rem] h-[28rem] rounded-full bg-[#F2A65A]/50 blur-[95px]"></div>
    <div class="absolute bottom-0 left-1/4 w-[26rem] h-[26rem] rounded-full bg-[#123328]/30 blur-[100px]"></div>
    <div class="absolute top-[55%] right-[15%] w-[20rem] h-[20rem] rounded-full bg-[#E8674B]/30 blur-[90px]"></div>

    {{-- visible dot-grid texture --}}
    <div class="absolute inset-0"
         style="background-image: radial-gradient(#20291F40 1.5px, transparent 1.5px); background-size: 22px 22px;"></div>

    {{-- scattered meal / kitchen line-icons, clearly visible, purely decorative --}}
    <i class="fas fa-bowl-food absolute top-[6%] left-[8%] text-[110px] text-[#123328]/[0.18] -rotate-12"></i>
    <i class="fas fa-utensils absolute top-[18%] right-[10%] text-[90px] text-[#E8674B]/[0.22] rotate-6"></i>
    <i class="fas fa-mug-hot absolute top-[42%] left-[4%] text-[80px] text-[#1B4536]/[0.20] rotate-3"></i>
    <i class="fas fa-wheat-awn absolute bottom-[30%] right-[6%] text-[100px] text-[#F2A65A]/[0.28] -rotate-6"></i>
    <i class="fas fa-carrot absolute bottom-[12%] left-[14%] text-[70px] text-[#E8674B]/[0.20] rotate-12"></i>
    <i class="fas fa-kitchen-set absolute bottom-[6%] right-[22%] text-[90px] text-[#123328]/[0.18] rotate-6"></i>
    <i class="fas fa-pepper-hot absolute top-[65%] left-[42%] text-[64px] text-[#9CC5A1]/[0.30] -rotate-12"></i>
    <i class="fas fa-cart-shopping absolute top-[8%] left-[48%] text-[74px] text-[#1B4536]/[0.18] rotate-6"></i>
    <i class="fas fa-lemon absolute top-[30%] left-[25%] text-[56px] text-[#F2A65A]/[0.25] rotate-12"></i>
    <i class="fas fa-fish absolute bottom-[40%] right-[35%] text-[60px] text-[#1B4536]/[0.16] -rotate-6"></i>
</div>

<div class="relative z-10 container mx-auto px-4 mt-6 max-w-6xl">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#123328] via-[#1B4536] to-[#0B241C] text-[#FFF8EF] px-6 sm:px-10 py-8 shadow-xl shadow-black/10">

        <!-- decorative blurred accents -->
        <div class="pointer-events-none absolute -top-16 -left-10 w-64 h-64 rounded-full bg-[#9CC5A1]/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -right-10 w-72 h-72 rounded-full bg-[#F2A65A]/20 blur-3xl"></div>

        <!-- top row: brand + user -->
        <div class="relative z-10 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-11 h-11 rounded-full bg-[#E8674B]">
                    <i class="fas fa-home text-[#FFF8EF]"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold leading-tight">Bachelor Flat</h1>
                    <p class="text-xs sm:text-sm text-[#FFF8EF]/70">Meal & Bazar Management System</p>
                </div>
            </div>

            @auth
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 bg-white/10 rounded-full pl-1.5 pr-4 py-1.5">
                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?background=E8674B&color=fff&name='.urlencode(auth()->user()->name) }}"
                             alt="{{ auth()->user()->name }}"
                             class="w-8 h-8 rounded-full object-cover border border-white/20">
                        <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                    </div>

                    <form method="POST" action="{{route('auth.logout')}}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 text-sm font-medium bg-white/10 hover:bg-[#E8674B] px-4 py-2 rounded-full transition-colors">
                            <i class="fas fa-arrow-right-from-bracket text-xs"></i>
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <!-- stats row -->
        <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 mt-8">
            <div class="bg-white/10 rounded-xl px-4 py-3 text-center">
                <p class="text-[11px] uppercase tracking-wide text-[#FFF8EF]/60 mb-1">Current Month</p>
                <span class="inline-block text-sm font-semibold bg-[#9CC5A1] text-[#123328] px-3 py-1 rounded-full">
                            {{ $currentMonthFull }} 2025
                        </span>
            </div>
            <div class="bg-white/10 rounded-xl px-4 py-3 text-center">
                <p class="text-[11px] uppercase tracking-wide text-[#FFF8EF]/60 mb-1">Total Bazar Amount</p>
                <span class="inline-block text-sm font-semibold bg-[#F2A65A] text-[#123328] px-3 py-1 rounded-full">
                            {{ $members->sum('bazar_sum_amount') }}
                        </span>
            </div>
            <div class="bg-white/10 rounded-xl px-4 py-3 text-center">
                <p class="text-[11px] uppercase tracking-wide text-[#FFF8EF]/60 mb-1">Total Meal</p>
                <span class="inline-block text-sm font-semibold bg-[#E8674B] text-[#FFF8EF] px-3 py-1 rounded-full">
                            {{ $members->sum('meals_sum_meal_count') }} meals
                        </span>
            </div>
            <div class="bg-white/10 rounded-xl px-4 py-3 text-center">
                <p class="text-[11px] uppercase tracking-wide text-[#FFF8EF]/60 mb-1">Meal Rate</p>
                @php
                    $totalMeals = $members->sum('meals_sum_meal_count');
                    $totalBazar = $members->sum('bazar_sum_amount');

                    $meal_rate = $totalMeals > 0
                        ? number_format($totalBazar / $totalMeals, 1)
                        : 0;
                @endphp
                <span class="inline-block text-sm font-semibold bg-white/80 text-[#123328] px-3 py-1 rounded-full">
                            {{ $meal_rate }}
                        </span>
            </div>
        </div>

        <!-- nav buttons -->
        <div class="relative z-10 flex items-center justify-center gap-2 flex-wrap mt-7">
            <a href="{{ route('meal.home') }}"
               class="inline-flex items-center gap-2 text-sm font-medium bg-[#9CC5A1] text-[#123328] hover:bg-[#84b489] px-4 py-2 rounded-full transition-colors">
                <i class="fas fa-house text-xs"></i> Home
            </a>
            <a href="{{ route('members.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-colors">
                <i class="fas fa-users text-xs"></i> Manage Members
            </a>
            <a href="{{ route('credentials.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-colors">
                <i class="fas fa-plus text-xs"></i> Flat Credentials
            </a>
            <a href="{{ route('ai.chat.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium bg-[#F2A65A] text-[#123328] hover:bg-[#e39548] px-4 py-2 rounded-full transition-colors">
                <i class="fas fa-wand-magic-sparkles text-xs"></i> AI Chat
            </a>
        </div>
    </div>

    <div class="mt-6">
        @yield('content')
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@yield('scripts')
</body>
</html>
