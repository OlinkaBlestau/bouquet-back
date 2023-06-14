<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StatisticService
{
    public function getSalesStatistic($period): Collection
    {
        $repository = app(OrderRepository::class);
        $orders = $repository->all();

        $result = match ($period) {
            'month' => $this->calculateForMonth($orders),
            'year' => $this->calculateForYear($orders),
        };

        return collect($result);
    }

    private function calculateForMonth($orders): array
    {
        $result = $this->fillMonthLabels();

        foreach ($orders as $order) {
            $orderDate = Carbon::parse($order['created_at']);
                if ($this->isRelatedToDate($orderDate, 'month')) {
                    $day = $orderDate->day;
                    $result[$day] += $order->amount * $order->bouquet()->first()->total_price;
                }
        }

        return $result;
    }

    private function calculateForYear($orders): array
    {
        $result = $this->fillYearLabels();

        foreach ($orders as $order) {
            $orderDate = Carbon::parse($order['created_at']);
            if ($this->isRelatedToDate($orderDate, 'year')) {
                $month = $orderDate->monthName;
                $result[$month] += $order->amount * $order->bouquet()->first()->total_price;
            }
        }

        return $result;
    }

    private function isRelatedToDate($date, $period): bool
    {
        return match ($period) {
            'month' => Carbon::now()->startOfMonth() <= $date,
            'year' => Carbon::now()->startOfYear() <= $date,
        };
    }

    private function fillMonthLabels(): array
    {
        $days = Carbon::now()->daysInMonth;
        $result = [];

        for ($i = 1; $i <= $days; $i++) {
            $result[$i] = 0;
        }
        return $result;
    }

    private function fillYearLabels(): array
    {
        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonths($i);
            $result[$month->monthName] = 0;
        }

        return $result;
    }
}
