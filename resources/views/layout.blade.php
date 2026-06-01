<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bachelor Flat - Meal Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="mill-header header__style py-4 text-center d-flex align-items-center flex-column">
                    {{-- <div class="header"> --}}
                        <div class="header-left">
                            <h1><i class="fas fa-home me-3"></i>Bachelor Flat</h1>
                            <p class="mb-4">Meal & Bazar Management System</p>
                        </div>
                        <div class="header-right w-75">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h6>Current Month</h6>
                                        <span class="badge bg-primary">{{ $currentMonthFull }} 2025</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h6>Total Bazar Amount</h6>
                                        <span class="badge bg-warning">{{ $members->sum('bazar_sum_amount') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h6>Total Meal</h6>
                                        <span class="badge bg-dark">{{ $members->sum('meals_sum_meal_count') }} meals</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h6>Meal Rate</h6>
                                        @php
                                            $totalMeals = $members->sum('meals_sum_meal_count');
                                            $totalBazar = $members->sum('bazar_sum_amount');

                                            $meal_rate = $totalMeals > 0
                                                ? number_format($totalBazar / $totalMeals,1)
                                                : 0;
                                        @endphp
                                        <span class="badge bg-secondary">{{ $meal_rate }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    {{-- </div> --}}
                    <div class="mt-3 mill-btns w-75 d-flex align-items-center justify-content-around flex-wrap">
                        <a href="{{ route('meal.home') }}" class="btn btn-sm btn-success mb-2">Home</a>
                        <a class="btn btn-sm btn-primary mb-2" href="{{ route('members.index') }}">
                            <i class="fas fa-users me-1"></i>Manage Members
                        </a>
                        <a class="btn btn-sm btn-warning mb-2" href="{{ route('credentials.index') }}">
                            <i class="fas fa-plus me-1"></i>Flat Credentials
                        </a>
                        <a class="btn btn-sm btn-warning mb-2" href="{{ route('ai.chat.index') }}">
                            <i class="fas fa-plus me-1"></i>AI Chat
                        </a>

                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
