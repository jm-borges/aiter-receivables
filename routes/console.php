<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('clean:old-records')->dailyAt('23:59');
