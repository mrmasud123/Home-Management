@extends('layout')
@section('content')
    @php
        $totalMeals = $members->sum('meals_sum_meal_count');
        $totalBazar = $members->sum('bazar_sum_amount');

        $meal_rate = $totalMeals > 0
            ? number_format($totalBazar / $totalMeals, 1)
            : 0;
    @endphp

    <div class="mill-contents space-y-6">

        <!-- Meal Table -->
        <div class="mill-table bg-white rounded-2xl shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden">

            <div class="flex items-center gap-3 px-6 sm:px-8 py-5 bg-gradient-to-r from-[#123328] to-[#1B4536]">
            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-[#9CC5A1] text-[#123328]">
                <i class="fas fa-utensils text-sm"></i>
            </span>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-[#FFF8EF] leading-tight">Meal History</h2>
                    <p class="text-xs text-[#FFF8EF]/60">Daily meal counts for every member</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="text-center text-[11px] uppercase tracking-wide text-[#20291F]/40 bg-[#FBF9F4] border-b border-[#20291F]/5">
                        <th class="px-4 py-3 font-semibold text-left">Date</th>
                        @foreach ($members as $member)
                            <th class="px-4 py-3 font-semibold">{{ ucfirst($member->name) }}</th>
                        @endforeach
                        <th class="px-4 py-3 font-semibold">Action</th>
                    </tr>
                    </thead>
                    <tbody id="millTableBody" class="divide-y divide-[#20291F]/5">
                    @if (!empty($meals))
                        @foreach ($meals as $date => $mealCollection)
                            <tr class="text-center hover:bg-[#FBF9F4] transition-colors">
                                <td class="px-4 py-2.5 text-left font-medium text-[#20291F]">{{ $date }}</td>
                                @foreach ($members as $member)
                                    @php
                                        $meal = $mealCollection->firstWhere('member_name', $member->name);
                                    @endphp
                                    <td class="px-4 py-2.5 text-[#20291F]/70">{{ $meal->meal_count ?? 0 }}</td>
                                @endforeach
                                <td class="px-4 py-2.5">
                                    <button class="meal-edit inline-flex items-center gap-1.5 text-xs font-semibold bg-[#F2A65A]/15 hover:bg-[#F2A65A] hover:text-white text-[#9a6323] px-3 py-1.5 rounded-full transition-colors" data-meal-date="{{ $date }}">
                                        <i class="fas fa-pen text-[10px]"></i>Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="text-center bg-[#123328]">
                            <td class="px-4 py-3 text-left">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#9CC5A1] text-[#123328] px-3 py-1 rounded-full">Total</span>
                            </td>
                            @foreach ($members as $member)
                                <td class="px-4 py-3">
                                    <span class="custom-badge inline-flex items-center text-xs font-semibold bg-white/15 text-[#FFF8EF] px-3 py-1 rounded-full">
                                        {{ $member->meals_sum_meal_count ?? 0 }}
                                    </span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#F2A65A] text-[#123328] px-3 py-1 rounded-full">{{ $totalMeals }}</span>
                            </td>
                        </tr>
                    @else
                        <tr class="text-center">
                            <td colspan="{{ count($members) + 2 }}">
                                <div class="py-10">
                                    <i class="fas fa-utensils text-3xl text-[#9CC5A1] mb-2 block"></i>
                                    <p class="text-[#20291F]/40 font-medium">No meal found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bazar Amount Section -->
        <div class="money bg-white rounded-2xl shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden">

            <div class="flex items-center gap-3 px-6 sm:px-8 py-5 bg-gradient-to-r from-[#E8674B] to-[#d4573d]">
            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-white/20 text-[#FFF8EF]">
                <i class="fas fa-cart-shopping text-sm"></i>
            </span>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-[#FFF8EF] leading-tight">Bazar Amount</h2>
                    <p class="text-xs text-[#FFF8EF]/70">Spending, meal expense &amp; who owes what</p>
                </div>
            </div>

            <div class="px-6 sm:px-8 pt-5 text-center">
                <a href="{{ route('bazar.report', \Carbon\Carbon::parse($date)->format('Y-m') ) }}" onclick="generateBazarReport()"
                   class="inline-flex items-center gap-2 text-sm font-semibold bg-[#123328] hover:bg-[#1B4536] text-[#FFF8EF] px-5 py-2.5 rounded-full shadow-md shadow-black/10 transition-colors">
                    <i class="fas fa-file-pdf"></i>Generate Bazar Report
                </a>
            </div>

            <div class="overflow-x-auto p-6 sm:p-8 pt-5">
                <table class="w-full text-sm rounded-xl overflow-hidden border border-[#20291F]/10">
                    <thead>
                    <tr class="text-center text-[11px] uppercase tracking-wide text-[#20291F]/40 bg-[#FBF9F4] border-b border-[#20291F]/5">
                        <th class="px-4 py-3 font-semibold text-left">Date</th>
                        @foreach ($members as $member)
                            <th class="px-4 py-3 font-semibold">{{ ucfirst($member->name) }}</th>
                        @endforeach
                        <th class="px-4 py-3 font-semibold">Action</th>
                    </tr>
                    </thead>
                    <tbody id="bazarTableBody" class="divide-y divide-[#20291F]/5">
                    @if (!empty($bazars))
                        @foreach ($bazars as $date => $bazarCollection)
                            <tr class="text-center hover:bg-[#FBF9F4] transition-colors">
                                <td class="px-4 py-2.5 text-left font-medium text-[#20291F]">{{ $date }}</td>
                                @foreach ($members as $member)
                                    @php
                                        $bazar = $bazarCollection->firstWhere('member_name', $member->name);
                                    @endphp
                                    <td class="px-4 py-2.5 text-[#20291F]/70">{{ $bazar->amount ?? 0 }}</td>
                                @endforeach
                                <td class="px-4 py-2.5">
                                    <button class="bazar-edit inline-flex items-center gap-1.5 text-xs font-semibold bg-[#F2A65A]/15 hover:bg-[#F2A65A] hover:text-white text-[#9a6323] px-3 py-1.5 rounded-full transition-colors" data-bazar-date="{{ $date }}">
                                        <i class="fas fa-pen text-[10px]"></i>Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="text-center bg-[#FBF9F4]">
                            <td class="px-4 py-3 text-left">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#123328] text-[#FFF8EF] px-3 py-1 rounded-full">Total</span>
                            </td>
                            @foreach ($members as $member)
                                <td class="px-4 py-3">
                                    <span class="custom-badge inline-flex items-center text-xs font-semibold bg-[#9CC5A1]/25 text-[#123328] px-3 py-1 rounded-full">{{ $member->bazar_sum_amount ?? 0 }}</span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#F2A65A] text-[#123328] px-3 py-1 rounded-full">{{ $members->sum('bazar_sum_amount') }}</span>
                            </td>
                        </tr>

                        {{-- Expense Row --}}
                        <tr class="text-center">
                            <td class="px-4 py-3 text-left">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#123328] text-[#FFF8EF] px-3 py-1 rounded-full">Expense</span>
                            </td>
                            @php $totalExpense = 0; @endphp
                            @foreach ($members as $member)
                                @php
                                    $memberMeals = $member->meals_sum_meal_count ?? 0;
                                    $memberExpense = $meal_rate > 0 && $memberMeals > 0
                                        ? $memberMeals * $meal_rate
                                        : 0;
                                    $totalExpense += $memberExpense;
                                @endphp
                                <td class="px-4 py-3">
                                    <span class="custom-badge inline-flex items-center text-xs font-semibold bg-[#20291F]/10 text-[#20291F]/70 px-3 py-1 rounded-full">{{ $memberExpense }}</span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#F2A65A] text-[#123328] px-3 py-1 rounded-full">{{ $totalExpense }}</span>
                            </td>
                        </tr>

                        {{-- Due/Pay Row --}}
                        <tr class="text-center bg-[#FBF9F4]">
                            <td class="px-4 py-3 text-left">
                                <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#123328] text-[#FFF8EF] px-3 py-1 rounded-full">Due/Pay</span>
                            </td>
                            @php
                                $totalGive = 0;
                                $totalTake = 0;
                            @endphp
                            @foreach ($members as $member)
                                @php
                                    $memberMeals = $member->meals_sum_meal_count ?? 0;
                                    $memberExpense = $meal_rate > 0 && $memberMeals > 0
                                        ? $memberMeals * $meal_rate
                                        : 0;
                                    $duePay = $member->bazar_sum_amount - $memberExpense;
                                    if ($duePay > 0) {
                                        $totalGive += abs($duePay);
                                    } else {
                                        $totalTake += abs($duePay);
                                    }
                                @endphp
                                <td class="px-4 py-3">
                                    <span class="custom-badge inline-flex items-center text-xs font-semibold {{ $duePay > 0 ? 'bg-[#9CC5A1]/25 text-[#123328]' : 'bg-[#E8674B]/15 text-[#E8674B]' }} px-3 py-1 rounded-full">
                                        {{ number_format(abs($duePay), 1) }}
                                    </span>
                                </td>
                            @endforeach
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                    <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#9CC5A1]/25 text-[#123328] px-2.5 py-1 rounded-full">{{ $totalGive }}</span>
                                    <span class="custom-badge inline-flex items-center text-xs font-bold bg-[#E8674B]/15 text-[#E8674B] px-2.5 py-1 rounded-full">{{ $totalTake }}</span>
                                </div>
                            </td>
                        </tr>

                    @else
                        <tr class="text-center">
                            <td colspan="{{ count($members) + 2 }}">
                                <div class="py-10">
                                    <i class="fas fa-cart-shopping text-3xl text-[#E8674B]/40 mb-2 block"></i>
                                    <p class="text-[#20291F]/40 font-medium">No Bazar found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly History Selector -->
        <div class="rounded-2xl bg-white shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden">
            <div class="flex items-center gap-3 px-6 sm:px-8 py-5 bg-[#FBF9F4] border-b border-[#20291F]/5">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#123328]/10 text-[#123328]">
                <i class="fas fa-clock-rotate-left text-xs"></i>
            </span>
                <h5 class="text-sm font-bold text-[#20291F]">Monthly History</h5>
            </div>
            <div class="p-6 flex flex-wrap gap-2">
                @php
                    $currentMonth = \Carbon\Carbon::parse(date('Y-m'))->format('Y-m');
                @endphp
                @foreach ($months as $month)
                    <a href="{{ route('meal.history', $month->month_value) }}"
                       class="text-sm font-semibold px-4 py-2 rounded-full transition-colors {{ $month->month_value == $currentMonth ? 'bg-[#F2A65A] text-[#123328]' : 'bg-[#9CC5A1]/20 text-[#123328] hover:bg-[#9CC5A1]/35' }}">
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
                            html+=`<div class="row flex flex-wrap items-center gap-3 mb-3 text-left">
                                             <div class="col-md-3 w-full sm:w-[28%]">
                                                 <label class="text-sm font-semibold text-[#20291F] capitalize">${item.member_name}</label>
                                             </div>
                                             <div class="col-md-3 w-[47%] sm:w-[28%]">
                                                 <input min="0" value="${item.meal_count}" type="number" class="form-control update_meal w-full px-3 py-2 rounded-lg border border-[#20291F]/15 bg-[#FBF9F4] text-[#20291F] text-sm focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent" data-meal-id="${item.id}" step="any" name="${item.member_name}">
                                            </div>
                                             <div class="col-md-4 w-[47%] sm:w-[36%]">
                                                 <input readonly value="${item.meal_date}" type="date" class="form-control w-full px-3 py-2 rounded-lg border border-[#20291F]/10 bg-[#20291F]/5 text-[#20291F]/60 text-sm">
                                            </div>
                                       </div>`;
                        });

                        Swal.fire({
                            html: html,
                            title: 'Meal Edit!',
                        }).then(()=>{
                            // form.trigger('reset');
                            window.location.href = '/';
                        });
                    }
                });
            });
            $(document).on('change', '.update_meal', function() {
                let mealId = $(this).data("mealId");
                let mealCount = $(this).val();
                let mealDate = $(this).closest('.row').find('input[type="date"]').val();
                console.log(mealId);

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

            ///bazar edit
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
                console.log('Fetching bazar for date:', bazar_date);
                $.ajax({
                    url: '/get-bazar/' + bazar_date,
                    type: 'get',
                    success: function (data) {
                        Swal.close();
                        console.log(data)
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
                            html += `<div class="row flex flex-wrap items-center gap-3 mb-3 text-left">
                                        <div class="col-md-3 w-full sm:w-[28%]">
                                            <label class="text-sm font-semibold text-[#20291F] capitalize">${item.member_name || 'Unknown'}</label>
                                        </div>
                                        <div class="col-md-3 w-[47%] sm:w-[28%]">
                                            <input min="0" value="${item.amount || 0}" type="number" class="form-control update_bazar w-full px-3 py-2 rounded-lg border border-[#20291F]/15 bg-[#FBF9F4] text-[#20291F] text-sm focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent" data-bazar-id="${item.id}" step="any" name="${item.member_name || 'unknown'}">
                                        </div>
                                        <div class="col-md-4 w-[47%] sm:w-[36%]">
                                            <input readonly value="${item.bazar_amt_date}" type="date" class="form-control w-full px-3 py-2 rounded-lg border border-[#20291F]/10 bg-[#20291F]/5 text-[#20291F]/60 text-sm">
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
                let bazarDate = $(this).closest('.row').find('input[type="date"]').val();
                console.log(bazarId);

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
