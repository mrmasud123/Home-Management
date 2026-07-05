@extends('layout')

@section('content')
    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 bg-[#EFF6F0] border border-[#9CC5A1]/50 text-[#123328] text-sm px-4 py-3 rounded-xl">
                <i class="fas fa-circle-check text-[#0E7C6B]"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Date navigator -->
        <div class="bg-white rounded-2xl border border-[#EFE9DA] shadow-sm p-5">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#F2A65A]/20">
                        <i class="fas fa-basket-shopping text-[#F2A65A]"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-[#123328]">Daily Bazar Entry</h1>
                        <p class="text-xs text-[#9C9282]">Log today's market spending for each member</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button id="prevDay" type="button"
                            class="w-9 h-9 flex items-center justify-center rounded-full border border-[#E3D9C6] text-[#4B4335] hover:bg-[#FBF9F4] transition-colors">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <input type="date" id="entryDate" value="{{ $date }}"
                           class="rounded-lg border border-[#E3D9C6] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]">
                    <button id="nextDay" type="button"
                            class="w-9 h-9 flex items-center justify-center rounded-full border border-[#E3D9C6] text-[#4B4335] hover:bg-[#FBF9F4] transition-colors">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                    <button id="todayBtn" type="button"
                            class="text-sm font-medium text-[#0E7C6B] border border-[#0E7C6B]/30 hover:bg-[#0E7C6B] hover:text-white px-3 py-2 rounded-full transition-colors">
                        Today
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-5">

            <!-- Existing entries for the day -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-[#EFE9DA] shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 bg-[#123328] text-[#FFF8EF]">
                <span class="flex items-center gap-2 text-sm font-semibold">
                    <i class="fas fa-receipt"></i> Logged Today
                </span>
                    <span id="dayTotal" class="text-sm font-bold bg-[#F2A65A] text-[#123328] px-3 py-1 rounded-full">
                    ৳{{ number_format($entries->sum('amount'), 1) }}
                </span>
                </div>

                <ul id="entryList" class="divide-y divide-[#F1ECE0] max-h-[420px] overflow-y-auto">
                    @forelse ($entries as $entry)
                        <li class="flex items-center justify-between px-5 py-3" data-entry-id="{{ $entry->id }}">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#F2A65A]/20 flex items-center justify-center text-[#B5772E] text-xs">
                                    <i class="fas fa-basket-shopping"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-[#123328]">{{ $entry->items ?: 'Bazar entry' }}</p>
                                    <p class="text-xs font-medium text-[#B5772E]">৳{{ number_format($entry->amount, 1) }}</p>
                                </div>
                            </div>
                            <button class="delete-entry w-7 h-7 flex items-center justify-center rounded-full text-[#B4432C] hover:bg-[#E8674B] hover:text-white transition-colors"
                                    data-id="{{ $entry->id }}">
                                <i class="fas fa-xmark text-xs"></i>
                            </button>
                        </li>
                    @empty
                        <li id="emptyState" class="py-10 text-center">
                            <i class="fas fa-cart-flatbed-suitcase text-3xl text-[#E3D9C6] mb-2"></i>
                            <p class="text-sm text-[#9C9282]">No bazar entries yet for this day</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Add entries form -->
            <div class="lg:col-span-3 bg-white rounded-2xl border border-[#EFE9DA] shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-4 bg-[#0E7C6B] text-white">
                    <i class="fas fa-carrot"></i>
                    <h2 class="text-sm font-semibold">Add Bazar Amount</h2>
                </div>

                <form action="{{ route('daily-bazar-entry.submit') }}" method="POST" class="p-5" id="bazarForm">
                    @csrf
                    <input type="hidden" name="bazar_amt_date" id="formDate" value="{{ $date }}">

                    <div id="entryRows" class="space-y-3 mb-4">
                        <div class="entry-row bg-[#FBF9F4] rounded-xl p-3 flex items-center gap-2">
                            <div class="relative flex-[1.4]">
                                <i class="fas fa-basket-shopping absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#9C9282]"></i>
                                <input type="text" placeholder="What was bought? e.g. Rice, vegetables"
                                       name="entries[0][items]"
                                       class="w-full rounded-lg border border-[#E3D9C6] pl-8 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]">
                            </div>

                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#9C9282]">৳</span>
                                <input type="number" step="any" min="0" placeholder="0.00"
                                       name="entries[0][amount]"
                                       class="w-full rounded-lg border border-[#E3D9C6] pl-7 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]">
                            </div>

                            <button type="button" class="remove-row shrink-0 w-8 h-8 flex items-center justify-center rounded-full text-[#B4432C] hover:bg-[#E8674B] hover:text-white transition-colors opacity-0 pointer-events-none">
                                <i class="fas fa-xmark text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <button type="button" id="addRow"
                            class="w-full inline-flex items-center justify-center gap-2 border border-dashed border-[#0E7C6B]/40 text-[#0E7C6B] hover:bg-[#0E7C6B]/5 text-sm font-medium py-2.5 rounded-xl transition-colors mb-5">
                        <i class="fas fa-plus text-xs"></i> Add Another Entry
                    </button>

                    <p class="text-xs text-[#9C9282] mb-4">
                        <i class="fas fa-circle-info mr-1"></i>
                        Each row is one purchase. Add as many rows as you need — for any member, in any order, even the same member twice.
                    </p>

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-[#E8674B] hover:bg-[#D65B3F] text-white text-sm font-semibold py-3 rounded-full transition-colors">
                        <i class="fas fa-plus"></i> Save Bazar Entries
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {

            // Add a new entry row
            let rowIndex = 1;
            $('#addRow').on('click', function () {
                const row = $(`<div class="entry-row bg-[#FBF9F4] rounded-xl p-3 flex items-center gap-2">
                            <div class="relative flex-[1.4]">
                                <i class="fas fa-basket-shopping absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#9C9282]"></i>
                                <input type="text" placeholder="What was bought? e.g. Rice, vegetables"
                                       name="entries[${rowIndex}][items]"
                                       class="w-full rounded-lg border border-[#E3D9C6] pl-8 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]">
                            </div>

                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#9C9282]">৳</span>
                                <input type="number" step="any" min="0" placeholder="0.00"
                                       name="entries[${rowIndex}][amount]"
                                       class="w-full rounded-lg border border-[#E3D9C6] pl-7 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C6B]/20 focus:border-[#0E7C6B]">
                            </div>

                            <button type="button" class="remove-row shrink-0 w-8 h-8 flex items-center justify-center rounded-full text-[#B4432C] hover:bg-[#E8674B] hover:text-white transition-colors">
                                <i class="fas fa-xmark text-xs"></i>
                            </button>
                        </div>`);

                $('#entryRows').append(row);
                row.find('input').first().focus();
                rowIndex++;
                updateRemoveButtons();
            });

            // Remove a row
            $(document).on('click', '.remove-row', function () {
                $(this).closest('.entry-row').remove();
                updateRemoveButtons();
            });

            // Keep the very first row's remove button hidden when it's the only one
            function updateRemoveButtons() {
                const rows = $('#entryRows .entry-row');
                if (rows.length <= 1) {
                    rows.find('.remove-row').addClass('opacity-0 pointer-events-none');
                } else {
                    rows.find('.remove-row').removeClass('opacity-0 pointer-events-none');
                }
            }

            function loadEntriesForDate(date) {
                $('#entryList').html('<li class="py-10 text-center text-sm text-[#9C9282]">Loading...</li>');

                $.ajax({
                    url: '/get-bazar/' + date,
                    type: 'GET',
                    success: function (data) {
                        $('#formDate').val(date);

                        if (!data || data.length === 0) {
                            $('#entryList').html(`
                        <li id="emptyState" class="py-10 text-center">
                            <i class="fas fa-cart-flatbed-suitcase text-3xl text-[#E3D9C6] mb-2"></i>
                            <p class="text-sm text-[#9C9282]">No bazar entries yet for this day</p>
                        </li>
                    `);
                            $('#dayTotal').text('৳0.0');
                            return;
                        }

                        let html = '';
                        let total = 0;

                        data.forEach((entry) => {
                            total += parseFloat(entry.amount || 0);

                            html += `<li class="flex items-center justify-between px-5 py-3" data-entry-id="${entry.id}">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#F2A65A]/20 flex items-center justify-center text-[#B5772E] text-xs">
                                        <i class="fas fa-basket-shopping"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-[#123328]">${entry.items || 'Bazar entry'}</p>
                                        <p class="text-xs font-medium text-[#B5772E]">৳${parseFloat(entry.amount).toFixed(1)}</p>
                                    </div>
                                </div>
                                <button class="delete-entry w-7 h-7 flex items-center justify-center rounded-full text-[#B4432C] hover:bg-[#E8674B] hover:text-white transition-colors" data-id="${entry.id}">
                                    <i class="fas fa-xmark text-xs"></i>
                                </button>
                            </li>`;
                        });

                        $('#entryList').html(html);
                        $('#dayTotal').text('৳' + total.toFixed(1));
                    },
                    error: function () {
                        $('#entryList').html('<li class="py-10 text-center text-sm text-red-500">Failed to load entries</li>');
                    }
                });
            }

            $('#entryDate').on('change', function () {
                loadEntriesForDate($(this).val());
            });

            $('#prevDay, #nextDay').on('click', function () {
                let current = new Date($('#entryDate').val());
                current.setDate(current.getDate() + ($(this).is('#nextDay') ? 1 : -1));
                const iso = current.toISOString().split('T')[0];
                $('#entryDate').val(iso);
                loadEntriesForDate(iso);
            });

            $('#todayBtn').on('click', function () {
                const iso = new Date().toISOString().split('T')[0];
                $('#entryDate').val(iso);
                loadEntriesForDate(iso);
            });

            $(document).on('click', '.delete-entry', function () {
                const id = $(this).data('id');
                const row = $(this).closest('li');

                Swal.fire({
                    title: 'Remove this entry?',
                    text: 'This bazar amount will be deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#E8674B'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: '/bazar/' + id,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function () {
                            row.fadeOut(200, function () {
                                $(this).remove();
                                loadEntriesForDate($('#entryDate').val());
                            });
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not delete this entry.', 'error');
                        }
                    });
                });
            });

        });
    </script>
@endsection
