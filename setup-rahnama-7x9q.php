<?php
// فایل موقت برای اجرای migration روی هاست — بعد از اجرا حذف کن!
$secret = 'GR-SETUP-2026-DELETE-AFTER-USE';

if (! isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403);
    die('Unauthorized');
}

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../gallery-rahnama/vendor/autoload.php';
$app = require_once __DIR__ . '/../gallery-rahnama/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '<pre style="font-family:monospace;direction:ltr;background:#111;color:#0f0;padding:20px;">';

// مرحله ۱: پاک کردن همه cache‌ها
$clearCommands = [
    'config:clear',
    'route:clear',
    'view:clear',
    'cache:clear',
    'optimize:clear',
];

echo "=== STEP 1: Clear all caches ===\n";
foreach ($clearCommands as $cmd) {
    echo "\n▶ php artisan $cmd\n";
    try {
        $kernel->call($cmd);
        echo $kernel->output();
    } catch (\Throwable $e) {
        echo "  (skipped: " . $e->getMessage() . ")\n";
    }
}

// مرحله ۲: migrate
echo "\n=== STEP 2: Migrate ===\n";
echo "\n▶ php artisan migrate --force\n";
try {
    $kernel->call('migrate', ['--force' => true]);
    echo $kernel->output();
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// مرحله ۳: rebuild cache (بدون route:cache چون ممکنه خطا بده)
echo "\n=== STEP 3: Rebuild config & view cache ===\n";
foreach (['config:cache', 'view:cache'] as $cmd) {
    echo "\n▶ php artisan $cmd\n";
    try {
        $kernel->call($cmd);
        echo $kernel->output();
    } catch (\Throwable $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\n✅ تمام مراحل اجرا شد. این فایل را از public_html حذف کن!\n";
echo '</pre>';
