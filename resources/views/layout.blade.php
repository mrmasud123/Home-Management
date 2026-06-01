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
                        
                    </div>
                </div>                
                @yield('content')              
            </div>
        </div>
    </div>
{{-- 
    <!-- Member Management Modal -->
    <div class="modal fade" id="memberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-users me-2"></i>Manage Members</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newMemberName" class="form-label">Add New Member</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="newMemberName" placeholder="Member name">
                            <button class="btn btn-success" onclick="addMember()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <h6>Current Members:</h6>
                    <div id="membersList" class="list-group">
                        <!-- Members will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Meal Modal -->
    <div class="modal fade" id="addMealModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-utensils me-2"></i>Add Daily Meal Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="mealForm">
                        <div class="mb-3">
                            <label for="mealDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="mealDate" required>
                        </div>
                        <div id="memberMealInputs">
                            <!-- Member meal inputs will be generated here -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" onclick="saveDailyMeals()">Save Meals</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bazar Modal -->
    <div class="modal fade" id="addBazarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Add Daily Bazar Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="bazarForm">
                        <div class="mb-3">
                            <label for="bazarDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="bazarDate" required>
                        </div>
                        <div id="memberBazarInputs">
                            <!-- Member bazar inputs will be generated here -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" onclick="saveDailyBazar()">Save Bazar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <!-- Edit form will be populated here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom" id="saveEditBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastMessage" class="toast" role="alert">
            <div class="toast-header">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastBody">
                Record saved successfully!
            </div>
        </div>
    </div> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (latest) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')

    {{-- <script>
        // Data storage
        let members = ['John', 'Alex', 'Mike', 'David']; // Sample members
        let millRecords = {}; // Date -> {member: count}
        let bazarRecords = {}; // Date -> {member: amount}
        let monthlyHistory = {};

        // Initialize app
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('mealDate').value = today;
            document.getElementById('bazarDate').value = today;
            
            loadSampleData();
            updateCurrentMonth();
            generateMemberInputs();
            updateTables();
            updateCalculations();
            populateHistoryMonths();
        });

        // Load sample data
        function loadSampleData() {
            // Sample mill records
            millRecords = {
                '2025-09-01': {'John': 3, 'Alex': 2, 'Mike': 3, 'David': 2},
                '2025-08-30': {'John': 2, 'Alex': 3, 'Mike': 2, 'David': 3},
                '2025-08-29': {'John': 3, 'Alex': 1, 'Mike': 3, 'David': 2}
            };

            // Sample bazar records  
            bazarRecords = {
                '2025-09-01': {'John': 500, 'Alex': 0, 'Mike': 0, 'David': 0},
                '2025-08-30': {'John': 0, 'Alex': 800, 'Mike': 0, 'David': 0},
                '2025-08-29': {'John': 0, 'Alex': 0, 'Mike': 600, 'David': 0}
            };
        }

        // Update current month display
        function updateCurrentMonth() {
            const now = new Date();
            const monthName = now.toLocaleString('default', { month: 'long', year: 'numeric' });
            document.getElementById('currentMonth').textContent = monthName;
        }

        // Add new member
        function addMember() {
            const memberName = document.getElementById('newMemberName').value.trim();
            if (memberName && !members.includes(memberName)) {
                members.push(memberName);
                document.getElementById('newMemberName').value = '';
                updateMembersList();
                generateMemberInputs();
                updateTables();
                showToast(`Member "${memberName}" added successfully!`);
            }
        }

        // Remove member
        function removeMember(memberName) {
            members = members.filter(m => m !== memberName);
            updateMembersList();
            generateMemberInputs();
            updateTables();
            showToast(`Member "${memberName}" removed!`);
        }

        // Update members list
        function updateMembersList() {
            const container = document.getElementById('membersList');
            container.innerHTML = members.map(member => `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-capitalize">${member}</span>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeMember('${member}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');
        }

        // Generate member input fields
        function generateMemberInputs() {
            const mealContainer = document.getElementById('memberMealInputs');
            const bazarContainer = document.getElementById('memberBazarInputs');
            
            const mealInputs = members.map(member => `
                <div class="member-input">
                    <label class="form-label text-capitalize fw-bold">${member}</label>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Meal Count</label>
                            <input type="number" class="form-control" id="meal_${member}" min="0" max="10" value="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Notes</label>
                            <input type="text" class="form-control" id="meal_notes_${member}" placeholder="Optional">
                        </div>
                    </div>
                </div>
            `).join('');

            const bazarInputs = members.map(member => `
                <div class="member-input">
                    <label class="form-label text-capitalize fw-bold">${member}</label>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Amount (৳)</label>
                            <input type="number" class="form-control" id="bazar_${member}" step="0.01" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Items</label>
                            <input type="text" class="form-control" id="bazar_items_${member}" placeholder="Items bought">
                        </div>
                    </div>
                </div>
            `).join('');

            mealContainer.innerHTML = mealInputs;
            bazarContainer.innerHTML = bazarInputs;
            updateMembersList();
        }

        // Save daily meals
        function saveDailyMeals() {
            const date = document.getElementById('mealDate').value;
            if (!date) return;

            const dayRecord = {};
            let hasData = false;

            members.forEach(member => {
                const mealCount = parseInt(document.getElementById(`meal_${member}`).value) || 0;
                dayRecord[member] = mealCount;
                if (mealCount > 0) hasData = true;
            });

            if (!hasData) {
                showToast('Please enter at least one meal count!', 'warning');
                return;
            }

            millRecords[date] = dayRecord;
            saveToMonthlyHistory(date, 'mill');
            updateTables();
            updateCalculations();
            
            bootstrap.Modal.getInstance(document.getElementById('addMealModal')).hide();
            document.getElementById('mealForm').reset();
            members.forEach(member => {
                document.getElementById(`meal_${member}`).value = 0;
            });
            
            showToast('Daily meal record saved successfully!');
        }

        // Save daily bazar
        function saveDailyBazar() {
            const date = document.getElementById('bazarDate').value;
            if (!date) return;

            const dayRecord = {};
            let hasData = false;

            members.forEach(member => {
                const amount = parseFloat(document.getElementById(`bazar_${member}`).value) || 0;
                dayRecord[member] = amount;
                if (amount > 0) hasData = true;
            });

            if (!hasData) {
                showToast('Please enter at least one bazar amount!', 'warning');
                return;
            }

            bazarRecords[date] = dayRecord;
            saveToMonthlyHistory(date, 'bazar');
            updateTables();
            updateCalculations();
            
            bootstrap.Modal.getInstance(document.getElementById('addBazarModal')).hide();
            document.getElementById('bazarForm').reset();
            members.forEach(member => {
                document.getElementById(`bazar_${member}`).value = 0;
            });
            
            showToast('Daily bazar record saved successfully!');
        }

        // Update tables
        function updateTables() {
            updateMillTable();
            updateBazarTable();
        }

        // Update mill table
        function updateMillTable() {
            const headerContainer = document.querySelector('#millTableBody').closest('table').querySelector('thead tr');
            const bodyContainer = document.getElementById('millTableBody');
            
            // Update headers
            const headers = '<th>Date</th>' + 
                members.map(member => `<th class="text-capitalize">${member}</th>`).join('') + 
                '<th>Action</th>';
            headerContainer.innerHTML = headers;

            // Get current month records
            const currentMonth = new Date().toISOString().slice(0, 7);
            const currentMonthRecords = Object.keys(millRecords)
                .filter(date => date.startsWith(currentMonth))
                .sort();

            if (currentMonthRecords.length === 0) {
                bodyContainer.innerHTML = `
                    <tr class="text-center">
                        <td colspan="${members.length + 2}">
                            <div class="py-4">
                                <i class="fas fa-utensils fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Add meals to view details</p>
                            </div>
                        </td>
                    </tr>`;
                return;
            }

            // Generate table rows
            const rows = currentMonthRecords.map(date => {
                const record = millRecords[date];
                const memberCells = members.map(member => `<td>${record[member] || 0}</td>`).join('');
                return `
                    <tr class="text-center">
                        <td>${formatDate(date)}</td>
                        ${memberCells}
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="editRecord('${date}', 'mill')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>`;
            }).join('');

            // Generate totals row
            const totals = members.map(member => {
                const total = currentMonthRecords.reduce((sum, date) => 
                    sum + (millRecords[date][member] || 0), 0);
                return `<td><strong><span class="badge bg-success">${total}</span></strong></td>`;
            }).join('');

            const totalMill = currentMonthRecords.reduce((sum, date) => 
                sum + Object.values(millRecords[date]).reduce((s, v) => s + v, 0), 0);

            bodyContainer.innerHTML = rows + `
                <tr class="text-center bg-success">
                    <td><strong>Total</strong></td>
                    ${totals}
                    <td><button class="btn btn-sm btn-warning text-dark">${totalMill}</button></td>
                </tr>`;
        }

        // Update bazar table
        function updateBazarTable() {
            const headerContainer = document.querySelector('#bazarTableBody').closest('table').querySelector('thead tr');
            const bodyContainer = document.getElementById('bazarTableBody');
            
            // Update headers
            const headers = '<th>Date</th>' + 
                members.map(member => `<th class="text-capitalize">${member}</th>`).join('') + 
                '<th>Action</th>';
            headerContainer.innerHTML = headers;

            // Get current month records
            const currentMonth = new Date().toISOString().slice(0, 7);
            const currentMonthRecords = Object.keys(bazarRecords)
                .filter(date => date.startsWith(currentMonth))
                .sort();

            if (currentMonthRecords.length === 0) {
                bodyContainer.innerHTML = `
                    <tr class="text-center">
                        <td colspan="${members.length + 2}">
                            <div class="py-4">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Add bazar records to view details</p>
                            </div>
                        </td>
                    </tr>`;
                return;
            }

            // Generate table rows
            const rows = currentMonthRecords.map(date => {
                const record = bazarRecords[date];
                const memberCells = members.map(member => `<td>৳${record[member] || 0}</td>`).join('');
                return `
                    <tr class="text-center">
                        <td>${formatDate(date)}</td>
                        ${memberCells}
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="editRecord('${date}', 'bazar')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>`;
            }).join('');

            // Generate totals and calculations
            const memberTotals = members.map(member => {
                const total = currentMonthRecords.reduce((sum, date) => 
                    sum + (bazarRecords[date][member] || 0), 0);
                return total;
            });

            const memberMillTotals = members.map(member => {
                const total = Object.keys(millRecords)
                    .filter(date => date.startsWith(currentMonth))
                    .reduce((sum, date) => sum + (millRecords[date][member] || 0), 0);
                return total;
            });

            const totalBazarAmount = memberTotals.reduce((sum, amount) => sum + amount, 0);
            const totalMillCount = memberMillTotals.reduce((sum, count) => sum + count, 0);
            const millRate = totalMillCount > 0 ? (totalBazarAmount / totalMillCount) : 0;

            const totalsRow = members.map((member, index) => 
                `<td><strong><span class="badge bg-primary">৳${memberTotals[index]}</span></strong></td>`
            ).join('');

            const expenseRow = members.map((member, index) => 
                `<td><strong><span class="badge bg-secondary">৳${(memberMillTotals[index] * millRate).toFixed(1)}</span></strong></td>`
            ).join('');

            const duePayRow = members.map((member, index) => {
                const result = memberTotals[index] - (memberMillTotals[index] * millRate);
                const badgeClass = result >= 0 ? 'bg-success' : 'bg-danger';
                return `<td><strong><span class="badge ${badgeClass}">৳${result.toFixed(1)}</span></strong></td>`;
            }). --}}