-- ============================================================
-- COSMEET - Space Travel Reservation System
-- Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS cosmeet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cosmeet;

-- ============================================================
-- USERS TABLE
-- ============================================================
CREATE TABLE users (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid            CHAR(36) NOT NULL UNIQUE,
    first_name      VARCHAR(100) NOT NULL,
    last_name       VARCHAR(100) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    phone           VARCHAR(30),
    nationality     VARCHAR(100),
    date_of_birth   DATE,
    bio             TEXT,
    avatar_path     VARCHAR(500),
    role            ENUM('user','admin') NOT NULL DEFAULT 'user',
    status          ENUM('active','suspended','pending') NOT NULL DEFAULT 'active',
    email_verified  TINYINT(1) DEFAULT 0,
    reset_token     VARCHAR(255) NULL,
    reset_token_expires DATETIME NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_uuid (uuid)
) ENGINE=InnoDB;

-- ============================================================
-- SPACECRAFT TABLE
-- ============================================================
CREATE TABLE spacecraft (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(150) NOT NULL,
    model           VARCHAR(150),
    capacity        SMALLINT UNSIGNED NOT NULL,
    destination     VARCHAR(200) NOT NULL,
    launch_site     VARCHAR(200) NOT NULL,
    mission_duration_days SMALLINT UNSIGNED NOT NULL,
    safety_rating   DECIMAL(3,1) NOT NULL DEFAULT 5.0,
    description     TEXT,
    image_path      VARCHAR(500),
    status          ENUM('active','maintenance','retired') DEFAULT 'active',
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- MISSIONS TABLE
-- ============================================================
CREATE TABLE missions (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    spacecraft_id   INT UNSIGNED NOT NULL,
    title           VARCHAR(200) NOT NULL,
    slug            VARCHAR(220) NOT NULL UNIQUE,
    destination     VARCHAR(200) NOT NULL,
    description     TEXT,
    mission_type    ENUM('orbital','lunar','mars','station','deep_space') NOT NULL,
    launch_date     DATETIME NOT NULL,
    return_date     DATETIME NOT NULL,
    seats_total     SMALLINT UNSIGNED NOT NULL,
    seats_reserved  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    price_usd       DECIMAL(15,2) NOT NULL,
    status          ENUM('upcoming','boarding','launched','completed','cancelled') DEFAULT 'upcoming',
    difficulty_level ENUM('beginner','intermediate','advanced','expert') DEFAULT 'intermediate',
    image_path      VARCHAR(500),
    featured        TINYINT(1) DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (spacecraft_id) REFERENCES spacecraft(id) ON DELETE RESTRICT,
    INDEX idx_launch (launch_date),
    INDEX idx_status (status),
    INDEX idx_destination (destination)
) ENGINE=InnoDB;

-- ============================================================
-- RESERVATIONS TABLE
-- ============================================================
CREATE TABLE reservations (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reservation_code VARCHAR(20) NOT NULL UNIQUE,
    user_id         INT UNSIGNED NOT NULL,
    mission_id      INT UNSIGNED NOT NULL,
    seat_number     VARCHAR(10),
    status          ENUM('pending','confirmed','paid','cancelled','completed') DEFAULT 'pending',
    special_requests TEXT,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE RESTRICT,
    INDEX idx_user (user_id),
    INDEX idx_mission (mission_id),
    INDEX idx_code (reservation_code)
) ENGINE=InnoDB;

-- ============================================================
-- PAYMENTS TABLE
-- ============================================================
CREATE TABLE payments (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reservation_id  INT UNSIGNED NOT NULL,
    transaction_id  VARCHAR(100) NOT NULL UNIQUE,
    amount_usd      DECIMAL(15,2) NOT NULL,
    currency        VARCHAR(10) DEFAULT 'USD',
    payment_method  ENUM('credit_card','crypto','bank_transfer','simulation') DEFAULT 'simulation',
    status          ENUM('pending','processing','completed','failed','refunded') DEFAULT 'pending',
    card_last4      VARCHAR(4),
    card_brand      VARCHAR(20),
    receipt_path    VARCHAR(500),
    paid_at         DATETIME,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    INDEX idx_transaction (transaction_id)
) ENGINE=InnoDB;

-- ============================================================
-- READINESS ASSESSMENTS
-- ============================================================
CREATE TABLE readiness_assessments (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED NOT NULL,
    physical_score  TINYINT UNSIGNED NOT NULL DEFAULT 0,
    psychological_score TINYINT UNSIGNED NOT NULL DEFAULT 0,
    adventure_score TINYINT UNSIGNED NOT NULL DEFAULT 0,
    knowledge_score TINYINT UNSIGNED NOT NULL DEFAULT 0,
    total_score     TINYINT UNSIGNED NOT NULL DEFAULT 0,
    traveler_profile VARCHAR(100),
    feedback        TEXT,
    completed_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id)
) ENGINE=InnoDB;

