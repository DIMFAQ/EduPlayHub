<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Authenticate as Budi Santoso
$user = \App\Models\User::where('email', 'buyer@demo.com')->first();
if ($user) {
    \Illuminate\Support\Facades\Auth::login($user);
    echo "Logged in as {$user->name}\n";
} else {
    echo "User not found\n";
}

// Request /katalog
$request = \Illuminate\Http\Request::create('/katalog', 'GET');
$response = $app->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);

file_put_contents("catalog_rendered.html", $response->getContent());
echo "Rendered catalog to catalog_rendered.html\n";
