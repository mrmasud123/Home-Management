$(document).ready(function(){
        $("#sameMeal").prop('disabled', true)
        $("#sameBazar").prop('disabled', true)

        $('#selectAll').on('change', function(e) {
            e.preventDefault();
            let isChecked = $(this).is(':checked');
            $("#sameMeal").prop('disabled', !isChecked);
            $('.member-input-row input[type="number"]').each(function() {
                $(this).prop('disabled', isChecked);
            });
        });
        $('#selectAllBazarMember').on('change', function(e) {
            e.preventDefault();
            let isChecked = $(this).is(':checked');
            $("#sameBazar").prop('disabled', !isChecked);
            $('.bazar-input-row input[type="number"]').each(function() {
                $(this).prop('disabled', isChecked);
            });
        });

        $("#sameMeal").on('input', function() {
            let value = $(this).val();
            $('.member-input-row input[type="number"]').each(function() {
                if ($(this).prop('disabled')) {
                    $(this).val(value === '' ? 0 : parseFloat(value));
                }
            });
        });
        $("#sameBazar").on('input', function() {
            let value = $(this).val();
            $('.bazar-input-row input[type="number"]').each(function() {
                if ($(this).prop('disabled')) {
                    $(this).val(value === '' ? 0 : parseFloat(value));
                }
            });
        });

        $('#mealForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let mealDate = $('#meal_date').val();
            let data = [];

            form.find('.member-input-row .meal').each(function() {
                let memberName = $(this).find('label').text().trim();
                let mealCount = $(this).find('input[type="number"]').val();
                let memberId = $(this).find('input[type="number"]').data('member-id');

                    data.push({
                        member_name: memberName,
                        member_id: memberId,
                        meal_count: mealCount === '' ? 0 : parseFloat(mealCount),
                        meal_date: mealDate
                    });
            });
            console.log(data);

            $.ajax({
                url: '/credentials',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    meals: data
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: response.message
                    }).then((result)=>{
                        if(result.isConfirmed){
                            form.trigger('reset');
                            window.location.href='/';
                        }
                    });
                },
                error: function(xhr) {
                    let msg = 'Something went wrong. Please try again.';
                    if(xhr.status === 409) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: msg
                    });
                }
            });

        });


        $('#bazarForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let bazarDate = $('#bazar_date').val();
            let data = [];

            form.find('.bazar-input-row .bazar').each(function() {
                let memberName = $(this).find('label').text().trim();
                let bazarAmount = $(this).find('input[type="number"]').val();
                let memberId = $(this).find('input[type="number"]').data('member-id');

                    data.push({
                        member_name: memberName,
                        member_id: memberId,
                        bazar_amount: bazarAmount === '' ? 0 : parseFloat(bazarAmount),
                        bazar_date: bazarDate
                    });
            });
            console.log(data)
            $.ajax({
                url: '/bazar',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    bazars: data
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.trigger('reset');
                            window.location.href = '/';
                        }
                    }).catch((err) => {
                        console.error('Swal error:', err);
                    });

                },
                error: function(xhr) {
                    let msg = 'Something went wrong. Please try again.';
                    if(xhr.status === 409) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: msg
                    });
                }
            });
        });


    $("#calculateMonthlyExpense").on('submit', function (e) {

        e.preventDefault();
        Swal.fire({
            title: 'Calculating ...',
            text: 'Please wait while we load the data.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        let form = $(this);
        let formData={}
        form.find('input[name],select[name]').each(function () {
            let name = $(this).attr('name');
            let type = $(this).attr('type');

            if (type === 'checkbox') {
                if ($(this).is(':checked')) {
                    formData[name] = $(this).data('miller-id');
                }
            } else {
                formData[name] = $(this).val() || 0;
            }
        });
        console.log(formData)
        $.ajax({
            url: '/credentials/calculateMonthlyExpense',
            method: 'POST',
            data: formData,
            success: function (data) {
    if (data) {
        Swal.close();

        if (!data.status) {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message
            });
        } else {
            let html = `<div class="modal-content bg-white rounded-2xl shadow-xl shadow-black/10 overflow-hidden max-w-5xl w-full mx-auto">

                <div class="modal-body p-6">

                    <h3 class="flex items-center gap-2 text-lg font-bold text-[#20291F] mb-5">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#9CC5A1]/25 text-[#123328]">
                            <i class="fas fa-calendar-days text-xs"></i>
                        </span>
                        Month : <span class="text-[#E8674B]">${data.month ?? 'N/A'}</span>
                    </h3>

                    <div class="overflow-x-auto rounded-xl border border-[#20291F]/10">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#123328] to-[#1B4536] text-[#FFF8EF]">
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">সদস্য</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">সিট ভাড়া</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">সার্ভিস চার্জ</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">ময়লা বিল</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">বিদ্যূৎ বিল</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">ওয়াইফাই বিল</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">গ্যাস বিল</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">খালার বেতন</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">সর্বমোট</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#20291F]/5">`;

                        data.monthly_expenses.map((item) => {
                            html += `<tr class="even:bg-[#FBF9F4] hover:bg-[#9CC5A1]/10 transition-colors">
                        <td class="px-4 py-2.5 font-semibold text-[#20291F] capitalize">${item.member}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.flat_rent}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.service_charge}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.garbage_charge}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.electricity_bill}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.wifi_bill}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.gas_bill}</td>
                        <td class="px-4 py-2.5 text-center text-[#20291F]/70">${item.khala_salary}</td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="inline-flex items-center text-xs font-semibold bg-[#F2A65A]/20 text-[#9a6323] px-2.5 py-1 rounded-full">
                                ${item.total_amt}
                            </span>
                        </td>
                    </tr>`;
                        });

                        html += `       <tr>
                                    <td colspan="9" class="px-4 py-3.5 bg-[#0B241C]">
                                        <div class="flex items-center justify-end gap-3">
                                            <span class="text-xs font-medium text-[#FFF8EF]/60 uppercase tracking-wide">সর্বমোট</span>
                                            <span class="inline-flex items-center text-sm font-bold bg-[#9CC5A1] text-[#123328] px-3.5 py-1.5 rounded-full">
                                                ${data.grand_total}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer flex items-center justify-end gap-3 px-6 py-4 border-t border-[#20291F]/10 bg-[#FBF9F4]">
                    <a href="javascript:void(0)" class="pdf inline-flex items-center gap-2 text-sm font-semibold bg-[#E8674B] hover:bg-[#d4573d] text-[#FFF8EF] px-5 py-2.5 rounded-full shadow-md shadow-[#E8674B]/20 transition-colors">
                        <i class="fas fa-file-pdf"></i>Generate PDF
                    </a>
                </div>
            </div>`;

            Swal.fire({
                title: 'Monthly Expense',
                html: html,
                width: '1100px',
                customClass: {
                    popup: 'swal-wide'
                }
            });

            // PDF Preview Button Click
            $(document).off('click', '.pdf').on('click', '.pdf', function () {
                let form = $('<form>', {
                    action: '/generate-pdf',
                    method: 'POST',
                    target: '_blank'
                });

                // Add CSRF token
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: $('meta[name="csrf-token"]').attr('content')
                }));

                // Add data
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'monthly_expenses',
                    value: JSON.stringify(data.monthly_expenses)
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'grand_total',
                    value: data.grand_total
                }));
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'amounts',
                    value: JSON.stringify(data.amounts)
                }));
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'month',
                    value: data.month
                }));

                // Append, submit, and remove
                $('body').append(form);
                form.submit();
                form.remove();
            });
        }
    }
}
,
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    });
