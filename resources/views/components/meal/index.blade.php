@extends('layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(count($members) > 0)

                <!-- Header -->
                <div class="mb-8">
                    <div class="rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 shadow-2xl">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h1 class="text-4xl font-bold text-white">
                                    Mess Management Dashboard
                                </h1>
                                <p class="mt-2 text-indigo-100 text-lg">
                                    Manage meals, bazar expenses and monthly calculations
                                </p>
                            </div>

                            <div class="mt-6 md:mt-0">
                                <div class="bg-white/20 backdrop-blur-md rounded-2xl px-6 py-4">
                                    <p class="text-white text-sm">Total Members</p>
                                    <p class="text-3xl font-bold text-white">
                                        {{ count($members) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Meal Form -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-5">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            🍽 Daily Meal Entry
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="" method="POST" id="mealForm">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Select Date
                                    </label>

                                    <input
                                        type="date"
                                        id="meal_date"
                                        name="meal_date"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:border-blue-500 focus:ring-blue-500"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
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
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:border-blue-500 focus:ring-blue-500"
                                        >

                                        <label
                                            for="selectAll"
                                            class="cursor-pointer px-4 py-3 bg-yellow-100 hover:bg-yellow-200 rounded-xl flex items-center gap-2 font-medium"
                                        >
                                            <input
                                                class="rounded text-blue-600"
                                                type="checkbox"
                                                id="selectAll"
                                                name="allMember"
                                            >
                                            Select All
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-lg font-bold text-gray-800 mb-4">
                                Member Meals
                            </h5>

                            <div class="member-input-row grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($members as $member)
                                    <div class="bg-slate-50 hover:bg-blue-50 border border-slate-200 rounded-2xl p-4 transition-all duration-300 meal">
                                        <label class="block text-sm font-semibold text-gray-700 capitalize mb-2">
                                            {{ $member->name }}
                                        </label>

                                        <input
                                            min="0"
                                            step="any"
                                            data-member-id="{{ $member->id }}"
                                            type="number"
                                            name="{{ $member->name }}"
                                            placeholder="Meal Count"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:border-green-500 focus:ring-green-500"
                                        >
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-wrap gap-3 mt-8">
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold shadow-lg"
                                >
                                    Save Meals
                                </button>

                                <button
                                    type="reset"
                                    class="px-6 py-3 border border-gray-300 hover:bg-gray-100 rounded-xl font-semibold"
                                >
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bazar Form -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-emerald-600 to-green-500 px-6 py-5">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            🛒 Bazar Entry
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="" method="POST" id="bazarForm">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Select Date
                                    </label>

                                    <input
                                        type="date"
                                        id="bazar_date"
                                        name="bazar_date"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:border-green-500 focus:ring-green-500"
                                    >
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Same Amount For Everyone
                                    </label>

                                    <div class="flex gap-3">
                                        <input
                                            min="0"
                                            type="number"
                                            id="sameBazar"
                                            name="sameBazar"
                                            placeholder="Amount"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:border-blue-500 focus:ring-blue-500"
                                        >

                                        <label
                                            for="selectAllBazarMember"
                                            class="cursor-pointer px-4 py-3 bg-yellow-100 hover:bg-yellow-200 rounded-xl flex items-center gap-2 font-medium"
                                        >
                                            <input
                                                class="rounded text-green-600"
                                                type="checkbox"
                                                id="selectAllBazarMember"
                                                name="selectAllBazarMember"
                                            >
                                            Select All
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-lg font-bold text-gray-800 mb-4">
                                Member Bazar Amounts
                            </h5>

                            <div class="bazar-input-row grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($members as $member)
                                    <div class="bg-slate-50 hover:bg-green-50 border border-slate-200 rounded-2xl p-4 transition-all duration-300 bazar">
                                        <label class="block text-sm font-semibold text-gray-700 capitalize mb-2">
                                            {{ $member->name }}
                                        </label>

                                        <input
                                            min="0"
                                            step="any"
                                            data-member-id="{{ $member->id }}"
                                            type="number"
                                            name="{{ $member->name }}"
                                            placeholder="Bazar Amount"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:border-green-500 focus:ring-green-500"
                                        >
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-wrap gap-3 mt-8">
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold shadow-lg"
                                >
                                    Save Bazar
                                </button>

                                <button
                                    type="reset"
                                    class="px-6 py-3 border border-gray-300 hover:bg-gray-100 rounded-xl font-semibold"
                                >
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Monthly Expense -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <div class="bg-linear-to-r from-purple-600 to-violet-600 px-6 py-5">
                        <h2 class="text-2xl font-bold text-white">
                            💰 Monthly Expense Calculator
                        </h2>
                    </div>

                    <div class="p-6">
                        <form id="calculateMonthlyExpense" method="POST">
                            @csrf
                            <div class="grid lg:grid-cols-2 gap-6">
                                <div class="mb-6">
                                    <label class="block font-semibold text-gray-700 mb-2">
                                        ফ্ল্যাট ভাড়া
                                    </label>

                                    <input
                                        id="flat_rent"
                                        name="flat_rent"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                </div>

                                {{-- Month Name --}}
                                <div class="mb-6">
                                    <label class="block font-semibold text-gray-700 mb-2">
                                        Month
                                    </label>
                                    <select name="month" id="month" class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                                <div class="bg-slate-50 rounded-2xl p-5 border">
                                    <h5 class="font-bold mb-4">সার্ভিস চার্জ</h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-indigo-100 hover:bg-indigo-200 cursor-pointer flex items-center gap-2">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_service_charge_check"
                                                    id="mill_member_service_charge{{ $member->id+111 }}"
                                                    name="service_charge_member{{ $member->id+111 }}"
                                                    type="checkbox">
                                                <span class="capitalize">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="service_charge"
                                        name="service_charge"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Electricity -->
                                <div class="bg-slate-50 rounded-2xl p-5 border">
                                    <h5 class="font-bold mb-4">বিদ্যুৎ বিল</h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-yellow-100 hover:bg-yellow-200 cursor-pointer flex items-center gap-2">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_electricity_check"
                                                    id="mill_member_electricity{{ $member->id+777 }}"
                                                    name="electricity_member{{ $member->id+777 }}"
                                                    type="checkbox">
                                                <span class="capitalize">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="electricity_bill"
                                        name="electricity_bill"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Wifi -->
                                <div class="bg-slate-50 rounded-2xl p-5 border">
                                    <h5 class="font-bold mb-4">ওয়াইফাই বিল</h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-green-100 hover:bg-green-200 cursor-pointer flex items-center gap-2">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_wifi_check"
                                                    id="mill_member_wifi{{ $member->id+888 }}"
                                                    name="wifi_member{{ $member->id+888 }}"
                                                    type="checkbox"
                                                >
                                                <span class="capitalize">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="wifi_bill"
                                        name="wifi_bill"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Gas -->
                                <div class="bg-slate-50 rounded-2xl p-5 border">
                                    <h5 class="font-bold mb-4">গ্যাস বিল</h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-red-100 hover:bg-red-200 cursor-pointer flex items-center gap-2">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_gas_bill_check"
                                                    id="mill_member_gas_bill{{ $member->id+222 }}"
                                                    name="gas_bill_member{{ $member->id+222 }}"
                                                    type="checkbox">
                                                <span class="capitalize">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="gas_bill"
                                        name="gas_bill"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Amount"
                                    >
                                </div>

                                <!-- Khala Salary -->
                                <div class="bg-slate-50 rounded-2xl p-5 border ">
                                    <h5 class="font-bold mb-4">খালা বেতন</h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-purple-100 hover:bg-purple-200 cursor-pointer flex items-center gap-2">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_amount_check"
                                                    id="mill_member{{ $member->id+999 }}"
                                                    name="khala_member{{ $member->id+999 }}"
                                                    type="checkbox">
                                                <span class="capitalize">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        name="khala_salary"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Amount"
                                    >
                                </div>

                                {{--Garbage charge--}}
                                <div class="bg-slate-50 rounded-2xl p-5 border">
                                    <h5 class="font-bold mb-4">ময়লা বিল</h5>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($members as $member)
                                            <label class="px-3 py-2 rounded-full bg-yellow-100 hover:bg-yellow-200 cursor-pointer flex items-center gap-2">
                                                <input
                                                    data-miller-id="{{ $member->id }}"
                                                    class="mill_member_garbage_check"
                                                    id="mill_member_garbage{{ $member->id+777 }}"
                                                    name="garbage_member{{ $member->id+777 }}"
                                                    type="checkbox">
                                                <span class="capitalize">{{ $member->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <input
                                        id="garbage_charge"
                                        name="garbage_charge"
                                        type="number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    </div>

                                </div>



                                <div class="sticky bottom-4 mt-8">
                                    <button
                                        type="submit"
                                        class="w-full py-4 rounded-2xl bg-linear-to-r from-purple-600 to-violet-600 text-white font-bold text-lg shadow-xl hover:scale-[1.01] transition-all"
                                    >
                                        হিসাব করুন
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                @else

                    <div class="flex justify-center items-center py-20">
                        <div class="bg-white rounded-3xl shadow-xl p-10 text-center max-w-md">
                            <h2 class="text-2xl font-bold mb-4">
                                No Members Found
                            </h2>

                            <p class="text-gray-500 mb-6">
                                Add members before managing meals and expenses.
                            </p>

                            <a
                                href="{{ route('members.index') }}"
                                class="inline-flex items-center px-6 py-3 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white font-semibold"
                            >
                                Add Members
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
