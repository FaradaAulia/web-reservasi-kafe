<?php

$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
    echo "vendor autoload not found\n";
    exit(1);
}

require $autoload;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

$u = \App\Models\User::create([
    'name' => 'WebTest',
    'email' => 'webtest@example.com',
    'password' => Hash::make('secret'),
]);

echo $u->id . PHP_EOL;
