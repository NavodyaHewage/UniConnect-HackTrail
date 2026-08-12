<?php

require_once __DIR__ . '/../models/Ride.php';
require_once __DIR__ . '/../models/Vehicle.php';

class RideController
{
    private Ride $rideModel;
    private Vehicle $vehicleModel;

    public function __construct()
    {
        $this->rideModel    = new Ride();
        $this->vehicleModel = new Vehicle();
    }

    public function showRequestForm(): void
    {
        require __DIR__ . '/../views/rides/request_ride.php';
    }

    public function requestRide(): void
    {
        $this->rideModel->requestRide([
            'driver_id'       => $_POST['driver_id'],
            'vehicle_id'      => $_POST['vehicle_id'],
            'pickup_location' => trim($_POST['pickup_location'] ?? ''),
            'drop_location'   => trim($_POST['drop_location'] ?? ''),
            'fare_amount'     => $_POST['fare_amount'] ?? 0,
            'passenger_id'    => $_SESSION['user_id'],
            'pickup_lat'      => $_POST['pickup_lat'] ?? null,
            'pickup_lng'      => $_POST['pickup_lng'] ?? null,
        ]);

        header('Location: ' . url('/rides/status'));
    }

    public function showOfferForm(): void
    {
        $vehicles = $this->vehicleModel->allByOwner($_SESSION['user_id']);
        require __DIR__ . '/../views/rides/offer_ride.php';
    }

    public function toggleAvailability(): void
    {
        $vehicleId = (int) ($_POST['vehicle_id'] ?? 0);
        $status    = $_POST['status'] ?? 'available';
        $this->vehicleModel->updateStatus($vehicleId, $status);
        header('Location: ' . url('/rides/offer'));
    }

    public function status(int $id): void
    {
        $ride = $this->rideModel->find($id);
        require __DIR__ . '/../views/rides/ride_status.php';
    }

    public function updateStatus(int $id): void
    {
        $status = $_POST['status'] ?? 'requested';
        $this->rideModel->updateStatus($id, $status);
        header('Location: ' . url('/rides/status/' . $id));
    }
}
