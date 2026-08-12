<?php

session_start();

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/BoardingController.php';
require_once __DIR__ . '/../controllers/JobController.php';
require_once __DIR__ . '/../controllers/RideController.php';
require_once __DIR__ . '/../controllers/SkillController.php';
require_once __DIR__ . '/../controllers/SwapController.php';

// The app may be deployed either at a domain root (via a vhost pointing at
// public/) or under a subfolder like /UniConnect-HackTrail/public/ on a
// plain WAMP htdocs install. basePath() detects which, so every internal
// link and redirect works in both setups.
function basePath(): string
{
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    return $scriptDir === '/' ? '' : rtrim($scriptDir, '/');
}

function url(string $path = ''): string
{
    return basePath() . '/' . ltrim($path, '/');
}

function requireLogin(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . url('/login'));
        exit;
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = basePath();
if ($base !== '' && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}
if ($uri === '') {
    $uri = '/';
}
$method = $_SERVER['REQUEST_METHOD'];
$segments = array_values(array_filter(explode('/', $uri)));

$auth     = new AuthController();
$boarding = new BoardingController();
$jobs     = new JobController();
$rides    = new RideController();
$skills   = new SkillController();
$swaps    = new SwapController();

switch (true) {
    // Home / dashboard
    case $uri === '/' || $uri === '':
        header('Location: ' . url(empty($_SESSION['user_id']) ? '/login' : '/dashboard'));
        break;

    case $uri === '/dashboard':
        requireLogin();
        if ($_SESSION['user_role'] === 'student') {
            require __DIR__ . '/../views/dashboard/student_dashboard.php';
        } else {
            require __DIR__ . '/../views/dashboard/villager_dashboard.php';
        }
        break;

    // Auth
    case $uri === '/login' && $method === 'GET':
        $auth->showLogin();
        break;
    case $uri === '/login' && $method === 'POST':
        $auth->login();
        break;
    case $uri === '/register' && $method === 'GET':
        $auth->showRegister();
        break;
    case $uri === '/register' && $method === 'POST':
        $auth->register();
        break;
    case $uri === '/logout':
        $auth->logout();
        break;

    // Boarding
    case $uri === '/boarding' && $method === 'GET':
        $boarding->index();
        break;
    case $uri === '/boarding' && $method === 'POST':
        requireLogin();
        $boarding->store();
        break;
    case $uri === '/boarding/create':
        requireLogin();
        $boarding->showCreateForm();
        break;
    case preg_match('#^/boarding/(\d+)/status$#', $uri, $m) === 1:
        requireLogin();
        $boarding->updateStatus((int) $m[1]);
        break;
    case preg_match('#^/boarding/(\d+)$#', $uri, $m) === 1:
        $boarding->show((int) $m[1]);
        break;

    // Jobs
    case $uri === '/jobs' && $method === 'GET':
        $jobs->index();
        break;
    case $uri === '/jobs' && $method === 'POST':
        requireLogin();
        $jobs->store();
        break;
    case $uri === '/jobs/create':
        requireLogin();
        $jobs->showCreateForm();
        break;
    case $uri === '/jobs/my-applications':
        requireLogin();
        $jobs->myApplications();
        break;
    case preg_match('#^/jobs/(\d+)/status$#', $uri, $m) === 1:
        requireLogin();
        $jobs->updateStatus((int) $m[1]);
        break;
    case preg_match('#^/jobs/(\d+)$#', $uri, $m) === 1:
        $jobs->show((int) $m[1]);
        break;

    // Rides
    case $uri === '/rides/request' && $method === 'GET':
        requireLogin();
        $rides->showRequestForm();
        break;
    case $uri === '/rides/request' && $method === 'POST':
        requireLogin();
        $rides->requestRide();
        break;
    case $uri === '/rides/offer' && $method === 'GET':
        requireLogin();
        $rides->showOfferForm();
        break;
    case $uri === '/rides/offer/toggle':
        requireLogin();
        $rides->toggleAvailability();
        break;
    case preg_match('#^/rides/status/(\d+)$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $rides->updateStatus((int) $m[1]);
        break;
    case preg_match('#^/rides/status/(\d+)$#', $uri, $m) === 1:
        requireLogin();
        $rides->status((int) $m[1]);
        break;

    // Skills
    case preg_match('#^/skills/profile/(\d+)$#', $uri, $m) === 1:
        $skills->profile((int) $m[1]);
        break;
    case $uri === '/skills/directory':
        $skills->directory();
        break;
    case $uri === '/skills' && $method === 'POST':
        requireLogin();
        $skills->store();
        break;
    case preg_match('#^/skills/(\d+)/verify$#', $uri, $m) === 1:
        requireLogin();
        $skills->verify((int) $m[1]);
        break;

    // Skill swaps
    case $uri === '/swaps' && $method === 'GET':
        $swaps->index();
        break;
    case $uri === '/swaps/propose' && $method === 'GET':
        requireLogin();
        $swaps->showProposeForm();
        break;
    case $uri === '/swaps/propose' && $method === 'POST':
        requireLogin();
        $swaps->propose();
        break;
    case $uri === '/swaps/history':
        $swaps->history();
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
