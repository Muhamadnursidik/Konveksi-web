<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\JobProduksi;

$jobs = JobProduksi::all();

foreach ($jobs as $job) {

    echo $job->id . ' - model: ' . ($job->model_pakaian_id ?? 'null') . ' - bahan: ' . ($job->bahan_baku_id ?? 'null') . PHP_EOL;

}
