@extends('layout')

@section('content')
@php
    $totalMeals = $members->sum('meals_sum_meal_count');
    $totalBazar = $members->sum('bazar_sum_amount');

    $meal_rate = $totalMeals > 0 
        ? round($totalBazar / $totalMeals, 1) 
        : 0;
@endphp

<div class="mill-contents mt-4">
    <!-- Mill Table -->
    <div class="mill-table mb-5">
        <div class="table-responsive">
            <table class="table table-hover table-info table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Date</th>
                        @foreach ($members as $member)
                            <th>{{ ucfirst($member->name) }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="millTableBody">
                    @if (!empty($meals))
                        @foreach ($meals as $date => $mealCollection)
                            <tr class="text-center">
                                <td>{{ $date }}</td>
                                @foreach ($members as $member)
                                    @php
                                        $meal = $mealCollection->firstWhere('member_name', $member->name);
                                    @endphp
                                    <td>{{ $meal->meal_count ?? 0 }}</td>
                                @endforeach
                                <td>
                                    <button class="btn btn-sm btn-outline-primary meal-edit" data-meal-date="{{ $date }}">Edit</button>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="text-center">
                            <td><span class="custom-badge bg-success">Total</span></td>
                            @foreach ($members as $member)
                                <td>
                                    <span class="custom-badge bg-success">
                                        {{ $member->meals_sum_meal_count ?? 0 }}
                                    </span>
                                </td>
                            @endforeach
                            <td><span class="custom-badge bg-warning">{{ $totalMeals }}</span></td>
                        </tr>
                    @else
                        <tr class="text-center">
                            <td colspan="{{ count($members) + 2 }}">
                                <div class="py-4">
                                    <i class="fas fa-utensils fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No meal found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>

    <!-- Bazar Amount Section -->
    <div class="money">
        <h2 class="mb-4 header__style text-center py-3 text-white" style="border-radius: 15px;">
            <i class="fas fa-shopping-bag me-2"></i>Bazar Amount
        </h2>
        
        <div class="mb-3 text-center">
            <a href="{{ route('bazar.report', \Carbon\Carbon::parse(date('Y-m-d'))->format('Y-m') ) }}" class="btn btn-success" onclick="generateBazarReport()">
                <i class="fas fa-file-pdf me-2"></i>Generate Bazar Report
            </a>
        </div>

        <div class="table-responsive">
           <table class="table table-info table-bordered table-hover table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Date</th>
                        @foreach ($members as $member)
                            <th>{{ ucfirst($member->name) }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bazarTableBody">
                    @if (!empty($bazars))
                        @foreach ($bazars as $date => $bazarCollection)
                            <tr class="text-center">
                                <td>{{ $date }}</td>
                                @foreach ($members as $member)
                                    @php
                                        $bazar = $bazarCollection->firstWhere('member_name', $member->name);
                                    @endphp
                                    <td>{{ $bazar->amount ?? 0 }}</td>
                                @endforeach
                                <td>
                                    <button class="btn btn-sm btn-outline-primary bazar-edit" data-bazar-date="{{ $date }}">Edit</button>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="text-center">
                            <td><span class="custom-badge bg-primary">Total</span></td>
                            @foreach ($members as $member)
                                <td><span class="custom-badge bg-success">{{ $member->bazar_sum_amount ?? 0 }}</span></td>
                            @endforeach
                            <td><span class="custom-badge bg-warning">{{ $members->sum('bazar_sum_amount') }}</span></td>
                        </tr>

                        {{-- Expense Row --}}
                        <tr class="text-center">
                            <td><span class="custom-badge bg-primary">Expense</span></td>
                            @php $totalExpense = 0; @endphp
                            @foreach ($members as $member)
                                @php
                                    $memberMeals = $member->meals_sum_meal_count ?? 0;
                                    $memberExpense = ($meal_rate > 0 && $memberMeals > 0)
                                        ? $memberMeals * $meal_rate
                                        : 0;
                                    $totalExpense += $memberExpense;
                                @endphp
                                <td><span class="custom-badge bg-secondary">{{ number_format($memberExpense, 1) }}</span></td>
                            @endforeach
                            <td><span class="custom-badge bg-warning">{{ number_format($totalExpense, 1) }}</span></td>
                        </tr>

                        {{-- Due/Pay Row --}}
                        <tr class="text-center">
                            <td><span class="custom-badge bg-primary">Due/Pay</span></td>
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
                                <td>
                                    <span class="custom-badge {{ $duePay > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ number_format($duePay, 1) }}
                                    </span>
                                </td>
                            @endforeach
                            <td>
                                <span class="custom-badge bg-success">{{ number_format($totalGive, 1) }}</span>
                                <span class="custom-badge bg-danger">{{ number_format($totalTake, 1) }}</span>
                            </td>
                        </tr>

                    @else
                        <tr class="text-center">
                            <td colspan="{{ count($members) + 2 }}">
                                <div class="py-4">
                                    <i class="fas fa-shopping-bag fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No Bazar found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>

    <!-- Monthly History Selector -->
    <div class="mt-5 mb-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Monthly History</h5>
            </div>
            <div class="card-body">
                @php
                    $currentMonth= \Carbon\Carbon::parse(date('Y-m'))->format('Y-m');
                @endphp
                @foreach ($months as $month)
                   <a href="{{ route('meal.history', $month->month_value) }}" class="btn btn-sm {{ $month->month_value == $currentMonth ? 'bg-warning':'bg-success text-light' }}">{{ $month->month_name }}</a> 
                @endforeach
            </div>
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
                            html+=`<div class="row align-items-center mb-2">
                                             <div class="col-md-3">
                                                 <label class="form-label fw-bold text-capitalize">${item.member_name}</label>
                                             </div>
                                             <div class="col-md-3">
                                                 <input min="0" value="${item.meal_count}" type="number" class="form-control update_meal" data-meal-id="${item.id}" step="any" name="${item.member_name}">
                                            </div>
                                             <div class="col-md-4">
                                                 <input readonly value="${item.meal_date}" type="date" class="form-control">
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
                let mealDate = $(this).closest('.row').find('input[type="date"]').val();
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
                            html += `<div class="row align-items-center mb-2">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-capitalize">${item.member_name || 'Unknown'}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input min="0" value="${item.amount || 0}" type="number" class="form-control update_bazar" data-bazar-id="${item.id}" step="any" name="${item.member_name || 'unknown'}">
                                        </div>
                                        <div class="col-md-4">
                                            <input readonly value="${item.bazar_amt_date}" type="date" class="form-control">
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
