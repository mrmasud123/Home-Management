<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>
</head>
<body>

    <div style="background-color: #f2f2f2; padding: 0px 10px;  border: 2px solid #4CAF50; border-radius: 10px; width: 100%; max-width: 600px; margin: 0 auto; font-family: sans-serif;">
        <h5 style="text-align: center; color: #4CAF50; margin-bottom: 20px;">Monthly Expense Summary</h5>
        <h6 style="margin: 10px 0; color: #333;">Month :
            <span style="float: right; color: #000;">{{ $data['month'] }}</span>
        </h6>
        <h6 style="margin: 10px 0; color: #333;">Flat Rent:
            <span style="float: right; color: #000;">{{ $data['amounts']['flat_rent'] }}</span>
        </h6>

        <h6 style="margin: 10px 0; color: #333;">Service Charge:
            <span style="float: right; color: #000;">{{ $data['amounts']['service_charge'] }}</span>
        </h6>

        <h6 style="margin: 10px 0; color: #333;">Electricity Bill:
            <span style="float: right; color: #000;">{{ $data['amounts']['electricity_bill'] }}</span>
        </h6>

        <h6 style="margin: 10px 0; color: #333;">Wifi Bill:
            <span style="float: right; color: #000;">{{ $data['amounts']['wifi_bill'] }}</span>
        </h6>
        <h6 style="margin: 10px 0; color: #333;">Gas Bill:
            <span style="float: right; color: #000;">{{ $data['amounts']['gas_bill'] }}</span>
        </h6>

        <h6 style="margin: 10px 0; color: #333;">Garbage Bill:
            <span style="float: right; color: #000;">{{ $data['amounts']['garbage_charge'] }}</span>
        </h6>

        <h6 style="margin: 10px 0; color: #333;">Khala Salary:
            <span style="float: right; color: #000;">{{ $data['amounts']['khala_salary'] }}</span>
        </h6>

        <div style="clear: both;"></div>
    </div>

    <table border="1" width="100%" cellpadding="5" style="margin-top:10px ;border-collapse: collapse; border-radius:7px">
    <thead>
        <tr style="background-color: rgba(128, 128, 128, 0.164)">
            <th>Member</th>
            <th>Seat Rent</th>
            <th>Service Charge</th>
            <th>Garbage Charge</th>
            <th>Electricity Bill</th>
            <th>Wifi Bill</th>
            <th>Gas Bill</th>
            <th>Khala Salary</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['monthly_expenses'] as $item)
            <tr>
                <td>{{ ucfirst($item['member']) }}</td>
                <td>{{ $item['flat_rent'] }}</td>
                <td>{{ $item['service_charge'] }}</td>
                <td>{{ $item['garbage_charge'] }}</td>
                <td>{{ $item['electricity_bill'] }}</td>
                <td>{{ $item['wifi_bill'] }}</td>
                <td>{{ $item['gas_bill'] }}</td>
                <td>{{ $item['khala_salary'] }}</td>
                <td align="right">{{ $item['total_amt'] }}</td>
            </tr>
        @endforeach
        <tr style="background-color: rgb(2, 4, 52); ">
            <td style="color:white" colspan="8" align="right"><strong>Total</strong></td>
            <td style="color:white" align="right"><strong>{{ $data['grand_total'] }}</strong></td>
        </tr>
    </tbody>
</table>



<htmlpagefooter name="myFooter">
    <div style="text-align: right; font-size: 10px;">
        Page {PAGENO} of {nbpg} <br>
        Generated on {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }} <br>
        <span style="color:red">Courtesy by MR</span>
    </div>
</htmlpagefooter>

<sethtmlpagefooter name="myFooter" value="on" />
</body>
</html>
