-- ============================================================
-- FULLY NORMALIZED FLIGHT BOOKING SCHEMA
-- ============================================================

DROP DATABASE IF EXISTS flight_booking;
CREATE DATABASE flight_booking;
USE flight_booking;

-- ── 1. REFERENCE DATA ────────────────────────────────────────

CREATE TABLE airline (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code CHAR(2) NOT NULL UNIQUE,       -- e.g., GA
    name VARCHAR(100) NOT NULL          -- e.g., Garuda Indonesia
);

CREATE TABLE airport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code CHAR(3) NOT NULL UNIQUE,       -- e.g., CGK
    name VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL
);

CREATE TABLE aircraft (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model_name VARCHAR(100) NOT NULL    -- e.g., Boeing 777-300ER
);

-- ── 2. SEAT LAYOUT (Stored ONCE per aircraft type) ───────────

CREATE TABLE aircraft_seat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aircraft_id INT NOT NULL,
    seat_number VARCHAR(4) NOT NULL,    -- e.g., 1A, 12F
    travel_class ENUM('Economy','Business','First') NOT NULL,
    UNIQUE KEY uq_aircraft_seat (aircraft_id, seat_number),
    FOREIGN KEY (aircraft_id) REFERENCES aircraft(id) ON DELETE CASCADE
);

-- ── 3. FLIGHT ROUTES & SCHEDULES ─────────────────────────────

-- The generic route (e.g., GA-874 from Jakarta to Tokyo)
CREATE TABLE flight_route (
    id INT AUTO_INCREMENT PRIMARY KEY,
    airline_id INT NOT NULL,
    flight_number VARCHAR(10) NOT NULL UNIQUE, 
    origin_id INT NOT NULL,
    destination_id INT NOT NULL,
    FOREIGN KEY (airline_id) REFERENCES airline(id),
    FOREIGN KEY (origin_id) REFERENCES airport(id),
    FOREIGN KEY (destination_id) REFERENCES airport(id)
);

-- The specific instance of that flight on a given date/time
CREATE TABLE flight_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_route_id INT NOT NULL,
    aircraft_id INT NOT NULL,           -- Tells us which seat map to load
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    FOREIGN KEY (flight_route_id) REFERENCES flight_route(id),
    FOREIGN KEY (aircraft_id) REFERENCES aircraft(id)
);

-- ── 4. DYNAMIC PRICING ───────────────────────────────────────

-- Prices are set per schedule and class, NOT per individual seat.
CREATE TABLE flight_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_schedule_id INT NOT NULL,
    travel_class ENUM('Economy','Business','First') NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    UNIQUE KEY uq_schedule_class (flight_schedule_id, travel_class),
    FOREIGN KEY (flight_schedule_id) REFERENCES flight_schedule(id) ON DELETE CASCADE
);

-- ── 5. TRANSACTIONS & TICKETS ────────────────────────────────

-- The master checkout record (Who bought it and when)
CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(10) NOT NULL UNIQUE,
    contact_email VARCHAR(150) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    booked_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- The individual passenger assignments
CREATE TABLE ticket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    flight_schedule_id INT NOT NULL,
    passenger_name VARCHAR(100) NOT NULL,
    travel_class ENUM('Economy','Business','First') NOT NULL,
    seat_number VARCHAR(4) NOT NULL,
    
    -- The most important constraint: prevents double-booking a physical seat on a specific schedule
    UNIQUE KEY uq_seat_taken (flight_schedule_id, seat_number),
    
    FOREIGN KEY (booking_id) REFERENCES booking(id) ON DELETE CASCADE,
    FOREIGN KEY (flight_schedule_id) REFERENCES flight_schedule(id)
);