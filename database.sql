-- ============================================================
--  Flight Booking System – Database Schema
--  Import this file via phpMyAdmin
-- ============================================================

CREATE DATABASE IF NOT EXISTS flight_booking;
USE flight_booking;

-- ── 1. AIRPORTS ──────────────────────────────────────────────
CREATE TABLE airport (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    code     CHAR(3)      NOT NULL UNIQUE,   -- e.g. CGK, NRT
    name     VARCHAR(100) NOT NULL,
    city     VARCHAR(100) NOT NULL,
    country  VARCHAR(100) NOT NULL
);

-- ── 2. FLIGHTS ───────────────────────────────────────────────
CREATE TABLE flight (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    flight_number  VARCHAR(10)  NOT NULL UNIQUE,   -- e.g. GA-874
    airline        VARCHAR(100) NOT NULL,
    origin_id      INT          NOT NULL,
    destination_id INT          NOT NULL,
    departure_time DATETIME     NOT NULL,
    arrival_time   DATETIME     NOT NULL,
    FOREIGN KEY (origin_id)      REFERENCES airport(id),
    FOREIGN KEY (destination_id) REFERENCES airport(id)
);

-- ── 3. SEATS ─────────────────────────────────────────────────
CREATE TABLE seat (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    flight_id  INT         NOT NULL,
    seat_number VARCHAR(4) NOT NULL,          -- e.g. 12A
    class       ENUM('Economy','Business','First') NOT NULL DEFAULT 'Economy',
    price       DECIMAL(12,2) NOT NULL,
    is_booked   TINYINT(1) NOT NULL DEFAULT 0,
    UNIQUE KEY uq_flight_seat (flight_id, seat_number),   -- prevents double-booking
    FOREIGN KEY (flight_id) REFERENCES flight(id)
);

-- ── 4. RESERVATIONS ──────────────────────────────────────────
CREATE TABLE reservation (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    seat_id      INT          NOT NULL UNIQUE,   -- one seat = one booking (UNIQUE enforces it)
    passenger_name  VARCHAR(100) NOT NULL,
    passenger_email VARCHAR(150) NOT NULL,
    passenger_phone VARCHAR(20)  NOT NULL,
    booking_code VARCHAR(10)  NOT NULL UNIQUE,
    booked_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seat_id) REFERENCES seat(id)
);

-- ── SAMPLE DATA ───────────────────────────────────────────────
INSERT INTO airport (code, name, city, country) VALUES
('CGK', 'Soekarno-Hatta International', 'Jakarta',  'Indonesia'),
('NRT', 'Narita International',          'Tokyo',    'Japan'),
('DPS', 'Ngurah Rai International',      'Bali',     'Indonesia'),
('ICN', 'Incheon International',         'Seoul',    'South Korea'),
('LHR', 'Heathrow',                      'London',   'United Kingdom');

INSERT INTO flight (flight_number, airline, flight.origin_id, flight.destination_id, departure_time, arrival_time) VALUES
('GA-874',  'Garuda Indonesia', 1, 2, '2026-05-19 09:15:00', '2026-05-19 18:30:00'),
('GA-101',  'Garuda Indonesia', 1, 3, '2026-05-20 07:00:00', '2026-05-20 09:30:00'),
('SQ-452',  'Singapore Airlines',1, 4, '2026-05-21 11:00:00', '2026-05-21 19:00:00'),
('BA-017',  'British Airways',  1, 5, '2026-05-22 23:55:00', '2026-05-23 06:20:00'),
('JT-568',  'Lion Air',         3, 1, '2026-05-25 13:00:00', '2026-05-25 15:30:00');

-- Seats for flight 1 (GA-874, Economy & Business)
INSERT INTO seat (flight_id, seat_number, class, price, is_booked) VALUES
(1,'1A','Business',  4500000,0),(1,'1B','Business',  4500000,0),(1,'1C','Business',  4500000,0),
(1,'2A','Business',  4500000,0),(1,'2B','Business',  4500000,0),(1,'2C','Business',  4500000,0),
(1,'10A','Economy',  1800000,0),(1,'10B','Economy',  1800000,0),(1,'10C','Economy',  1800000,0),
(1,'10D','Economy',  1800000,0),(1,'10E','Economy',  1800000,0),(1,'10F','Economy',  1800000,0),
(1,'11A','Economy',  1800000,0),(1,'11B','Economy',  1800000,0),(1,'11C','Economy',  1800000,0),
(1,'11D','Economy',  1800000,0),(1,'11E','Economy',  1800000,0),(1,'11F','Economy',  1800000,0),
(1,'12A','Economy',  1800000,1),(1,'12B','Economy',  1800000,1),(1,'12C','Economy',  1800000,0),
(1,'13A','Economy',  1800000,0),(1,'13B','Economy',  1800000,1),(1,'13C','Economy',  1800000,0),
(1,'14A','Economy',  1800000,0),(1,'14B','Economy',  1800000,0),(1,'14C','Economy',  1800000,0),
(1,'14D','Economy',  1800000,0),(1,'14E','Economy',  1800000,0),(1,'14F','Economy',  1800000,0);

-- Seats for flight 2 (GA-101)
INSERT INTO seat (flight_id, seat_number, class, price, is_booked) VALUES
(2,'1A','Business',3500000,0),(2,'1B','Business',3500000,0),
(2,'10A','Economy',800000,0),(2,'10B','Economy',800000,0),(2,'10C','Economy',800000,0),
(2,'11A','Economy',800000,0),(2,'11B','Economy',800000,1),(2,'11C','Economy',800000,0),
(2,'12A','Economy',800000,0),(2,'12B','Economy',800000,0),(2,'12C','Economy',800000,0);

-- Seats for flight 3 (SQ-452)
INSERT INTO seat (flight_id, seat_number, class, price, is_booked) VALUES
(3,'1A','First',8000000,0),(3,'1B','First',8000000,0),
(3,'5A','Business',5500000,0),(3,'5B','Business',5500000,0),(3,'5C','Business',5500000,0),
(3,'15A','Economy',2200000,0),(3,'15B','Economy',2200000,0),(3,'15C','Economy',2200000,1),
(3,'16A','Economy',2200000,0),(3,'16B','Economy',2200000,0),(3,'16C','Economy',2200000,0);

-- Seats for flight 4 (BA-017)
INSERT INTO seat (flight_id, seat_number, class, price, is_booked) VALUES
(4,'1A','First',12000000,0),(4,'1B','First',12000000,0),
(4,'5A','Business',7500000,0),(4,'5B','Business',7500000,0),
(4,'20A','Economy',3800000,0),(4,'20B','Economy',3800000,0),(4,'20C','Economy',3800000,0),
(4,'21A','Economy',3800000,1),(4,'21B','Economy',3800000,0),(4,'21C','Economy',3800000,0);

-- Seats for flight 5 (JT-568)
INSERT INTO seat (flight_id, seat_number, class, price, is_booked) VALUES
(5,'1A','Business',2000000,0),(5,'1B','Business',2000000,0),
(5,'10A','Economy',650000,0),(5,'10B','Economy',650000,0),(5,'10C','Economy',650000,0),
(5,'11A','Economy',650000,1),(5,'11B','Economy',650000,0),(5,'11C','Economy',650000,0);
