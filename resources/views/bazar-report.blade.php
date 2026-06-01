<!DOCTYPE html>
<html>
<head>
    <title>Bazar Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">{{ $pdfMonth }} Bazar Report</h2>

    @php
        $totalBazar=0;
        $totalMeal=0;
        $totalExpense=0;
        $members=$record;
        $uniqueDates=$members->map(function($member){
            return $member->bazar->pluck('bazar_amt_date');
        })->sort()->unique()->flatten();
    @endphp
    <table>
        <thead>
            <tr>
                <th>Date</th>
                @foreach ($record as $bazar)
                    <th>{{ ucfirst($bazar->name) }}</th>
                @endforeach
                <th style="width:140px" align="right">Total</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($uniqueDates as $date)
                <tr>
                    <td>{{ $date }}</td>
                    @foreach ($members as $member)
                        @php
                            $data= $member->bazar->firstWhere('bazar_amt_date', $date);
                        @endphp
                        <td>{{ $data->amount }}</td>
                    @endforeach
                    <td></td>
                </tr>
            @endforeach
            <tr style="background-color:#e5efd2">
                <td><strong>Total Tk.</strong></td>
                @foreach ($record as $data)
                @php $totalBazar+=$data->bazar_sum_amount; @endphp
                    <td><strong>{{ $data->bazar_sum_amount }}</strong></td>
                @endforeach
                <td align="right"> <strong>{{ $totalBazar }}</strong> </td>
            </tr>
            <tr style="background-color:#d2efcd">
                <td><strong>Total Meal</strong></td>
                @foreach ($record as $data)
                @php $totalMeal+=$data->meals_sum_meal_count; @endphp
                    <td><strong>{{ $data->meals_sum_meal_count }}</strong></td>
                @endforeach
                <td align="right"> <strong>{{ $totalMeal }}</strong> </td>
            </tr>
            <tr style="background-color:#d4f6f0">
                @php $meal_rate=number_format($totalBazar/$totalMeal,1); @endphp
                <td><strong>Meal Rate</strong></td>
                <td align="center" colspan="{{ count($members)+1 }}"><strong> <strong>{{ $meal_rate }}</strong> </strong></td>
            </tr>
            <tr style="background-color:#cfe6f4">
                <td><strong>Expense</strong></td>
                @foreach ($record as $data)

                @php 
                    $totalExpense+=($data->meals_sum_meal_count * $meal_rate); 
                @endphp
                    <td><strong>{{ $data->meals_sum_meal_count * $meal_rate }}</strong></td>
                @endforeach
                <td align="right"><strong>{{ $totalExpense }}</strong></td>
            </tr>
           <tr>
                <td><strong>Give/Take</strong></td>
                @php
                    $give=0;
                        $take=0;
                @endphp
                @foreach ($record as $data)
                    @php
                        
                        $amount = $data->bazar_sum_amount-($data->meals_sum_meal_count * $meal_rate);
                        $amount>0 ? $give+=$amount: $take+=$amount;
                    @endphp
                    <td>
                        <div style="padding:5px; background-color:{{ $amount>0 ? 'green':'red' }}; color:white;">
                            <strong>{{ number_format($amount,2) }}</strong>
                        </div>
                    </td>
                @endforeach
                <td  align="right">
                    <span style="background-color: red; color:white">  <strong>{{ $give }}</strong> </span>
                    <span style="background-color: green; color:white">  <strong>{{ $take }}</strong> </span>
                </td>
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
