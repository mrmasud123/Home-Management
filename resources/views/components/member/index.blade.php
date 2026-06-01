@extends('layout')


@section('content')
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add New Member</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('members.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" id="member_id" name="member_id" value="{{ old('member_id') }}">

                                        <label for="name" class="form-label">Member Name *</label>
                                        <input value="{{ old('name') }}" type="text" class="form-control @error('name')
                                            is-invalid
                                        @enderror" id="name" name="name"  placeholder="Enter full name">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input value="{{ old('email') }}" type="email" class="form-control @error('email')
                                            is-invalid
                                        @enderror" id="email" name="email" placeholder="example@email.com">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status </label>
                                        <select value="{{ old('status') }}" class="form-select @error('status')
                                            is-invalid
                                        @enderror" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('member_status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="joined_date" class="form-label">Join Date </label>
                                        <input value="{{ old('joined_date') }}" type="date" class="form-control @error('joined_date')
                                            is-invalid
                                        @enderror" id="joined_date" name="joined_date">
                                        @error('joined_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="seat_rent" class="form-label">Seat Rent</label>
                                        <input value="{{ old('seat_rent') }}" type="number" min="0" class="form-control @error('seat_rent')
                                            is-invalid
                                        @enderror" id="seat_rent" name="seat_rent">
                                        @error('seat_rent')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button id="member_btn" type="submit" name="action_type" value="{{ old('action_type') ?? 'create' }}" class="btn-sm btn btn-success btn-lg">
                                        <i class="fas fa-save me-2"></i>{{ old('action_type')?? 'create' }} Member
                                    </button>
                                    <button type="reset" class="btn-sm btn btn-outline-secondary btn-lg ms-2">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Current Members Section -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Current Members</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Join Date</th>
                                            <th>Status</th>
                                            <th>Seat Rent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            
                                            <tr class="text-center">
                                                <td>{{ $member->id }}</td>
                                                <td class="text-capitalize">{{ $member->name }}</td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ $member->joined_date }}</td>
                                                <td>
                                                    @if ($member->status ==1)
                                                        <span class="fs-6 p-1 badge bg-success">Active</span>
                                                    @else
                                                        <span class="fs-6 p-1 badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $member->seat_rent ?? 0 }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" 
                                                    data-member-id="{{ $member->id }}"
                                                    class="btn btn-sm btn-warning me-1 edit-member">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" 
                                                    onclick="return alert('Under Develop')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Statistics -->
                <div class="mt-4">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-md-3 mb-3">
                            <div class="card text-center bg-success text-white">
                                <div class="card-body">
                                    <h3 class="fw-bold">{{ $members->where('status', 1)->count() }}</h3>
                                    <p class="mb-0">Active Members</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center  text-white">
                                <div class="card shadow-sm">
                                    
                                    <div class="card-body">
                                        @if ($inActiveMembers->count() > 0)
                                            <ul class="list-group">
                                                @foreach ($inActiveMembers as $inActiveMember)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $inActiveMember->name }}</h6>
                                                            <small class="text-muted">Member ID: {{ $inActiveMember->id }}</small>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input 
                                                                class="form-check-input status-toggle" 
                                                                type="checkbox" 
                                                                data-id="{{ $inActiveMember->id }}">
                                                            <label class="form-check-label">Activate</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-center py-4">
                                                <h5 class="fw-bold text-muted">No Inactive Members</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center bg-info text-white">
                                <div class="card-body">
                                    <h3 class="fw-bold">{{ $members->count() }}</h3>
                                    <p class="mb-0">Total Members</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).ready(function() {
    $(".edit-member").on("click", function(e) {
        e.preventDefault();

        let memberId = $(this).data("member-id");
        Swal.fire({
                title: 'Fetching Member...',
                text: 'Please wait while we load the data.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        $.ajax({
            url: "/members/" + memberId,
            type: "GET",
            success: function(member) {
                if(member){
                    Swal.close();

                    $("#name").val(member.name);
                    $("#email").val(member.email);
                    $("#joined_date").val(member.joined_date);
                    $("#status").val(member.status);
                    $("#seat_rent").val(member.seat_rent);
                    $("#member_btn").val('update');
                    $("#member_id").val(member.id);

                    $("#member_btn").html('<i class="fa fa-save me-2"></i>Update');
                    $('html, body').animate({scrollTop: 300}, 'slow');
                }

            },
            error: function(xhr) {
                alert("Failed to fetch member data.");
            }
        });
    });

    $('.status-toggle').on('change', function() {
        const checkbox = $(this);
        const memberId = checkbox.data('id');
        const isActive = checkbox.is(':checked') ? 1 : 0;

        $.ajax({
            url: `/members/update-status/${memberId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: isActive
            },
            success: function(response) {
                if (response.success) {
                    if (isActive === 1) {
                        checkbox.closest('li').fadeOut(400, function() {
                            $(this).remove();
                        });
                    }

                    // Optional alert/toast
                    console.log('Status updated successfully');
                } else {
                    alert('Failed to update status.');
                    checkbox.prop('checked', !isActive); 
                }
            },
            error: function() {
                alert('An error occurred while updating the status.');
                checkbox.prop('checked', !isActive); // revert change
            }
        });
    });
});
</script>
@endsection
