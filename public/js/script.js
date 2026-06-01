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
        form.find('input[name]').each(function () {
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
            let html = `<div class="modal-content">
                <div class="modal-body">
                    <table class="table table-bordered table-hover table-stripped">
                        <thead>
                            <tr>
                                <th>সদস্য</th>
                                <th>সিট ভাড়া</th>
                                <th>সার্ভিস চার্জ</th>
                                <th>ময়লা বিল</th>
                                <th>বিদ্যূৎ বিল</th>
                                <th>ওয়াইফাই বিল</th>
                                <th>গ্যাস বিল</th>
                                <th>খালার বেতন</th>
                                <th>সর্বমোট</th>
                            </tr>
                        </thead>
                        <tbody>`;

            data.monthly_expenses.map((item) => {
                html += `<tr class="bg-light">
                    <td class="text-capitalize">${item.member}</td>
                    <td>${item.flat_rent}</td>
                    <td>${item.service_charge}</td>
                    <td>${item.garbage_charge}</td>
                    <td>${item.electricity_bill}</td>
                    <td>${item.wifi_bill}</td>
                    <td>${item.gas_bill}</td>
                    <td>${item.khala_salary}</td>
                    <td align="center"><span class="badge bg-info">${item.total_amt}</span></td>
                </tr>`;
            });

            html += `<tr>
                        <td colspan="9" align="right"><span class="badge bg-success">
                            ${data.grand_total}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0)" type="button" class="btn btn-primary pdf">Generate PDF</a>
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
