@extends('layout')

@section('content')

    <div class="space-y-6">

        {{-- Success flash --}}
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl bg-[#9CC5A1]/25 border border-[#9CC5A1] text-[#123328] px-4 py-3">
                <i class="fas fa-circle-check text-[#1B4536]"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ================= Add / Edit Member ================= --}}
        @if($admin)


        <div class="relative overflow-hidden rounded-2xl bg-white shadow-sm shadow-black/5 border border-[#20291F]/5">

            {{-- decorative food-bowl watermark --}}
            <i class="fas fa-bowl-food absolute -right-6 -bottom-8 text-[110px] text-[#9CC5A1]/10 rotate-12 pointer-events-none"></i>

            <div class="flex items-center gap-3 px-6 sm:px-8 py-5 bg-gradient-to-r from-[#123328] to-[#1B4536] text-[#FFF8EF]">
                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#E8674B]">
                    <i class="fas fa-user-plus text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold leading-tight">Add New Member</h2>
                    <p class="text-xs text-[#FFF8EF]/60">Add a flatmate and set their seat rent</p>
                </div>
            </div>

            <form action="{{ route('members.store') }}" method="POST" class="relative z-10 px-6 sm:px-8 py-6">
                @csrf
                <input type="hidden" id="member_id" name="member_id" value="{{ old('member_id') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label for="name" class="block text-sm font-semibold text-[#20291F]/80 mb-1.5">Member Name *</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-[#20291F]/30 text-sm"></i>
                            <input value="{{ old('name') }}" type="text" id="name" name="name"
                                   placeholder="Enter full name"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('name') border-[#E8674B] @else border-[#20291F]/10 @enderror bg-[#FBF9F4] text-[#20291F] placeholder:text-[#20291F]/30 focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition">
                        </div>
                        @error('name')
                        <p class="mt-1.5 text-xs font-medium text-[#E8674B]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-[#20291F]/80 mb-1.5">Email Address</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-[#20291F]/30 text-sm"></i>
                            <input value="{{ old('email') }}" type="email" id="email" name="email"
                                   placeholder="example@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('email') border-[#E8674B] @else border-[#20291F]/10 @enderror bg-[#FBF9F4] text-[#20291F] placeholder:text-[#20291F]/30 focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition">
                        </div>
                        @error('email')
                        <p class="mt-1.5 text-xs font-medium text-[#E8674B]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-[#20291F]/80 mb-1.5">Status</label>
                        <div class="relative">
                            <i class="fas fa-toggle-on absolute left-3.5 top-1/2 -translate-y-1/2 text-[#20291F]/30 text-sm"></i>
                            <select id="status" name="status"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('status') border-[#E8674B] @else border-[#20291F]/10 @enderror bg-[#FBF9F4] text-[#20291F] appearance-none focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition">
                                <option value="">Select Status</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[#20291F]/30 text-xs pointer-events-none"></i>
                        </div>
                        @error('member_status')
                        <p class="mt-1.5 text-xs font-medium text-[#E8674B]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="joined_date" class="block text-sm font-semibold text-[#20291F]/80 mb-1.5">Join Date</label>
                        <div class="relative">
                            <i class="fas fa-calendar-days absolute left-3.5 top-1/2 -translate-y-1/2 text-[#20291F]/30 text-sm"></i>
                            <input value="{{ old('joined_date') }}" type="date" id="joined_date" name="joined_date"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('joined_date') border-[#E8674B] @else border-[#20291F]/10 @enderror bg-[#FBF9F4] text-[#20291F] focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition">
                        </div>
                        @error('joined_date')
                        <p class="mt-1.5 text-xs font-medium text-[#E8674B]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seat_rent" class="block text-sm font-semibold text-[#20291F]/80 mb-1.5">Seat Rent</label>
                        <div class="relative">
                            <i class="fas fa-bangladeshi-taka-sign absolute left-3.5 top-1/2 -translate-y-1/2 text-[#20291F]/30 text-sm"></i>
                            <input value="{{ old('seat_rent') }}" type="number" step="any" min="0" id="seat_rent" name="seat_rent"
                                   placeholder="0.00"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('seat_rent') border-[#E8674B] @else border-[#20291F]/10 @enderror bg-[#FBF9F4] text-[#20291F] placeholder:text-[#20291F]/30 focus:outline-none focus:ring-2 focus:ring-[#9CC5A1] focus:border-transparent transition">
                        </div>
                        @error('seat_rent')
                        <p class="mt-1.5 text-xs font-medium text-[#E8674B]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3 mt-7">
                    <button id="member_btn" type="submit" name="action_type" value="{{ old('action_type') ?? 'create' }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold bg-[#E8674B] hover:bg-[#d4573d] text-[#FFF8EF] px-6 py-2.5 rounded-full shadow-md shadow-[#E8674B]/20 transition-colors capitalize">
                        <i class="fas fa-floppy-disk"></i>{{ old('action_type') ?? 'create' }} Member
                    </button>
                    <button type="reset"
                            class="inline-flex items-center gap-2 text-sm font-semibold bg-[#20291F]/5 hover:bg-[#20291F]/10 text-[#20291F]/70 px-6 py-2.5 rounded-full transition-colors">
                        <i class="fas fa-rotate-left"></i>Reset
                    </button>
                </div>
            </form>
        </div>
        @endif
        {{-- ================= Current Members ================= --}}
        <div class="rounded-2xl bg-white shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden">

            <div class="flex items-center gap-3 px-6 sm:px-8 py-5 bg-gradient-to-r from-[#123328] to-[#1B4536] text-[#FFF8EF]">
                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#9CC5A1] text-[#123328]">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold leading-tight">Current Members</h2>
                    <p class="text-xs text-[#FFF8EF]/60">Everyone sharing the flat right now</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="text-left text-[11px] uppercase tracking-wide text-[#20291F]/40 border-b border-[#20291F]/5">
                        <th class="px-6 py-3 font-semibold">Member</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Join Date</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        @if($admin)
                            <th class="px-6 py-3 font-semibold">Seat Rent</th>
                            <th class="px-6 py-3 font-semibold text-right">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#20291F]/5">
                    @forelse ($members as $member)
                        @php
                            $initials = collect(explode(' ', $member->name))->map(fn($p) => strtoupper(substr($p, 0, 1)))->take(2)->implode('');
                            $palette = ['#E8674B', '#9CC5A1', '#F2A65A', '#1B4536'];
                            $avatarColor = $palette[$member->id % count($palette)];
                        @endphp
                        <tr class="hover:bg-[#FBF9F4] transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-bold text-[#FFF8EF] shrink-0"
                                         style="background-color: {{ $avatarColor }}">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-[#20291F] capitalize leading-tight">{{ $member->name }}</p>
                                        <p class="text-[11px] text-[#20291F]/40">ID #{{ $member->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-[#20291F]/70">{{ $member->email ?? '—' }}</td>
                            <td class="px-6 py-3.5 text-[#20291F]/70">{{ $member->joined_date ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                @if ($member->status == 1)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-[#9CC5A1]/25 text-[#123328] px-3 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#1B4536]"></span>Active
                                        </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-[#E8674B]/10 text-[#E8674B] px-3 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#E8674B]"></span>Inactive
                                        </span>
                                @endif
                            </td>
                            @if($admin)
                            <td class="px-6 py-3.5">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-[#F2A65A]/15 text-[#9a6323] px-2.5 py-1 rounded-full">
                                        <i class="fas fa-bangladeshi-taka-sign text-[10px]"></i>{{ $member->seat_rent ?? 0 }}
                                    </span>
                            </td>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                data-member-id="{{ $member->id }}"
                                                class="edit-member inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#F2A65A]/15 text-[#c07a2a] hover:bg-[#F2A65A] hover:text-white transition-colors"
                                                title="Edit member">
                                            <i class="fas fa-pen text-xs"></i>
                                        </button>
                                        <button type="button"
                                                onclick="return alert('Under Develop')"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#E8674B]/10 text-[#E8674B] hover:bg-[#E8674B] hover:text-white transition-colors"
                                                title="Delete member">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-[#20291F]/40">
                                <i class="fas fa-bowl-food text-3xl mb-2 block"></i>
                                No members added yet
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= Inactive Members + Stats ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Inactive members / reactivate --}}
            <div class="lg:col-span-2 rounded-2xl bg-white shadow-sm shadow-black/5 border border-[#20291F]/5 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 bg-[#FBF9F4] border-b border-[#20291F]/5">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#E8674B]/10 text-[#E8674B]">
                        <i class="fas fa-user-clock text-xs"></i>
                    </div>
                    <h3 class="text-sm font-bold text-[#20291F]">Inactive Members</h3>
                </div>

                <div class="p-4">
                    @if ($inActiveMembers->count() > 0)
                        <ul class="divide-y divide-[#20291F]/5">
                            @foreach ($inActiveMembers as $inActiveMember)
                                <li class="flex items-center justify-between px-2 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#20291F]/5 text-[#20291F]/40 text-xs font-bold">
                                            {{ strtoupper(substr($inActiveMember->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-[#20291F] capitalize leading-tight">{{ $inActiveMember->name }}</p>
                                            <p class="text-[11px] text-[#20291F]/40">Member ID: {{ $inActiveMember->id }}</p>
                                        </div>
                                    </div>

                                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                        <span class="text-xs font-medium text-[#20291F]/60">Activate</span>
                                        <span class="relative inline-block w-10 h-5">
                                            <input type="checkbox" data-id="{{ $inActiveMember->id }}"
                                                   class="status-toggle peer sr-only">
                                            <span class="absolute inset-0 rounded-full bg-[#20291F]/15 peer-checked:bg-[#9CC5A1] transition-colors"></span>
                                            <span class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                                        </span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-mug-hot text-3xl text-[#9CC5A1] mb-2 block"></i>
                            <p class="font-semibold text-[#20291F]/50 text-sm">No inactive members — everyone's in!</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 gap-4">
                <div class="rounded-2xl bg-gradient-to-br from-[#9CC5A1] to-[#7fb186] text-[#123328] p-5 flex items-center gap-4 shadow-sm">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-white/40">
                        <i class="fas fa-user-check text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold leading-none">{{ $members->where('status', 1)->count() }}</h3>
                        <p class="text-xs font-medium opacity-70 mt-1">Active Members</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-[#E8674B] to-[#d4573d] text-[#FFF8EF] p-5 flex items-center gap-4 shadow-sm">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-white/15">
                        <i class="fas fa-user-xmark text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold leading-none">{{ $inActiveMembers->count() }}</h3>
                        <p class="text-xs font-medium opacity-80 mt-1">Inactive Members</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-[#123328] to-[#0B241C] text-[#FFF8EF] p-5 flex items-center gap-4 shadow-sm">
                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-white/10">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold leading-none">{{ $members->count() }}</h3>
                        <p class="text-xs font-medium opacity-70 mt-1">Total Members</p>
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
                        if (member) {
                            Swal.close();

                            $("#name").val(member.name);
                            $("#email").val(member.email);
                            $("#joined_date").val(member.joined_date);
                            $("#status").val(member.status);
                            $("#seat_rent").val(member.seat_rent);
                            $("#member_id").val(member.id);

                            $("#member_btn").val('update');
                            $("#member_btn").html('<i class="fas fa-floppy-disk"></i>Update Member');
                            $('html, body').animate({ scrollTop: 200 }, 'slow');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to fetch member data.', 'error');
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
                        } else {
                            Swal.fire('Error', 'Failed to update status.', 'error');
                            checkbox.prop('checked', !isActive);
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred while updating the status.', 'error');
                        checkbox.prop('checked', !isActive);
                    }
                });
            });
        });
    </script>
@endsection
