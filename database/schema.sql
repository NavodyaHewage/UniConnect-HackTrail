-- UniConnect database schema
-- Run against an empty `uniconnect` database.

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_role ENUM('student', 'villager', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Vehicles (
    vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    vehicle_type ENUM('bicycle', 'three_wheeler') NOT NULL,
    registration_number VARCHAR(50) DEFAULT 'N/A',
    model_name VARCHAR(50),
    seats_available INT DEFAULT 1,
    status ENUM('available', 'busy', 'offline') DEFAULT 'available',
    FOREIGN KEY (owner_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE Rides (
    ride_id INT AUTO_INCREMENT PRIMARY KEY,
    driver_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    pickup_location VARCHAR(150) NOT NULL,
    drop_location VARCHAR(150) NOT NULL,
    fare_amount DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    ride_status ENUM('requested','accepted','in_progress','completed','cancelled') DEFAULT 'requested',
    passenger_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    pickup_lat DECIMAL(9,6),
    pickup_lng DECIMAL(9,6),
    FOREIGN KEY (driver_id) REFERENCES Users(user_id),
    FOREIGN KEY (passenger_id) REFERENCES Users(user_id),
    FOREIGN KEY (vehicle_id) REFERENCES Vehicles(vehicle_id)
);

CREATE TABLE Boardings (
    boarding_id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    rent_amount DECIMAL(10,2) NOT NULL,
    distance_km DECIMAL(3,1) NOT NULL,
    status ENUM('available', 'occupied') DEFAULT 'available',
    latitude DECIMAL(9,6),
    longitude DECIMAL(9,6),
    FOREIGN KEY (owner_id) REFERENCES Users(user_id)
);

CREATE TABLE BoardingInterests (
    interest_id INT AUTO_INCREMENT PRIMARY KEY,
    boarding_id INT NOT NULL,
    student_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_interest (boarding_id, student_id),
    FOREIGN KEY (boarding_id) REFERENCES Boardings(boarding_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE Jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    posted_by INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    budget DECIMAL(10,2) NOT NULL,
    status ENUM('open', 'assigned', 'completed') DEFAULT 'open',
    latitude DECIMAL(9,6),
    longitude DECIMAL(9,6),
    FOREIGN KEY (posted_by) REFERENCES Users(user_id)
);

CREATE TABLE Skills (
    skill_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    verification_source VARCHAR(150),
    is_verified BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE SkillSwaps (
    swap_id INT AUTO_INCREMENT PRIMARY KEY,
    offered_by INT NOT NULL,
    requested_by INT NOT NULL,
    service_offered VARCHAR(150) NOT NULL,
    item_exchanged VARCHAR(150) NOT NULL,
    status ENUM('proposed','accepted','completed','cancelled') DEFAULT 'proposed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (offered_by) REFERENCES Users(user_id),
    FOREIGN KEY (requested_by) REFERENCES Users(user_id)
);
