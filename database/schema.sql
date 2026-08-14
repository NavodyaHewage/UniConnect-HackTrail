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

CREATE TABLE Lanes (
    lane_id INT AUTO_INCREMENT PRIMARY KEY,
    lane_name VARCHAR(100) NOT NULL UNIQUE,
    agent_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES Users(user_id)
);

CREATE TABLE Boardings (
    boarding_id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    owner_phone VARCHAR(20) NOT NULL,
    owner_address VARCHAR(255),
    title VARCHAR(150) NOT NULL,
    rent_amount DECIMAL(10,2) NOT NULL,
    distance_km DECIMAL(3,1) NOT NULL,
    status ENUM('available', 'occupied') DEFAULT 'available',
    photo_path VARCHAR(255),
    photo_path_2 VARCHAR(255),
    photo_path_3 VARCHAR(255),
    pdf_path VARCHAR(255),
    lane_id INT,
    ad_fee DECIMAL(10,2) NOT NULL DEFAULT 500.00,
    FOREIGN KEY (owner_id) REFERENCES Users(user_id),
    FOREIGN KEY (lane_id) REFERENCES Lanes(lane_id)
);

CREATE TABLE BoardingRequests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    boarding_id INT NOT NULL,
    student_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    student_phone VARCHAR(20) NOT NULL,
    message VARCHAR(255),
    status ENUM('pending', 'confirmed', 'declined') DEFAULT 'pending',
    tip_amount DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (boarding_id) REFERENCES Boardings(boarding_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Users(user_id)
);

CREATE TABLE Jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    posted_by INT NOT NULL,
    poster_name VARCHAR(100) NOT NULL,
    poster_phone VARCHAR(20) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    budget DECIMAL(10,2) NOT NULL,
    status ENUM('open', 'assigned', 'completed') DEFAULT 'open',
    category ENUM('software', 'hardware') NOT NULL DEFAULT 'software',
    views INT NOT NULL DEFAULT 0,
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

CREATE TABLE Classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT NOT NULL,
    tutor_name VARCHAR(100) NOT NULL,
    tutor_phone VARCHAR(20) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    class_type ENUM('individual', 'group') NOT NULL DEFAULT 'individual',
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    max_students INT NOT NULL DEFAULT 1,
    schedule VARCHAR(150),
    status ENUM('open', 'closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_id) REFERENCES Users(user_id)
);

CREATE TABLE ClassEnrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    student_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    student_phone VARCHAR(20) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(class_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Users(user_id)
);

CREATE TABLE Riders (
    rider_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL UNIQUE,
    student_name VARCHAR(100) NOT NULL,
    student_phone VARCHAR(20) NOT NULL,
    vehicle_type ENUM('bicycle', 'motorbike', 'three_wheeler') NOT NULL,
    vehicle_model VARCHAR(100),
    registration_number VARCHAR(50),
    seats_available INT NOT NULL DEFAULT 1,
    status ENUM('available', 'offline') DEFAULT 'available',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES Users(user_id)
);

CREATE TABLE HelpRequests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    posted_by INT NOT NULL,
    villager_name VARCHAR(100) NOT NULL,
    villager_phone VARCHAR(20) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('software', 'hardware', 'general') NOT NULL DEFAULT 'general',
    reward_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('open', 'assigned', 'completed') DEFAULT 'open',
    assigned_student_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES Users(user_id),
    FOREIGN KEY (assigned_student_id) REFERENCES Users(user_id)
);

CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    owner_phone VARCHAR(20) NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    category ENUM('spices', 'tea', 'mushroom', 'vegetables', 'fruits', 'other') NOT NULL DEFAULT 'other',
    description TEXT,
    price_per_unit DECIMAL(10,2) NOT NULL,
    unit VARCHAR(20) NOT NULL DEFAULT 'kg',
    quantity_available DECIMAL(10,2) NOT NULL DEFAULT 0,
    lane_id INT,
    status ENUM('available', 'sold_out') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES Users(user_id),
    FOREIGN KEY (lane_id) REFERENCES Lanes(lane_id)
);

CREATE TABLE ProductRequests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    student_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    student_phone VARCHAR(20) NOT NULL,
    quantity_requested DECIMAL(10,2) NOT NULL,
    message VARCHAR(255),
    status ENUM('pending', 'confirmed', 'declined') DEFAULT 'pending',
    total_price DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Users(user_id)
);
