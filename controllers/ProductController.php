<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductRequest.php';
require_once __DIR__ . '/../models/Lane.php';
require_once __DIR__ . '/../models/User.php';

class ProductController
{
    private Product $productModel;
    private ProductRequest $requestModel;
    private Lane $laneModel;
    private User $userModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->requestModel = new ProductRequest();
        $this->laneModel    = new Lane();
        $this->userModel    = new User();
    }

    public function index(): void
    {
        $category = in_array($_GET['category'] ?? null, ['spices', 'tea', 'mushroom', 'vegetables', 'fruits', 'other'], true)
            ? $_GET['category']
            : null;
        $laneId = ($_GET['lane_id'] ?? '') !== '' ? (int) $_GET['lane_id'] : null;

        $products = $this->productModel->all('available', $category, $laneId);
        $lanes = $this->laneModel->all();
        require __DIR__ . '/../views/products/product_feed.php';
    }

    public function show(int $id): void
    {
        $product = $this->productModel->find($id);
        $requests = null;
        $myRequest = null;

        if ($product && ($_SESSION['user_id'] ?? null) == $product['owner_id']) {
            $requests = $this->requestModel->allByProduct($id);
        } elseif ($product && !empty($_SESSION['user_id'])) {
            $myRequest = $this->requestModel->findExisting($id, (int) $_SESSION['user_id']);
        }

        require __DIR__ . '/../views/products/product_detail.php';
    }

    public function showCreateForm(): void
    {
        $villagers = array_filter($this->userModel->all(), fn ($u) => $u['user_role'] === 'villager');
        $lanes = $this->laneModel->all();
        require __DIR__ . '/../views/products/post_product.php';
    }

    public function store(): void
    {
        $villager = null;
        $villagerId = (int) ($_POST['villager_id'] ?? 0);
        if ($villagerId > 0) {
            $candidate = $this->userModel->findById($villagerId);
            if ($candidate && $candidate['user_role'] === 'villager') {
                $villager = $candidate;
            }
        }

        if (!$villager) {
            $_SESSION['error_message'] = 'Please select the villager who owns this product.';
            header('Location: ' . url('/products/create'));
            return;
        }

        $category = in_array($_POST['category'] ?? null, ['spices', 'tea', 'mushroom', 'vegetables', 'fruits', 'other'], true)
            ? $_POST['category']
            : 'other';
        $laneId = ($_POST['lane_id'] ?? '') !== '' ? (int) $_POST['lane_id'] : null;

        $productId = $this->productModel->create([
            'owner_id'           => $villager['user_id'],
            'owner_name'         => $villager['name'],
            'owner_phone'        => $villager['phone'],
            'product_name'       => trim($_POST['product_name'] ?? ''),
            'category'           => $category,
            'description'        => trim($_POST['description'] ?? '') ?: null,
            'price_per_unit'     => $_POST['price_per_unit'] ?? 0,
            'unit'               => trim($_POST['unit'] ?? '') ?: 'kg',
            'quantity_available' => $_POST['quantity_available'] ?? 0,
            'lane_id'            => $laneId,
        ]);

        header('Location: ' . url('/products/' . $productId));
    }

    public function myListings(): void
    {
        $products = $this->productModel->allByOwner($_SESSION['user_id']);
        require __DIR__ . '/../views/products/my_listings.php';
    }

    public function updateStatus(int $id): void
    {
        $product = $this->productModel->find($id);
        if ($product && (int) $product['owner_id'] === (int) $_SESSION['user_id']) {
            $status = $_POST['status'] ?? 'available';
            $this->productModel->updateStatus($id, $status);
        }

        header('Location: ' . url('/products/my-listings'));
    }

    public function destroy(int $id): void
    {
        $product = $this->productModel->find($id);
        if ($product && (int) $product['owner_id'] === (int) $_SESSION['user_id']) {
            $this->productModel->delete($id);
        }

        header('Location: ' . url('/products/my-listings'));
    }

    public function requestProduct(int $id): void
    {
        $product = $this->productModel->find($id);
        if (!$product || $product['status'] !== 'available') {
            header('Location: ' . url('/products/' . $id));
            return;
        }

        $existing = $this->requestModel->findExisting($id, (int) $_SESSION['user_id']);
        if (!$existing) {
            $this->requestModel->create([
                'product_id'         => $id,
                'student_id'         => $_SESSION['user_id'],
                'student_name'       => trim($_POST['student_name'] ?? ($_SESSION['user_name'] ?? '')),
                'student_phone'      => trim($_POST['student_phone'] ?? ''),
                'quantity_requested' => $_POST['quantity_requested'] ?? 0,
                'message'            => trim($_POST['message'] ?? '') ?: null,
            ]);
        }

        header('Location: ' . url('/products/' . $id));
    }

    public function confirmRequest(int $requestId): void
    {
        $request = $this->requestModel->find($requestId);
        if ($request) {
            $product = $this->productModel->find((int) $request['product_id']);
            if ($product && (int) $product['owner_id'] === (int) $_SESSION['user_id']) {
                $totalPrice = (float) $request['quantity_requested'] * (float) $product['price_per_unit'];
                $this->requestModel->confirm($requestId, $totalPrice);
                header('Location: ' . url('/products/' . (int) $product['product_id']));
                return;
            }
        }

        header('Location: ' . url('/products/my-listings'));
    }

    public function declineRequest(int $requestId): void
    {
        $request = $this->requestModel->find($requestId);
        if ($request) {
            $product = $this->productModel->find((int) $request['product_id']);
            if ($product && (int) $product['owner_id'] === (int) $_SESSION['user_id']) {
                $this->requestModel->decline($requestId);
                header('Location: ' . url('/products/' . (int) $product['product_id']));
                return;
            }
        }

        header('Location: ' . url('/products/my-listings'));
    }

    public function myPurchases(): void
    {
        $requests = $this->requestModel->allByStudent($_SESSION['user_id']);
        require __DIR__ . '/../views/products/my_purchases.php';
    }
}
