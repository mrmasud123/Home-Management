<?php

namespace App\Http\Controllers;

use App\Ai\Agents\AiAgent;
use App\Services\CurrentMonthSummaryService;
use Illuminate\Http\Request;

class AIChatController extends Controller
{
    public function index(CurrentMonthSummaryService $currentMonthSummaryService){
        $reportData= $currentMonthSummaryService->getDataForMonth();
        return view('aichat', $reportData);
    }

    public function continueChat(Request $request)
    {
        $validatedData = $request->validate([
            'prompt' => 'required'
        ]);

        try{
            $response= (new AiAgent())->prompt($validatedData['prompt']);

            return response()->json([
                'received' =>(string) $response,
                'all' => $request->all()
            ]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
