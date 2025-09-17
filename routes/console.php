<?php

use App\Services\ReceivableService;
use Illuminate\Support\Facades\Schedule;

Schedule::command('clean:old-records')->dailyAt('23:59');

Schedule::call(fn() => app(ReceivableService::class)->getAllContractsReceivables())
    ->dailyAt(''); //horário de abertura da janela de negociação