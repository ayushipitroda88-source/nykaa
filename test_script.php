<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::orderBy('id', 'asc')->get();
echo "Total users: " . count($users) . "\n";
foreach($users as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Pass Length: " . strlen($user->password) . " | Pass: " . substr($user->password, 0, 10) . "...\n";
}
