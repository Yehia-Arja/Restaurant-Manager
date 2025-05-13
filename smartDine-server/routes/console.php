<?php

<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Schedule;
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
<<<<<<< HEAD
=======

Schedule::command('compute:branch-popular')->hourly();
Schedule::command('compute:user-recs')     ->hourly();
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
