<?php

use Carbon\Carbon;
use Carbon\CarbonInterface;

if (! function_exists('isInsideWindow')) {
    function isInsideWindow(?CarbonInterface $date = null): bool
    {
        $date = $date ?? now();

        [$start, $end] = getWindowHours();

        return $date->isWeekday()
            && $date->between(
                setTimeFromBase($date, $start),
                setTimeFromBase($date, $end)
            );
    }
}

if (! function_exists('nextWindowDateTime')) {
    function nextWindowDateTime(): CarbonInterface
    {
        $date = now();

        while (true) {
            $date = skipWeekend($date);

            [$start, $end] = getWindowHours();

            $startDate = setTimeFromBase($date, $start);

            if ($date->lessThan($startDate)) {
                return $startDate;
            }

            $date = nextWeekdayMorning($date);
        }
    }
}

if (! function_exists('getWindowHours')) {
    function getWindowHours(): array
    {
        $tz = config('app.timezone');

        if (app()->environment('production')) {
            return [
                Carbon::parse('09:00', $tz),
                Carbon::parse('18:00', $tz),
            ];
        }

        // Homologação
        return [
            Carbon::parse('12:00', $tz),
            Carbon::parse('18:00', $tz),
        ];
    }
}


//
// --- Funções menores auxiliares ---
//

if (! function_exists('skipWeekend')) {
    function skipWeekend(CarbonInterface $date): CarbonInterface
    {
        return $date->isWeekend()
            ? $date->nextWeekday()->startOfDay()
            : $date;
    }
}

if (! function_exists('nextWeekdayMorning')) {
    function nextWeekdayMorning(CarbonInterface $date): CarbonInterface
    {
        return $date->nextWeekday()->startOfDay();
    }
}

if (! function_exists('setTimeFromBase')) {
    function setTimeFromBase(CarbonInterface $base, CarbonInterface $timeSource): CarbonInterface
    {
        return $base->copy()->setTime(
            $timeSource->hour,
            $timeSource->minute,
            $timeSource->second
        );
    }
}