-- ============================================================
-- SPACE PASSPORTS
-- ============================================================
CREATE TABLE space_passports (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED NOT NULL UNIQUE,
    passport_number VARCHAR(30) NOT NULL UNIQUE,
    traveler_rank   ENUM('Cadet','Explorer','Pioneer','Voyager','Commander','Admiral') DEFAULT 'Cadet',
    total_missions  TINYINT UNSIGNED DEFAULT 0,
    total_distance_km BIGINT UNSIGNED DEFAULT 0,
    badges          JSON,
    issued_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- JOURNEY TIMELINES
-- ============================================================
CREATE TABLE journey_timelines (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED NOT NULL,
    reservation_id  INT UNSIGNED,
    event_type      VARCHAR(60) NOT NULL,
    title           VARCHAR(200) NOT NULL,
    description     TEXT,
    event_date      DATETIME,
    status          ENUM('completed','active','upcoming','future') DEFAULT 'upcoming',
    icon            VARCHAR(50),
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE SET NULL,
    INDEX idx_user (user_id)
) ENGINE=InnoDB;

-- ============================================================
-- MISSION CREW / WAITLIST
-- ============================================================
CREATE TABLE mission_waitlist (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    mission_id  INT UNSIGNED NOT NULL,
    joined_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_mission (user_id, mission_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- MISSION LOGS (Unique Feature: Live Mission Updates)
-- ============================================================
CREATE TABLE mission_logs (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mission_id  INT UNSIGNED NOT NULL,
    log_time    DATETIME NOT NULL,
    title       VARCHAR(200) NOT NULL,
    content     TEXT,
    log_type    ENUM('pre_launch','launch','orbit','destination','return','post_mission') DEFAULT 'pre_launch',
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- SAMPLE DATA
-- ============================================================

-- Admin user (password: Admin@Cosmeet2026)
INSERT INTO users (uuid, first_name, last_name, email, password_hash, role, status, email_verified)
VALUES (
    UUID(),
    'Cosmo',
    'Admin',
    'admin@cosmeet.space',
    '$2y$12$LmkuJ5y3s0Sp8BkSwXNd5e4bP3ydKJ4mObhMKX2N4FjrPi1tJqQrO',
    'admin',
    'active',
    1
);

-- Spacecraft
INSERT INTO spacecraft (name, model, capacity, destination, launch_site, mission_duration_days, safety_rating, description, image_path) VALUES
('Cosmeet Aurora', 'CMT-X1', 12, 'Low Earth Orbit', 'Cape Canaveral, Florida', 7, 9.8, 'Our flagship orbital vessel, Aurora carries humanity''s dreams into orbit with unmatched luxury and safety. Equipped with panoramic observation domes and zero-gravity living quarters.', '/images/spacecraft/aurora.jpg'),
('Cosmeet Selene', 'CMT-L2', 8, 'Lunar Orbit', 'Vandenberg Space Force Base', 14, 9.5, 'Named after the goddess of the Moon, Selene is built for the ultimate lunar experience — floating above the craters of Earth''s closest neighbour.', '/images/spacecraft/selene.jpg'),
('Cosmeet Ares', 'CMT-M3', 6, 'Mars Flyby', 'Kennedy Space Center, Florida', 180, 9.2, 'The most ambitious commercial spacecraft ever constructed. Ares takes the boldest travelers on a flyby of the Red Planet — a 6-month odyssey through the solar system.', '/images/spacecraft/ares.jpg'),
('Cosmeet Helios', 'CMT-S4', 16, 'Cosmeet Station Alpha', 'Boca Chica, Texas', 10, 9.9, 'Our station shuttle, Helios ferries travelers to Cosmeet Station Alpha — our luxury orbital habitat 400km above Earth, offering two weeks of weightless wonder.', '/images/spacecraft/helios.jpg');

-- Missions
INSERT INTO missions (spacecraft_id, title, slug, destination, description, mission_type, launch_date, return_date, seats_total, seats_reserved, price_usd, status, difficulty_level, featured) VALUES
(1, 'Aurora Dawn — Orbital Sunrise Mission', 'aurora-dawn-orbital-sunrise', 'Low Earth Orbit', 'Watch 16 sunrises per day from 400km above Earth. The Aurora Dawn mission offers 7 days of orbital wonder, featuring spacewalk opportunities and the most breathtaking views of our home planet.', 'orbital', '2026-09-15 08:00:00', '2026-09-22 08:00:00', 12, 3, 250000.00, 'upcoming', 'beginner', 1),
(2, 'Selene Crescent — First Lunar Orbit', 'selene-crescent-lunar-orbit', 'Lunar Orbit', 'Become one of the few humans to orbit the Moon. Experience the profound silence of cislunar space, view the iconic Earthrise, and drift above the Sea of Tranquility where Apollo 11 landed.', 'lunar', '2026-11-20 06:00:00', '2026-12-04 06:00:00', 8, 2, 850000.00, 'upcoming', 'intermediate', 1),
(3, 'Ares Horizon — Mars Flyby Expedition', 'ares-horizon-mars-flyby', 'Mars Flyby', 'The boldest commercial mission ever offered. Over 180 days, you will travel to Mars, conduct a close flyby at 1,000km altitude, observe Olympus Mons and Valles Marineris up close, and return as one of the few civilians to have visited another planet.', 'mars', '2027-03-10 04:00:00', '2027-09-06 04:00:00', 6, 1, 4500000.00, 'upcoming', 'expert', 1),
(4, 'Station Alpha — Zero Gravity Retreat', 'station-alpha-zero-gravity-retreat', 'Cosmeet Station Alpha', 'Two weeks aboard humanity''s most luxurious orbital habitat. Station Alpha features private suites, a zero-gravity gymnasium, Earth observation lounge, and gourmet space cuisine prepared by Michelin-level culinary programs.', 'station', '2026-08-01 10:00:00', '2026-08-15 10:00:00', 16, 10, 380000.00, 'upcoming', 'beginner', 1);
