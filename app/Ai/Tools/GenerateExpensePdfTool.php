<?php

namespace App\Ai\Tools;

use App\Services\ExpenseCalculatorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request as AiRequest;
use Stringable;

class GenerateExpensePdfTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Generates a monthly expense PDF report for all active members.
                Requires flat_rent, service_charge, garbage_charge, electricity_bill,
                gas_bill, wifi_bill, and khala_salary amounts.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'flat_rent'        => $schema->integer()->description('Total flat rent amount')->required(),
            'service_charge'   => $schema->integer()->description('Monthly service charge')->required(),
            'garbage_charge'   => $schema->integer()->description('Garbage collection charge')->required(),
            'electricity_bill' => $schema->integer()->description('Total electricity bill')->required(),
            'gas_bill'         => $schema->integer()->description('Total gas bill')->required(),
            'wifi_bill'        => $schema->integer()->description('WiFi bill amount')->required(),
            'khala_salary'     => $schema->integer()->description('Khala salary amount')->required(),
        ];
    }

    public function handle(AiRequest $request): Stringable|string
    {
        try {
            $data = [
                'flat_rent'        => (float) $request->get('flat_rent'),
                'service_charge'   => (float) $request->get('service_charge'),
                'garbage_charge'   => (float) $request->get('garbage_charge'),
                'electricity_bill' => (float) $request->get('electricity_bill'),
                'gas_bill'         => (float) $request->get('gas_bill'),
                'wifi_bill'        => (float) $request->get('wifi_bill'),
                'khala_salary'     => (float) $request->get('khala_salary'),
            ];

            $result = (new ExpenseCalculatorService())->calculate($data);

            if (! $result['status']) {
                return 'Calculation failed: ' . ($result['message'] ?? 'Unknown error');
            }

            Storage::makeDirectory('public/pdfs');

            $filename = 'monthly-expense-' . now()->format('Y-m-d-His') . '.pdf';
            $path     = storage_path('app/public/pdfs/' . $filename);

            Pdf::loadView('pdf.monthly-expense', [
                'monthly_expenses' => $result['monthly_expenses'],
                'grand_total'      => $result['grand_total'],
                'amounts'          => $result['amounts'],
            ])
                ->setPaper('a4', 'landscape')
                ->save($path);

            $url = url('storage/pdfs/' . $filename);

            return "PDF generated successfully! Download it here: {$url}";

        } catch (\Exception $e) {
            Log::error('GenerateExpensePdfTool error: ' . $e->getMessage());
            return 'Error generating PDF: ' . $e->getMessage();
        }
    }
}
