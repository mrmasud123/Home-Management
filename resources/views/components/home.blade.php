@extends('layout')

@section('content')
    @php
        $totalMeals = $members->sum('meals_sum_meal_count');
        $totalBazar = $members->sum('bazar_sum_amount');

        $meal_rate = $totalMeals > 0
            ? round($totalBazar / $totalMeals, 1)
            : 0;
    @endphp

    <div class="mill-contents space-y-8">

        <!-- Meal Table -->
        <div class="bg-white rounded-2xl border border-[#EFE9DA] shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-[#EFE9DA]">
                <i class="fas fa-utensils text-[#E8674B]"></i>
                <h2 class="text-lg font-semibold text-[#123328]">Meal Records</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#123328] text-[#FFF8EF]">
                    <tr class="text-center">
                        <th class="px-4 py-3 font-medium whitespace-nowrap">Date</th>
                        @foreach ($members as $member)
                            <th class="px-4 py-3 font-medium whitespace-nowrap">{{ ucfirst($member->name) }}</th>
                        @endforeach
                        <th class="px-4 py-3 font-medium whitespace-nowrap">Action</th>
                    </tr>
                    </thead>
                    <tbody id="millTableBody" class="divide-y divide-[#F1ECE0]">
                    @if (!empty($meals))
                        @foreach ($meals as $date => $mealCollection)
                            <tr class="text-center odd:bg-white even:bg-[#FBF9F4] hover:bg-[#FFF6F1] transition-colors">
                                <td class="px-4 py-2.5 whitespace-nowrap">{{ $date }}</td>
                                @foreach ($members as $member)
                                    @php
                                        $meal = $mealCollection->firstWhere('member_name', $member->name);
                                    @endphp
                                    <td class="px-4 py-2.5">{{ $meal->meal_count ?? 0 }}</td>
                                @endforeach
                                @if($admin)

                                    <td class="px-4 py-2.5">
                                        <button class="meal-edit inline-flex items-center gap-1.5 text-xs font-medium text-[#0E7C6B] border border-[#0E7C6B]/30 hover:bg-[#0E7C6B] hover:text-white px-3 py-1.5 rounded-full transition-colors"
                                                data-meal-date="{{ $date }}">
                                            <i class="fas fa-pen text-[10px]"></i> Edit
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="text-center bg-[#EFF6F0] font-semibold">
                            <td class="px-4 py-3">
                                <span class="inline-block bg-[#9CC5A1] text-[#123328] text-xs px-3 py-1 rounded-full">Total</span>
                            </td>
                            @foreach ($members as $member)
                                <td class="px-4 py-3">
                                    <span class="inline-block bg-[#9CC5A1] text-[#123328] text-xs px-3 py-1 rounded-full">
                                        {{ $member->meals_sum_meal_count ?? 0 }}
                                    </span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <span class="inline-block bg-[#F2A65A] text-[#123328] text-xs px-3 py-1 rounded-full">{{ $totalMeals }}</span>
                            </td>
                        </tr>
                    @else
                        <tr class="text-center">
                            <td colspan="{{ count($members) + 2 }}">
                                <div class="py-10">
                                    <i class="fas fa-utensils fa-2x text-[#C9C1AC] mb-2"></i>
                                    <p class="text-[#9C9282]">No meal found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bazar Amount Section -->
        <div class="bg-white rounded-2xl border border-[#EFE9DA] shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-[#EFE9DA] flex-wrap gap-3">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-[#F2A65A]"></i>
                    <h2 class="text-lg font-semibold text-[#123328]">Bazar Amount</h2>
                </div>
                <a href="{{ route('bazar.report', \Carbon\Carbon::parse(date('Y-m-d'))->format('Y-m')) }}"
                   class="inline-flex items-center gap-2 text-sm font-medium bg-[#E8674B] hover:bg-[#D65B3F] text-white px-4 py-2 rounded-full transition-colors">
                    <i class="fas fa-file-pdf text-xs"></i> Generate Bazar Report
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#123328] text-[#FFF8EF]">
                    <tr class="text-center">
                        <th class="px-4 py-3 font-medium whitespace-nowrap">Date</th>
                        @foreach ($members as $member)
                            <th class="px-4 py-3 font-medium whitespace-nowrap">{{ ucfirst($member->name) }}</th>
                        @endforeach
                        <th class="px-4 py-3 font-medium whitespace-nowrap">Action</th>
                    </tr>
                    </thead>
                    <tbody id="bazarTableBody" class="divide-y divide-[#F1ECE0]">
                    @if (!empty($bazars))
                        @foreach ($bazars as $date => $bazarCollection)
                            <tr class="text-center odd:bg-white even:bg-[#FBF9F4] hover:bg-[#FFF6F1] transition-colors">
                                <td class="px-4 py-2.5 whitespace-nowrap">{{ $date }}</td>
                                @foreach ($members as $member)
                                    @php
                                        $bazar = $bazarCollection->firstWhere('member_name', $member->name);
                                    @endphp
                                    <td class="px-4 py-2.5">{{ $bazar->amount ?? 0 }}</td>
                                @endforeach
                                @if($admin)
                                    <td class="px-4 py-2.5">
                                        <button class="bazar-edit inline-flex items-center gap-1.5 text-xs font-medium text-[#0E7C6B] border border-[#0E7C6B]/30 hover:bg-[#0E7C6B] hover:text-white px-3 py-1.5 rounded-full transition-colors"
                                                data-bazar-date="{{ $date }}">
                                            <i class="fas fa-pen text-[10px]"></i> Edit
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="text-center bg-[#EFF6F0] font-semibold">
                            <td class="px-4 py-3">
                                <span class="inline-block bg-[#9CC5A1] text-[#123328] text-xs px-3 py-1 rounded-full">Total</span>
                            </td>
                            @foreach ($members as $member)
                                <td class="px-4 py-3">
                                    <span class="inline-block bg-[#9CC5A1] text-[#123328] text-xs px-3 py-1 rounded-full">{{ $member->bazar_sum_amount ?? 0 }}</span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <span class="inline-block bg-[#F2A65A] text-[#123328] text-xs px-3 py-1 rounded-full">{{ $members->sum('bazar_sum_amount') }}</span>
                            </td>
                        </tr>

                        {{-- Expense Row --}}
                        <tr class="text-center bg-[#FBF9F4] font-semibold">
                            <td class="px-4 py-3">
                                <span class="inline-block bg-white border border-[#EFE9DA] text-[#123328] text-xs px-3 py-1 rounded-full">Expense</span>
                            </td>
                            @php $totalExpense = 0; @endphp
                            @foreach ($members as $member)
                                @php
                                    $memberMeals = $member->meals_sum_meal_count ?? 0;
                                    $memberExpense = ($meal_rate > 0 && $memberMeals > 0)
                                        ? $memberMeals * $meal_rate
                                        : 0;
                                    $totalExpense += $memberExpense;
                                @endphp
                                <td class="px-4 py-3">
                                    <span class="inline-block bg-[#E3D9C6] text-[#123328] text-xs px-3 py-1 rounded-full">{{ number_format($memberExpense, 1) }}</span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <span class="inline-block bg-[#F2A65A] text-[#123328] text-xs px-3 py-1 rounded-full">{{ number_format($totalExpense, 1) }}</span>
                            </td>
                        </tr>

                        {{-- Due/Pay Row --}}
                        <tr class="text-center bg-white font-semibold">
                            <td class="px-4 py-3">
                                <span class="inline-block bg-white border border-[#EFE9DA] text-[#123328] text-xs px-3 py-1 rounded-full">Due/Pay</span>
                            </td>
                            @php
                                $totalGive = 0;
                                $totalTake = 0;
                            @endphp
                            @foreach ($members as $member)
                                @php
                                    $memberMeals = $member->meals_sum_meal_count ?? 0;
                                    $memberExpense = ($meal_rate > 0 && $memberMeals > 0)
                                        ? $memberMeals * $meal_rate
                                        : 0;
                                    $duePay = ($member->bazar_sum_amount ?? 0) - $memberExpense;
                                    if ($duePay > 0) {
                                        $totalGive += $duePay;
                                    } else {
                                        $totalTake += abs($duePay);
                                    }
                                @endphp
                                <td class="px-4 py-3">
                                    <span class="inline-block text-xs px-3 py-1 rounded-full {{ $duePay > 0 ? 'bg-[#9CC5A1] text-[#123328]' : 'bg-[#E8674B] text-white' }}">
                                        {{ number_format($duePay, 1) }}
                                    </span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3 space-x-1">
                                <span class="inline-block bg-[#9CC5A1] text-[#123328] text-xs px-3 py-1 rounded-full">{{ number_format($totalGive, 1) }}</span>
                                <span class="inline-block bg-[#E8674B] text-white text-xs px-3 py-1 rounded-full">{{ number_format($totalTake, 1) }}</span>
                            </td>
                        </tr>

                    @else
                        <tr class="text-center">
                            <td colspan="{{ count($members) + 2 }}">
                                <div class="py-10">
                                    <i class="fas fa-shopping-bag fa-2x text-[#C9C1AC] mb-2"></i>
                                    <p class="text-[#9C9282]">No Bazar found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly History Selector -->
        <div class="bg-white rounded-2xl border border-[#EFE9DA] shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-5 py-4 border-b border-[#EFE9DA] bg-[#123328] text-[#FFF8EF]">
                <i class="fas fa-clock-rotate-left"></i>
                <h2 class="text-base font-semibold">Monthly History</h2>
            </div>
            <div class="px-5 py-4 flex flex-wrap gap-2">
                @php
                    $currentMonth = \Carbon\Carbon::parse(date('Y-m'))->format('Y-m');
                @endphp
                @foreach ($months as $month)
                    <a href="{{ route('meal.history', $month->month_value) }}"
                       class="text-sm font-medium px-4 py-1.5 rounded-full transition-colors {{ $month->month_value == $currentMonth ? 'bg-[#F2A65A] text-[#123328]' : 'bg-[#9CC5A1]/40 text-[#123328] hover:bg-[#9CC5A1]' }}">
                        {{ $month->month_name }}
                    </a>
                @endforeach
            </div>
        </div>



    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            // Meal Edit
            $('.meal-edit').on('click',function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Fetching Meal Record...',
                    text: 'Please wait while we load the data.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                let meal_date=$(this).data('mealDate');
                $.ajax({
                    url: '/meal/' + meal_date,
                    type: 'get',
                    success:function(data){
                        var html="";
                        data.map((item)=>{
                            html+=`<div class="flex items-center gap-3 mb-3 text-left">
                                             <div class="w-1/4">
                                                 <label class="text-sm font-semibold capitalize text-[#123328]">${item.member_name}</label>
                                             </div>
                                             <div class="w-1/3">
                                                 <input min="0" value="${item.meal_count}" type="number" step="any" name="${item.member_name}"
                                                        class="update_meal w-full rounded-lg border border-[#E3D9C6] px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]"
                                                        data-meal-id="${item.id}">
                                            </div>
                                             <div class="w-1/3">
                                                 <input readonly value="${item.meal_date}" type="date"
                                                        class="w-full rounded-lg border border-[#E3D9C6] bg-[#FBF9F4] px-3 py-1.5 text-sm text-[#9C9282]">
                                            </div>
                                       </div>`;
                        });

                        Swal.fire({
                            html: html,
                            title: 'Meal Edit!',
                        }).then(()=>{
                            window.location.href = '/';
                        });
                    }
                });
            });
            $(document).on('change', '.update_meal', function() {
                let mealId = $(this).data("mealId");
                let mealCount = $(this).val();
                let mealDate = $(this).closest('.flex').find('input[type="date"]').val();
                $.ajax({
                    url: '/meal/update/'+ mealId,
                    method : 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        mealCount:mealCount,
                        mealDate:mealDate
                    },
                    success:function(data){
                        console.log(data)
                    }
                });
            });

            // Bazar Edit
            $('.bazar-edit').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Fetching Bazar Record...',
                    text: 'Please wait while we load the data.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                let bazar_date = $(this).data('bazarDate');
                $.ajax({
                    url: '/get-bazar/' + bazar_date,
                    type: 'get',
                    success: function (data) {
                        Swal.close();
                        if (!data || data.length === 0) {
                            Swal.fire({
                                title: 'No Data',
                                text: 'No bazar records found for this date.',
                                icon: 'info'
                            });
                            return;
                        }
                        var html = "";
                        data.forEach((item) => {
                            html += `<div class="flex items-center gap-3 mb-3 text-left">
                                        <div class="w-1/4">
                                            <label class="text-sm font-semibold capitalize text-[#123328]">${item.member_name || 'Unknown'}</label>
                                        </div>
                                        <div class="w-1/3">
                                            <input min="0" value="${item.amount || 0}" type="number" step="any" name="${item.member_name || 'unknown'}"
                                                   class="update_bazar w-full rounded-lg border border-[#E3D9C6] px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]"
                                                   data-bazar-id="${item.id}">
                                        </div>
                                        <div class="w-1/3">
                                            <input readonly value="${item.bazar_amt_date}" type="date"
                                                   class="w-full rounded-lg border border-[#E3D9C6] bg-[#FBF9F4] px-3 py-1.5 text-sm text-[#9C9282]">
                                        </div>
                                    </div>`;
                        });

                        Swal.fire({
                            html: html,
                            title: 'Bazar Edit!',
                            showConfirmButton: true,
                            confirmButtonText: 'Save'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/';
                            }
                        });
                    },
                    error: function (xhr) {
                        Swal.close();
                        Swal.fire({
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to load bazar data.',
                            icon: 'error'
                        });
                    }
                });
            });

            $(document).on('change', '.update_bazar', function() {
                let bazarId = $(this).data("bazarId");
                let bazarAmount = $(this).val();
                let bazarDate = $(this).closest('.flex').find('input[type="date"]').val();
                $.ajax({
                    url: '/bazar/'+ bazarId,
                    method : 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bazarAmount:bazarAmount,
                        bazarDate:bazarDate
                    },
                    success:function(data){
                        console.log(data)
                    }
                });
            });
        });
    </script>
@endsection
