{{-- resources/views/emails/daily-summary.blade.php --}}
<div style="font-family: sans-serif; max-width: 480px; margin: 0 auto;">
    <h2 style="color:#123328;">Hi {{ $member->name }},</h2>
    <p>Here's your summary for <strong>{{ $date }}</strong>:</p>
    <ul>
        <li>Meals today: <strong>{{ $mealCount }}</strong></li>
        <li>Bazar spent today: <strong>৳{{ number_format($bazarTotal, 1) }}</strong></li>
    </ul>
    <p style="color:#9C9282; font-size: 12px;">Bachelor Flat Mealio</p>
</div>
