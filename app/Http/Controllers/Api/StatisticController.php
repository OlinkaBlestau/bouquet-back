<?php

namespace App\Http\Controllers\Api;

use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatisticController
{
    public function sale(Request $request, StatisticService $statisticService): Response
    {
        $period = $request->input('period');
        $sales = $statisticService->getSalesStatistic($period);

        return response($sales);
    }
}
