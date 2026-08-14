<?php

session_start();

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/BoardingController.php';
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../controllers/JobController.php';
require_once __DIR__ . '/../controllers/ClassController.php';
require_once __DIR__ . '/../controllers/SkillController.php';
require_once __DIR__ . '/../controllers/SwapController.php';
require_once __DIR__ . '/../controllers/RiderController.php';
require_once __DIR__ . '/../controllers/HelpRequestController.php';
require_once __DIR__ . '/../controllers/ProductController.php';

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

// Lets the sidebar highlight whichever section the current route belongs to.
function isActive(string $prefix): string
{
    $current = $GLOBALS['currentUri'] ?? '';
    if ($prefix === '/') {
        return $current === '/' ? 'active' : '';
    }

    return strpos($current, $prefix) === 0 ? 'active' : '';
}

function requireLogin(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . url('/login'));
        exit;
    }
}

function requireRole(string $role): void
{
    if (($_SESSION['user_role'] ?? null) !== $role) {
        header('Location: ' . url('/dashboard'));
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
$GLOBALS['currentUri'] = $uri;
$method = $_SERVER['REQUEST_METHOD'];
$segments = array_values(array_filter(explode('/', $uri)));

$auth     = new AuthController();
$admin    = new AdminController();
$boarding = new BoardingController();
$jobs     = new JobController();
$classes  = new ClassController();
$skills   = new SkillController();
$swaps    = new SwapController();
$riders   = new RiderController();
$helpReqs = new HelpRequestController();
$products = new ProductController();

switch (true) {
    // Home / dashboard
    case $uri === '/' || $uri === '':
        if (empty($_SESSION['user_id'])) {
            require __DIR__ . '/../views/home/landing.php';
        } else {
            header('Location: ' . url('/dashboard'));
        }
        break;

    case $uri === '/dashboard':
        requireLogin();
        if ($_SESSION['user_role'] === 'student') {
            require __DIR__ . '/../views/dashboard/student_dashboard.php';
        } elseif ($_SESSION['user_role'] === 'admin') {
            header('Location: ' . url('/admin'));
        } else {
            $openGigs = (new Job())->all('open');
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
        requireRole('student');
        $boarding->store();
        break;
    case $uri === '/boarding/create':
        requireLogin();
        requireRole('student');
        $boarding->showCreateForm();
        break;
    case $uri === '/boarding/my-listings':
        requireLogin();
        requireRole('villager');
        $boarding->myListings();
        break;
    case preg_match('#^/boarding/(\d+)/status$#', $uri, $m) === 1:
        requireLogin();
        $boarding->updateStatus((int) $m[1]);
        break;
    case preg_match('#^/boarding/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $boarding->destroy((int) $m[1]);
        break;
    case $uri === '/boarding/my-requests':
        requireLogin();
        requireRole('student');
        $boarding->myRequests();
        break;
    case $uri === '/boarding/agent-earnings':
        requireLogin();
        requireRole('student');
        $boarding->agentEarnings();
        break;
    case preg_match('#^/boarding/(\d+)/request$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('student');
        $boarding->requestBoarding((int) $m[1]);
        break;
    case preg_match('#^/boarding/requests/(\d+)/confirm$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $boarding->confirmRequest((int) $m[1]);
        break;
    case preg_match('#^/boarding/requests/(\d+)/decline$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $boarding->declineRequest((int) $m[1]);
        break;
    case preg_match('#^/boarding/requests/(\d+)/cancel$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('student');
        $boarding->cancelRequest((int) $m[1]);
        break;
    case preg_match('#^/boarding/(\d+)$#', $uri, $m) === 1:
        $boarding->show((int) $m[1]);
        break;

    // Admin
    case $uri === '/admin':
        requireLogin();
        requireRole('admin');
        $admin->dashboard();
        break;
    case $uri === '/admin/users':
        requireLogin();
        requireRole('admin');
        $admin->users();
        break;
    case $uri === '/admin/create-admin' && $method === 'GET':
        requireLogin();
        requireRole('admin');
        $admin->showCreateAdminForm();
        break;
    case $uri === '/admin/create-admin' && $method === 'POST':
        requireLogin();
        requireRole('admin');
        $admin->createAdmin();
        break;
    case $uri === '/admin/boardings':
        requireLogin();
        requireRole('admin');
        $admin->boardings();
        break;
    case preg_match('#^/admin/boardings/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('admin');
        $admin->deleteBoarding((int) $m[1]);
        break;
    case $uri === '/admin/jobs':
        requireLogin();
        requireRole('admin');
        $admin->jobs();
        break;
    case preg_match('#^/admin/jobs/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('admin');
        $admin->deleteJob((int) $m[1]);
        break;
    case $uri === '/admin/skills':
        requireLogin();
        requireRole('admin');
        $admin->skills();
        break;
    case preg_match('#^/admin/skills/(\d+)/verify$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('admin');
        $admin->verifySkill((int) $m[1]);
        break;
    case $uri === '/admin/swaps':
        requireLogin();
        requireRole('admin');
        $admin->swaps();
        break;
    case $uri === '/admin/lanes' && $method === 'GET':
        requireLogin();
        requireRole('admin');
        $admin->lanes();
        break;
    case $uri === '/admin/lanes' && $method === 'POST':
        requireLogin();
        requireRole('admin');
        $admin->createLane();
        break;

    // Jobs
    case $uri === '/jobs' && $method === 'GET':
        requireLogin();
        $jobs->index();
        break;
    case $uri === '/jobs' && $method === 'POST':
        requireLogin();
        requireRole('student');
        $jobs->store();
        break;
    case $uri === '/jobs/create':
        requireLogin();
        requireRole('student');
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
        requireLogin();
        $jobs->show((int) $m[1]);
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
        requireRole('admin');
        $skills->verify((int) $m[1]);
        break;
    case preg_match('#^/skills/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $skills->destroy((int) $m[1]);
        break;

    // Skills > Classes
    case $uri === '/skills/classes' && $method === 'GET':
        $classes->index();
        break;
    case $uri === '/skills/classes' && $method === 'POST':
        requireLogin();
        requireRole('student');
        $classes->store();
        break;
    case $uri === '/skills/classes/create':
        requireLogin();
        requireRole('student');
        $classes->showCreateForm();
        break;
    case $uri === '/skills/classes/my':
        requireLogin();
        requireRole('student');
        $classes->myClasses();
        break;
    case preg_match('#^/skills/classes/enrollments/(\d+)/status$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $classes->updateEnrollmentStatus((int) $m[1]);
        break;
    case preg_match('#^/skills/classes/(\d+)/enroll$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $classes->enroll((int) $m[1]);
        break;
    case preg_match('#^/skills/classes/(\d+)/status$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        $classes->updateStatus((int) $m[1]);
        break;
    case preg_match('#^/skills/classes/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('student');
        $classes->destroy((int) $m[1]);
        break;
    case preg_match('#^/skills/classes/(\d+)$#', $uri, $m) === 1:
        $classes->show((int) $m[1]);
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

    // Riders
    case $uri === '/riders' && $method === 'GET':
        requireLogin();
        $riders->index();
        break;
    case $uri === '/riders' && $method === 'POST':
        requireLogin();
        requireRole('student');
        $riders->store();
        break;
    case $uri === '/riders/my':
        requireLogin();
        requireRole('student');
        $riders->myRider();
        break;
    case $uri === '/riders/toggle' && $method === 'POST':
        requireLogin();
        requireRole('student');
        $riders->toggleStatus();
        break;
    case $uri === '/riders/delete' && $method === 'POST':
        requireLogin();
        requireRole('student');
        $riders->destroy();
        break;

    // Help Requests
    case $uri === '/help-requests' && $method === 'GET':
        requireLogin();
        requireRole('student');
        $helpReqs->index();
        break;
    case $uri === '/help-requests' && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $helpReqs->store();
        break;
    case $uri === '/help-requests/create':
        requireLogin();
        requireRole('villager');
        $helpReqs->showCreateForm();
        break;
    case $uri === '/help-requests/my':
        requireLogin();
        requireRole('villager');
        $helpReqs->myRequests();
        break;
    case $uri === '/help-requests/my-accepted':
        requireLogin();
        requireRole('student');
        $helpReqs->myAccepted();
        break;
    case preg_match('#^/help-requests/(\d+)/accept$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('student');
        $helpReqs->accept((int) $m[1]);
        break;
    case preg_match('#^/help-requests/(\d+)/complete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $helpReqs->complete((int) $m[1]);
        break;
    case preg_match('#^/help-requests/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $helpReqs->destroy((int) $m[1]);
        break;
    case preg_match('#^/help-requests/(\d+)$#', $uri, $m) === 1:
        requireLogin();
        $helpReqs->show((int) $m[1]);
        break;

    // Village Products
    case $uri === '/products' && $method === 'GET':
        requireLogin();
        $products->index();
        break;
    case $uri === '/products' && $method === 'POST':
        requireLogin();
        requireRole('student');
        $products->store();
        break;
    case $uri === '/products/create':
        requireLogin();
        requireRole('student');
        $products->showCreateForm();
        break;
    case $uri === '/products/my-listings':
        requireLogin();
        requireRole('villager');
        $products->myListings();
        break;
    case $uri === '/products/my-purchases':
        requireLogin();
        requireRole('student');
        $products->myPurchases();
        break;
    case preg_match('#^/products/requests/(\d+)/confirm$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $products->confirmRequest((int) $m[1]);
        break;
    case preg_match('#^/products/requests/(\d+)/decline$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $products->declineRequest((int) $m[1]);
        break;
    case preg_match('#^/products/(\d+)/request$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('student');
        $products->requestProduct((int) $m[1]);
        break;
    case preg_match('#^/products/(\d+)/status$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $products->updateStatus((int) $m[1]);
        break;
    case preg_match('#^/products/(\d+)/delete$#', $uri, $m) === 1 && $method === 'POST':
        requireLogin();
        requireRole('villager');
        $products->destroy((int) $m[1]);
        break;
    case preg_match('#^/products/(\d+)$#', $uri, $m) === 1:
        requireLogin();
        $products->show((int) $m[1]);
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
