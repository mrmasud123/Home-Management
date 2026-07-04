@extends('layout')

@section('content')
    <div class="min-h-screen bg-[#FBF9F4] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(count($members) > 0)

                <!-- Header -->
                <div class="mb-8">
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#123328] via-[#1B4536] to-[#0B241C] p-8 shadow-xl shadow-black/10">
                        <div class="pointer-events-none absolute -top-16 -left-10 w-64 h-64 rounded-full bg-[#9CC5A1]/20 blur-3xl"></div>
                        <div class="pointer-events-none absolute -bottom-20 -right-10 w-72 h-72 rounded-full bg-[#F2A65A]/20 blur-3xl"></div>

                        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-[#E8674B] shrink-0">
                                    <i class="fas fa-bowl-food text-2xl text-[#FFF8EF]"></i>
                                </div>
                                <div>
                                    <h1 class="text-2xl sm:text-3xl font-bold text-[#FFF8EF]">
                                        Mess Management Dashboard
                                    </h1>
                                    <p class="mt-1 text-[#FFF8EF]/60 text-sm sm:text-base">
                                        Manage meals, bazar expenses and monthly calculations
                                    </p>
                                </div>
                            </div>

                            <div class="bg-white/10 rounded-2xl px-6 py-4 text-center md:text-left">
                                <p class="text-[#FFF8EF]/60 text-xs uppercase tracking-wide">Total Members</p>
                                <p class="text-3xl font-bold text-[#FFF8EF] mt-0.5">
                                    {{ count($members) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Meal Form -->
                <div class="bg-white rounded-3xl shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-[#1B4536] to-[#123328] px-6 py-5">
                        <h2 class="text-xl sm:text-2xl font-bold text-[#FFF8EF] flex items-center gap-3">
                            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-[#9CC5A1] text-[#123328]">
                                <i class="fas fa-utensils text-sm"></i>
                            </span>
                            Daily Meal Entry
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="" method="POST" id="mealForm">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-semibold text-[#20291F]/70 mb-2">
                                        Select Date
                                    </label>

                                    <input
                                        type="date"
                                        id="meal_date"
                                        name="meal_date"
                                        required
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#20291F]/70 mb-2">
                                        Same Meal For Everyone
                                    </label>

                                    <div class="flex gap-3">
                                        <input
                                            type="number"
                                            min="0"
                                            step="any"
                                            id="sameMeal"
                                            name="sameMeal"
                                            placeholder="Meal Count"
                                            class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        >

                                        <label
                                            for="selectAll"
                                            class="cursor-pointer px-4 py-3 bg-[#F2A65A]/20 hover:bg-[#F2A65A]/30 rounded-xl flex items-center gap-2 font-medium text-[#20291F] whitespace-nowrap transition-colors"
                                        >
                                            <input
                                                class="rounded text-[#E8674B] focus:ring-[#E8674B]"
                                                type="checkbox"
                                                id="selectAll"
                                                name="allMember"
                                            >
                                            Select All
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-lg font-bold text-[#20291F] mb-4">
                                Member Meals
                            </h5>

                            <div class="member-input-row grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($members as $member)
                                    <div class="bg-[#FBF9F4] hover:bg-[#9CC5A1]/15 border border-[#20291F]/5 rounded-2xl p-4 transition-all duration-300 meal">
                                        <label class="block text-sm font-semibold text-[#20291F]/80 capitalize mb-2">
                                            {{ $member->name }}
                                        </label>

                                        <input
                                            min="0"
                                            step="any"
                                            data-member-id="{{ $member->id }}"
                                            type="number"
                                            name="{{ $member->name }}"
                                            placeholder="Meal Count"
                                            class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        >
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-wrap gap-3 mt-8">
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#E8674B] hover:bg-[#d4573d] text-[#FFF8EF] rounded-xl font-semibold shadow-md shadow-[#E8674B]/20 transition-colors"
                                >
                                    <i class="fas fa-floppy-disk"></i>Save Meals
                                </button>

                                <button
                                    type="reset"
                                    class="inline-flex items-center gap-2 px-6 py-3 border border-[#20291F]/10 hover:bg-[#20291F]/5 text-[#20291F]/70 rounded-xl font-semibold transition-colors"
                                >
                                    <i class="fas fa-rotate-left"></i>Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bazar Form -->
                <div class="bg-white rounded-3xl shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-[#E8674B] to-[#d4573d] px-6 py-5">
                        <h2 class="text-xl sm:text-2xl font-bold text-[#FFF8EF] flex items-center gap-3">
                            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-white/20 text-[#FFF8EF]">
                                <i class="fas fa-cart-shopping text-sm"></i>
                            </span>
                            Bazar Entry
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="" method="POST" id="bazarForm">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-semibold text-[#20291F]/70 mb-2">
                                        Select Date
                                    </label>

                                    <input
                                        type="date"
                                        id="bazar_date"
                                        name="bazar_date"
                                        required
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#20291F]/70 mb-2">
                                        Same Amount For Everyone
                                    </label>

                                    <div class="flex gap-3">
                                        <input
                                            min="0"
                                            type="number"
                                            id="sameBazar"
                                            name="sameBazar"
                                            placeholder="Amount"
                                            class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        >

                                        <label
                                            for="selectAllBazarMember"
                                            class="cursor-pointer px-4 py-3 bg-[#F2A65A]/20 hover:bg-[#F2A65A]/30 rounded-xl flex items-center gap-2 font-medium text-[#20291F] whitespace-nowrap transition-colors"
                                        >
                                            <input
                                                class="rounded text-[#E8674B] focus:ring-[#E8674B]"
                                                type="checkbox"
                                                id="selectAllBazarMember"
                                                name="selectAllBazarMember"
                                            >
                                            Select All
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-lg font-bold text-[#20291F] mb-4">
                                Member Bazar Amounts
                            </h5>

                            <div class="bazar-input-row grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($members as $member)
                                    <div class="bg-[#FBF9F4] hover:bg-[#E8674B]/10 border border-[#20291F]/5 rounded-2xl p-4 transition-all duration-300 bazar">
                                        <label class="block text-sm font-semibold text-[#20291F]/80 capitalize mb-2">
                                            {{ $member->name }}
                                        </label>

                                        <input
                                            min="0"
                                            step="any"
                                            data-member-id="{{ $member->id }}"
                                            type="number"
                                            name="{{ $member->name }}"
                                            placeholder="Bazar Amount"
                                            class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        >
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-wrap gap-3 mt-8">
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#E8674B] hover:bg-[#d4573d] text-[#FFF8EF] rounded-xl font-semibold shadow-md shadow-[#E8674B]/20 transition-colors"
                                >
                                    <i class="fas fa-floppy-disk"></i>Save Bazar
                                </button>

                                <button
                                    type="reset"
                                    class="inline-flex items-center gap-2 px-6 py-3 border border-[#20291F]/10 hover:bg-[#20291F]/5 text-[#20291F]/70 rounded-xl font-semibold transition-colors"
                                >
                                    <i class="fas fa-rotate-left"></i>Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Monthly Expense -->
                <div class="bg-white rounded-3xl shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#F2A65A] to-[#e0914f] px-6 py-5">
                        <h2 class="text-xl sm:text-2xl font-bold text-[#123328] flex items-center gap-3">
                            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-white/40 text-[#123328]">
                                <i class="fas fa-coins text-sm"></i>
                            </span>
                            Monthly Expense Calculator
                        </h2>
                    </div>

                    <div class="p-6">
                        <form id="calculateMonthlyExpense" method="POST">
                            @csrf
                            <div class="grid lg:grid-cols-2 gap-6">
                                <div class="mb-6">
                                    <label class="block font-semibold text-[#20291F]/80 mb-2">
                                        ফ্ল্যাট ভাড়া
                                    </label>

                                    <input
                                        id="flat_rent"
                                        name="flat_rent"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                    >
                                </div>

                                {{-- Month Name --}}
                                <div class="mb-6">
                                    <label class="block font-semibold text-[#20291F]/80 mb-2">
                                        Month
                                    </label>
                                    <select name="month" id="month" class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition">
                                        <option value="" selected disabled>Choose Month</option>
                                        <option value="january">January</option>
                                        <option value="february">February</option>
                                        <option value="march">March</option>
                                        <option value="april">April</option>
                                        <option value="may">May</option>
                                        <option value="june">June</option>
                                        <option value="july">July</option>
                                        <option value="august">August</option>
                                        <option value="september">September</option>
                                        <option value="october">October</option>
                                        <option value="november">November</option>
                                        <option value="december">December</option>
                                    </select>
                                </div>

                                <!-- Service Charge -->
                                <div class="bg-[#FBF9F4] rounded-2xl p-5 border border-[#20291F]/5">
                                    <h5 class="font-bold text-[#20291F] mb-4 flex items-center gap-2">
                                        <i class="fas fa-handshake-angle text-[#9CC5A1]"></i>সার্ভিস চার্জ
                                    </h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-[#9CC5A1]/20 hover:bg-[#9CC5A1]/30 cursor-pointer flex items-center gap-2 transition-colors">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_service_charge_check rounded text-[#1B4536]"
                                                    id="mill_member_service_charge{{ $member->id+111 }}"
                                                    name="service_charge_member{{ $member->id+111 }}"
                                                    type="checkbox">
                                                <span class="capitalize text-sm text-[#20291F]">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="service_charge"
                                        name="service_charge"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Electricity -->
                                <div class="bg-[#FBF9F4] rounded-2xl p-5 border border-[#20291F]/5">
                                    <h5 class="font-bold text-[#20291F] mb-4 flex items-center gap-2">
                                        <i class="fas fa-bolt text-[#F2A65A]"></i>বিদ্যুৎ বিল
                                    </h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-[#F2A65A]/20 hover:bg-[#F2A65A]/30 cursor-pointer flex items-center gap-2 transition-colors">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_electricity_check rounded text-[#c07a2a]"
                                                    id="mill_member_electricity{{ $member->id+777 }}"
                                                    name="electricity_member{{ $member->id+777 }}"
                                                    type="checkbox">
                                                <span class="capitalize text-sm text-[#20291F]">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="electricity_bill"
                                        name="electricity_bill"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Wifi -->
                                <div class="bg-[#FBF9F4] rounded-2xl p-5 border border-[#20291F]/5">
                                    <h5 class="font-bold text-[#20291F] mb-4 flex items-center gap-2">
                                        <i class="fas fa-wifi text-[#1B4536]"></i>ওয়াইফাই বিল
                                    </h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-[#1B4536]/10 hover:bg-[#1B4536]/20 cursor-pointer flex items-center gap-2 transition-colors">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_wifi_check rounded text-[#1B4536]"
                                                    id="mill_member_wifi{{ $member->id+888 }}"
                                                    name="wifi_member{{ $member->id+888 }}"
                                                    type="checkbox"
                                                >
                                                <span class="capitalize text-sm text-[#20291F]">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="wifi_bill"
                                        name="wifi_bill"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Gas -->
                                <div class="bg-[#FBF9F4] rounded-2xl p-5 border border-[#20291F]/5">
                                    <h5 class="font-bold text-[#20291F] mb-4 flex items-center gap-2">
                                        <i class="fas fa-fire-flame-simple text-[#E8674B]"></i>গ্যাস বিল
                                    </h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-[#E8674B]/15 hover:bg-[#E8674B]/25 cursor-pointer flex items-center gap-2 transition-colors">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_gas_bill_check rounded text-[#E8674B]"
                                                    id="mill_member_gas_bill{{ $member->id+222 }}"
                                                    name="gas_bill_member{{ $member->id+222 }}"
                                                    type="checkbox">
                                                <span class="capitalize text-sm text-[#20291F]">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="gas_bill"
                                        name="gas_bill"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Khala Salary -->
                                <div class="bg-[#FBF9F4] rounded-2xl p-5 border border-[#20291F]/5">
                                    <h5 class="font-bold text-[#20291F] mb-4 flex items-center gap-2">
                                        <i class="fas fa-user text-[#9CC5A1]"></i>খালা বেতন
                                    </h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-[#9CC5A1]/20 hover:bg-[#9CC5A1]/30 cursor-pointer flex items-center gap-2 transition-colors">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_amount_check rounded text-[#1B4536]"
                                                    id="mill_member{{ $member->id+999 }}"
                                                    name="khala_member{{ $member->id+999 }}"
                                                    type="checkbox">
                                                <span class="capitalize text-sm text-[#20291F]">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        name="khala_salary"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                        placeholder="Amount"
                                    >
                                </div>

                                {{--Garbage charge--}}
                                <div class="bg-[#FBF9F4] rounded-2xl p-5 border border-[#20291F]/5">
                                    <h5 class="font-bold text-[#20291F] mb-4 flex items-center gap-2">
                                        <i class="fas fa-trash-can text-[#F2A65A]"></i>ময়লা বিল
                                    </h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-[#F2A65A]/20 hover:bg-[#F2A65A]/30 cursor-pointer flex items-center gap-2 transition-colors">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_garbage_check rounded text-[#c07a2a]"
                                                    id="mill_member_garbage{{ $member->id+777 }}"
                                                    name="garbage_member{{ $member->id+777 }}"
                                                    type="checkbox">
                                                <span class="capitalize text-sm text-[#20291F]">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="garbage_charge"
                                        name="garbage_charge"
                                        type="number"
                                        class="w-full px-4 py-3 border border-[#20291F]/10 rounded-xl bg-white text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition"
                                    >
                                </div>

                            </div>

                            <div class="sticky bottom-4 mt-8">
                                <button
                                    type="submit"
                                    class="w-full py-4 rounded-2xl bg-gradient-to-r from-[#123328] to-[#1B4536] text-[#FFF8EF] font-bold text-lg shadow-xl shadow-black/10 hover:scale-[1.01] transition-all flex items-center justify-center gap-3"
                                >
                                    <i class="fas fa-calculator"></i>হিসাব করুন
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            @else

                <div class="flex justify-center items-center py-20">
                    <div class="bg-white rounded-3xl shadow-sm shadow-black/5 border border-[#20291F]/5 p-10 text-center max-w-md">
                        <i class="fas fa-bowl-food text-4xl text-[#9CC5A1] mb-4 block"></i>
                        <h2 class="text-2xl font-bold text-[#20291F] mb-2">
                            No Members Found
                        </h2>

                        <p class="text-[#20291F]/50 mb-6">
                            Add members before managing meals and expenses.
                        </p>

                        <a
                            href="{{ route('members.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#E8674B] hover:bg-[#d4573d] text-[#FFF8EF] font-semibold shadow-md shadow-[#E8674B]/20 transition-colors"
                        >
                            <i class="fas fa-user-plus"></i>Add Members
                        </a>
                    </div>
                </div>

            @endif

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="{{ asset('js/script.js') }}"></script>
@endsection
