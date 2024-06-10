<?php

use App\Mail\RecapEmail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    Mail::to('test@me.com')->send(new RecapEmail());
})->everyMinute();
