@extends('layout')

@section('content')

@if (count($members)>0)
    <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add Daily Meal Record</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" id="mealForm">
                                @csrf
                                <h6 class="mb-3"><i class="fas fa-users me-2"></i>Member Meal Counts</h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="selectAll" name="allMember">
                                    <label class="btn btn-warning btn-sm" for="selectAll">
                                        <i class="fas fa-check me-1"></i> Select All
                                    </label>
                                </div>
                                    <div class="col-md-1 mt-2">
                                            <input type="number" min='0' step="any" class="form-control" placeholder="Meal" name="sameMeal" id="sameMeal">
                                        </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="meal_date" class="form-label">Select Date *</label>
                                        <input type="date" class="form-control" id="meal_date" name="meal_date" required>
                                    </div>
                                </div>
                                <div class="member-input-row">

                                    @foreach ($members as $member)
                                        <div class="row align-items-center mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold text-capitalize">{{ $member->name }}</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input min="0" data-member-id="{{ $member->id }}" type="number" class="form-control" step="any" name="{{ $member->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-sm btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Daily Meals
                                    </button>
                                    <button type="reset" class="btn-sm btn btn-outline-secondary ms-2">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add Bazar Record</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" id="bazarForm">
                                @csrf
                                <h6 class="mb-3"><i class="fas fa-users me-2"></i>Member Bazar Amonuts</h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="selectAllBazarMember" name="selectAllBazarMember">
                                    <label class="btn btn-warning btn-sm" for="selectAllBazarMember">
                                        <i class="fas fa-check me-1"></i> Select All
                                    </label>
                                </div>
                                    <div class="col-md-1 mt-2">
                                            <input type="number" min="0" class="form-control" placeholder="Bazar" name="sameBazar" id="sameBazar">
                                        </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="bazar_date" class="form-label">Select Date *</label>
                                        <input type="date" class="form-control" id="bazar_date" name="bazar_date" required>
                                    </div>
                                </div>
                                <div class="bazar-input-row">

                                    @foreach ($members as $member)
                                        <div class="row align-items-center mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold text-capitalize">{{ $member->name }}</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input min="0" data-member-id="{{ $member->id }}" type="number" class="form-control" step="any" name="{{ $member->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-sm btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Bazar
                                    </button>
                                    <button type="reset" class="btn-sm btn btn-outline-secondary ms-2">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add Daily Meal Record</h5>
                        </div>
                        <div class="card-body">
                            <form id="calculateMonthlyExpense" method="GET">
                                @csrf
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5>Add Monthly Expense</h5>
                                    </div>
                                        {{-- <form action="" id="monthlyExpenseForm"> --}}
                                            <div class="form-group mt-2 mb-2">
                                                <label for="flat_rent" class=" ">ফ্ল্যাট ভাড়া</label>
                                                <input id="flat_rent" name="flat_rent" class="form-control" type="number">
                                            </div>
                                            <hr>
                                            <div class="form-group mt-2 mb-2">
                                                <label for="service_charge" class=" ">সার্ভিস চার্জ</label>
                                                <input id="service_charge" name="service_charge" class="form-control" type="number">
                                            </div>
                                            <hr>
                                            <div class="form-group mt-2 mb-2">
                                                <label for="garbage_charge" class=" ">ময়লা বিল</label>
                                                <input id="garbage_charge" name="garbage_charge" class="form-control" type="number">
                                            </div>
                                            <hr>
                                            <div class="form-group mt-2 mb-2">
                                                <ul>
                                                    @foreach ($members as $member)
                                                        <li class="btn btn-primary list-item">
                                                            <input 
                                                                data-miller-id="{{ $member->id }}" 
                                                                class="mill_member_electricity_check" 
                                                                id="mill_member_electricity{{ $member->id+777 }}" 
                                                                name="electricity_member{{ $member->id+777 }}" 
                                                                type="checkbox">
                                                            <label class="text-capitalize" for="mill_member_electricity{{ $member->id+777 }}">{{ $member->name }}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <label for="electricity_bill" class=" ">বিদ্যূৎ বিল</label>
                                                <input id="electricity_bill" name="electricity_bill" class="form-control" type="number">
                                            </div>
                                            <hr>
                                            <div class="form-group mt-2 mb-2">
                                                <ul>
                                                    @foreach ($members as $member)
                                                        <li class="btn btn-primary list-item">
                                                            <input 
                                                                data-miller-id="{{ $member->id }}" 
                                                                class="mill_member_wifi_check" 
                                                                id="mill_member_wifi{{ $member->id+888 }}" 
                                                                name="wifi_member{{ $member->id+888 }}" 
                                                                type="checkbox">
                                                            <label class="text-capitalize" for="mill_member_wifi{{ $member->id+888 }}">{{ $member->name }}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <label for="wifi_bill" class=" ">ওয়াইফাই বিল</label>
                                                <input id="wifi_bill" name="wifi_bill" class="form-control" type="number">
                                            </div>
                                            <hr>
                                            <div class="form-group mt-2 mb-2">
                                                <label for="gas_bill" class=" ">গ্যাস বিল</label>
                                                <input id="gas_bill" name="gas_bill" class="form-control" type="number">
                                            </div>
                                            <hr>
                                            <div class="form-group mt-2 mb-2">
                                                <ul>
                                                    @foreach ($members as $member)
                                                        <li class="btn btn-primary list-item">
                                                            <input 
                                                                data-miller-id="{{ $member->id }}" 
                                                                class="mill_member_amount_check" 
                                                                id="mill_member{{ $member->id+999 }}" 
                                                                name="khala_member{{ $member->id+999 }}" 
                                                                type="checkbox">
                                                            <label class="text-capitalize" for="mill_member{{ $member->id+999 }}">{{ $member->name }}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <label for="gas_bill" class=" ">খালা বেতন</label>
                                                <input id="gas_bill" name="khala_salary" class="form-control" type="number">
                                            </div>
                                            <button type="submit" class="mt-2 btn btn-warning calclate_expense_btn">হিসাব করুন</button>
                                        </form>
                        </div>
                    </div>
                </div>

                @else
            <div class="mt-4">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('members.index') }}" class="btn btn-sm btn-warning">Add Members?</a>
                    </div>
                </div>
            </div>
               
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>        
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script src="{{ asset('js/script.js') }}"></script>
@endsection