<?php
require 'vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$compiler = app('blade.compiler');
$compiled = $compiler->compileString(file_get_contents('resources/views/dashboard.blade.php'));
file_put_contents('compiled_dashboard.php', $compiled);
echo "Compiled successfully.\n";
