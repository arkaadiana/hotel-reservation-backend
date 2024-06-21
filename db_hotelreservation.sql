-- Creating Database
CREATE DATABASE hotelreservation;
USE hotelreservation;

-- Creating Table Customer
CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20) NOT NULL UNIQUE
);

-- Creating Table Room
CREATE TABLE Room (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Creating Table Reservation
CREATE TABLE Reservation (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in_datetime DATETIME NOT NULL,
    check_out_datetime DATETIME NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (room_id) REFERENCES Room(room_id)
);

-- Adding Dummy Data to Table Customer
INSERT INTO Customer (name, email, phone_number) VALUES
('John Doe', 'john.doe@example.com', '1234567890'),
('Jane Smith', 'jane.smith@example.com', '0987654321'),
('Alice Johnson', 'alice.johnson@example.com', '5556667777'),
('Michael Brown', 'michael.brown@example.com', '1112223333'),
('Emily Davis', 'emily.davis@example.com', '4445556666'),
('David Wilson', 'david.wilson@example.com', '7778889999');

-- Adding Dummy Data to Table Room
INSERT INTO Room (room_type, price) VALUES
('Single', 50.00),
('Double', 75.00),
('Suite', 150.00),
('Single', 70.00),
('Double', 85.00),
('Suite', 200.00);

-- Adding Dummy Data to Table Reservation
INSERT INTO Reservation (customer_id, room_id, check_in_datetime, check_out_datetime, total_price) VALUES
(1, 1, '2024-06-01 14:00:00', '2024-06-05 11:00:00', 200.00),
(2, 2, '2024-06-10 15:00:00', '2024-06-15 12:00:00', 375.00),
(3, 3, '2024-06-20 16:00:00', '2024-06-25 10:00:00', 750.00);
