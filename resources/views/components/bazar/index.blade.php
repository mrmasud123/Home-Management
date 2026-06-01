<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bazar Records - Bachelor Flat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .header__style {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .mill-btns .btn {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .mill-btns .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .fixed-header-table {
            max-height: 400px;
            overflow-y: auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
            color: white;
            border: none;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .total-bazar {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .badge {
            font-size: 1.1em;
            padding: 0.6em 1em;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .member-input-row {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #17a2b8;
        }
        
        .expense-breakdown {
            background: linear-gradient(45deg, #fff3cd, #ffeaa7);
            border-radius: 10px;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="mill-header header__style py-4 text-center d-flex align-items-center flex-column">
                    <h1><i class="fas fa-shopping-cart me-3"></i>Bazar Records</h1>
                    <p class="mb-4">Manage Daily Shopping & Market Expenses</p>
                    <div class="mt-3 mill-btns w-75 d-flex align-items-center justify-content-around flex-wrap">
                        <a href="index.php" class="btn btn-sm btn-success mb-2">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                        <a href="meal-records.php" class="btn btn-sm btn-primary mb-2">
                            <i class="fas fa-utensils me-1"></i>Meal Records
                        </a>
                        <a href="bazar-records.php" class="btn btn-sm btn-info mb-2 active">
                            <i class="fas fa-shopping-cart me-1"></i>Bazar Records
                        </a>
                        <a href="manage-members.php" class="btn btn-sm btn-warning mb-2">
                            <i class="fas fa-users me-1"></i>Manage Members
                        </a>
                    </div>
                </div>

                <!-- Add Daily Bazar Section -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add Daily Bazar Record</h5>
                        </div>
                        <div class="card-body">
                            <form action="add_daily_bazar.php" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="bazar_date" class="form-label">Select Date *</label>
                                        <input type="date" class="form-control" id="bazar_date" name="bazar_date" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="market_name" class="form-label">Market/Shop Name</label>
                                        <input type="text" class="form-control" id="market_name" name="market_name" 
                                               placeholder="e.g., New Market, Karwan Bazar">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_amount" class="form-label">Total Amount (৳)</label>
                                        <input type="number" class="form-control" id="total_amount" name="total_amount" 
                                               step="0.01" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3"><i class="fas fa-users me-2"></i>Member-wise Bazar Amounts</h6>
                                
                                <!-- Member Input Rows -->
                                <div class="member-input-row">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-capitalize">John Doe</label>
                                            <small class="text-muted d-block">Room 1</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Amount (৳)</label>
                                            <input type="number" class="form-control" name="john_amount" step="0.01" min="0" value="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Items Purchased</label>
                                            <input type="text" class="form-control" name="john_items" 
                                                   placeholder="e.g., Rice 2kg, Onions 1kg, Oil 1L">
                                        </div>
                                    </div>
                                </div>

                                <div class="member-input-row">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-capitalize">Alex Rahman</label>
                                            <small class="text-muted d-block">Room 2</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Amount (৳)</label>
                                            <input type="number" class="form-control" name="alex_amount" step="0.01" min="0" value="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Items Purchased</label>
                                            <input type="text" class="form-control" name="alex_items" 
                                                   placeholder="e.g., Vegetables, Meat 1kg, Spices">
                                        </div>
                                    </div>
                                </div>

                                <div class="member-input-row">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-capitalize">Mike Ahmed</label>
                                            <small class="text-muted d-block">Room 3</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Amount (৳)</label>
                                            <input type="number" class="form-control" name="mike_amount" step="0.01" min="0" value="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Items Purchased</label>
                                            <input type="text" class="form-control" name="mike_items" 
                                                   placeholder="e.g., Fish 2kg, Dal 1kg, Salt">
                                        </div>
                                    </div>
                                </div>

                                <div class="member-input-row">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-capitalize">David Khan</label>
                                            <small class="text-muted d-block">Room 4 (Inactive)</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Amount (৳)</label>
                                            <input type="number" class="form-control" name="david_amount" step="0.01" min="0" value="0" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Items Purchased</label>
                                            <input type="text" class="form-control" name="david_items" placeholder="Member inactive" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="bazar_notes" class="form-label">Shopping Notes</label>
                                    <textarea class="form-control" id="bazar_notes" name="bazar_notes" rows="2" 
                                              placeholder="Any notes about today's shopping..."></textarea>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-lg">
                                        <i class="fas fa-save me-2"></i>Save Daily Bazar
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary btn-lg ms-2">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Current Month Bazar Summary -->
                <div class="total-bazar mt-4 mb-4">
                    <div class="total-bazar-header d-flex align-items-center justify-content-between mb-3 flex-wrap">
                        <div class="d-flex align-items-center mb-2">
                            <h2 class="me-3">Total Bazar:</h2>
                            <h2><span class="badge bg-info">৳3,500</span></h2>
                        </div>
                        <h5><span class="badge bg-success">Mill Rate: ৳52.2</span></h5>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6>Current Month</h6>
                                <span class="badge bg-primary">September 2025</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6>Shopping Days</h6>
                                <span class="badge bg-warning">8 Days</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6>Avg per Day</h6>
                                <span class="badge bg-secondary">৳437.5</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6>Active Buyers</h6>
                                <span class="badge bg-dark">3 Members</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Bazar Records Table -->
                <div class="money mt-4">
                    <div class="card">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Bazar Amount (Current Month)</h5>
                            <a href="generate-bazar.php?month=September" class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Generate PDF
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-info table-bordered table-hover table-striped mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Date</th>
                                            <th class="text-capitalize">John Doe</th>
                                            <th class="text-capitalize">Alex Rahman</th>
                                            <th class="text-capitalize">Mike Ahmed</th>
                                            <th class="text-capitalize">David Khan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Sample Bazar Data Rows -->
                                        <tr class="text-center">
                                            <td>2025-09-01</td>
                                            <td>৳500</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-09-01">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-30</td>
                                            <td>৳0</td>
                                            <td>৳800</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-30">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-29</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>৳600</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-29">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-28</td>
                                            <td>৳400</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-28">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-27</td>
                                            <td>৳0</td>
                                            <td>৳300</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-27">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-26</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>৳450</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-26">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-25</td>
                                            <td>৳600</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-25">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>2025-08-24</td>
                                            <td>৳0</td>
                                            <td>৳250</td>
                                            <td>৳550</td>
                                            <td>৳0</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit-bazar.php?bdate=2025-08-24">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        
                                        <!-- Total Row -->
                                        <tr class="text-center bg-success">
                                            <td><strong>Total</strong></td>
                                            <td><strong><span class="badge bg-primary">৳1,500</span></strong></td>
                                            <td><strong><span class="badge bg-primary">৳1,350</span></strong></td>
                                            <td><strong><span class="badge bg-primary">৳1,600</span></strong></td>
                                            <td><strong><span class="badge bg-primary">৳0</span></strong></td>
                                            <td><strong>৳4,450</strong></td>
                                        </tr>
                                        
                                        <!-- Expense Row -->
                                        <tr class="text-center">
                                            <td><strong>Expense</strong></td>
                                            <td><strong><span class="badge bg-secondary">৳1,305</span></strong></td>
                                            <td><strong><span class="badge bg-secondary">৳1,044</span></strong></td>
                                            <td><strong><span class="badge bg-secondary">৳1,148</span></strong></td>
                                            <td><strong><span class="badge bg-secondary">৳0</span></strong></td>
                                            <td><strong>৳3,497</strong></td>
                                        </tr>
                                        
                                        <!-- Due/Pay Row -->
                                        <tr class="text-center">
                                            <td><strong>Due/Pay</strong></td>
                                            <td><strong><span class="badge bg-success">৳195</span></strong></td>
                                            <td><strong><span class="badge bg-success">৳306</span></strong></td>
                                            <td><strong><span class="badge bg-success">৳452</span></strong></td>
                                            <td><strong><span class="badge bg-secondary">৳0</span></strong></td>
                                            <td class="d-flex justify-content-between">
                                                <div class="give">
                                                    <span class="badge bg-warning">Give</span><br>
                                                    <span class="badge bg-danger">৳0</span>
                                                </div>
                                                |
                                                <div class="take">
                                                    <span class="badge bg-warning">Take</span><br>
                                                    <span class="badge bg-success">৳953</span>
                                                </div>
                                                |
                                                <div class="extra">
                                                    <span class="badge bg-warning">Extra</span><br>
                                                    <span class="badge bg-secondary">৳953</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bazar Analytics -->
                <div class="mt-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-warning text-white">
                                    <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Spending Distribution</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <h4 class="text-primary">34%</h4>
                                            <small class="text-muted">John's Spending</small>
                                        </div>
                                        <div class="col-6 text-center">
                                            <h4 class="text-success">30%</h4>
                                            <small class="text-muted">Alex's Spending</small>
                                        </div>
                                        <div class="col-6 text-center mt-3">
                                            <h4 class="text-info">36%</h4>
                                            <small class="text-muted">Mike's Spending</small>
                                        </div>
                                        <div class="col-6 text-center mt-3">
                                            <h4 class="text-danger">0%</h4>
                                            <small class="text-muted">David's Spending</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-wallet me-2"></i>Payment Status</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>John Doe:</span>
                                                <span class="badge bg-success">Will Get ৳195</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Alex Rahman:</span>
                                                <span class="badge bg-success">Will Get ৳306</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Mike Ahmed:</span>
                                                <span class="badge bg-success">Will Get ৳452</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <span>David Khan:</span>
                                                <span class="badge bg-secondary">Inactive</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category-wise Spending -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-purple text-white" style="background: linear-gradient(45deg, #6f42c1, #e83e8c) !important;">
                            <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Category-wise Spending Analysis</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <i class="fas fa-carrot fa-2x text-success mb-2"></i>
                                            <h6>Vegetables</h6>
                                            <h5 class="text-success">৳1,200</h5>
                                            <small class="text-muted">34.3%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <i class="fas fa-fish fa-2x text-info mb-2"></i>
                                            <h6>Meat & Fish</h6>
                                            <h5 class="text-info">৳950</h5>
                                            <small class="text-muted">27.1%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <i class="fas fa-seedling fa-2x text-warning mb-2"></i>
                                            <h6>Rice & Grains</h6>
                                            <h5 class="text-warning">৳800</h5>
                                            <small class="text-muted">22.9%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <i class="fas fa-pepper-hot fa-2x text-danger mb-2"></i>
                                            <h6>Spices & Others</h6>
                                            <h5 class="text-danger">৳550</h5>
                                            <small class="text-muted">15.7%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fas fa-lightning-bolt me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <form action="add_bulk_bazar.php" method="POST">
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-layer-group me-2"></i>Bulk Add Items
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <form action="split_shared_bazar.php" method="POST">
                                        <button type="submit" class="btn btn-outline-info w-100">
                                            <i class="fas fa-share-alt me-2"></i>Split Shared Bazar
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <form action="calculate_due_pay.php" method="POST">
                                        <button type="submit" class="btn btn-outline-success w-100">
                                            <i class="fas fa-calculator me-2"></i>Calculate Due/Pay
                                        </button>
                                    </form>
                                </div>
                                