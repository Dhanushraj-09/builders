-- =====================================================
-- CELTA Builder Database Schema
-- Database: builder_company_db
-- =====================================================

CREATE DATABASE IF NOT EXISTS builder_company_db;
USE builder_company_db;

-- -----------------------------------------------------
-- Table: admins
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table: projects
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    client_name VARCHAR(150) DEFAULT NULL,
    location VARCHAR(255) DEFAULT NULL,
    budget VARCHAR(100) DEFAULT NULL,
    square_feet VARCHAR(100) DEFAULT NULL,
    status ENUM('ongoing','completed','upcoming','on_hold') DEFAULT 'upcoming',
    description TEXT,
    testimonial TEXT,
    rating INT DEFAULT 5,
    video VARCHAR(500) DEFAULT NULL,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table: project_images
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS project_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    image VARCHAR(500) NOT NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table: services
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100) DEFAULT 'fa-building',
    image VARCHAR(500) DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table: notifications
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(500) NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table: contacts
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(20) NOT NULL,
    construction_type VARCHAR(100) DEFAULT NULL,
    budget_range VARCHAR(100) DEFAULT NULL,
    location VARCHAR(255) DEFAULT NULL,
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- Default Data
-- =====================================================

-- Default admin (password: admin123)
INSERT INTO admins (username, password) VALUES
('admin', '$2y$10$funpvtRBXuEACTPHCtnGxuaFrJz5hENT2hY.09eOfEm9XDHBrtRiu');

-- Sample Services
INSERT INTO services (title, description, icon, image, sort_order) VALUES
('Residential Construction', 'Premium house construction including villas, duplex homes, and modern luxury residences. We deliver dream homes with quality materials and expert craftsmanship.', 'fa-house', 'residential.png', 1),
('Commercial Construction', 'Professional construction of office buildings, shops, warehouses, hotels, showrooms, and commercial complexes with industry-leading standards.', 'fa-building', 'commercial.png', 2),
('Interior Works', 'Complete interior solutions including modular kitchen, false ceiling, interior decoration, and premium finishing works for residential and commercial spaces.', 'fa-couch', 'interior.png', 3),
('Renovation Services', 'Transform your existing spaces with our expert renovation services. From structural changes to complete makeovers, we bring new life to old buildings.', 'fa-hammer', 'renovation.png', 4),
('Electrical Works', 'Complete electrical solutions for residential and commercial buildings including wiring, panel installation, automation, and safety systems.', 'fa-bolt', 'electrical.png', 5),
('Architecture & Design', 'Professional architectural planning, 2D/3D elevation design, building plan approval assistance, structural design, and engineering consultation.', 'fa-compass-drafting', 'architecture.png', 6);

-- Sample Notifications
INSERT INTO notifications (message, status) VALUES
('🏗️ New luxury villa project launched in Srivilliputhur — Inquire now!', 'active'),
('✅ Commercial office building project completed successfully in Sivakasi', 'active'),
('🎉 Special festive season offer on residential construction — Contact us today!', 'active'),
('📢 Now offering 3D elevation design services for all new projects', 'active');

-- Sample Projects
INSERT INTO projects (title, slug, client_name, location, budget, square_feet, status, description, testimonial, rating, featured, start_date, end_date) VALUES
('Modern Luxury Villa', 'modern-luxury-villa', 'Mr. Rajesh Kumar', 'Srivilliputhur, Tamil Nadu', '₹85 Lakhs', '3500', 'completed', 'A stunning 3-bedroom luxury villa featuring modern architecture, spacious interiors, premium Italian marble flooring, modular kitchen, and landscaped garden. Built with earthquake-resistant RCC structure and energy-efficient design.', 'Exceptional quality and professional approach. The team delivered our dream home on time and within budget. Every detail was perfect. Highly recommended!', 5, 1, '2025-01-15', '2025-11-20'),
('Commercial Office Complex', 'commercial-office-complex', 'Sri Lakshmi Enterprises', 'Sivakasi, Tamil Nadu', '₹2.5 Crores', '12000', 'completed', 'A state-of-the-art 4-floor commercial office complex with modern facade, spacious cabins, conference rooms, parking basement, and complete fire safety systems. Built to international commercial standards.', 'Outstanding construction quality and professionalism. The project was completed ahead of schedule with zero defects. A truly reliable builder.', 5, 1, '2024-06-01', '2025-08-30'),
('Duplex Residence', 'duplex-residence', 'Mrs. Meena Devi', 'Virudhunagar, Tamil Nadu', '₹55 Lakhs', '2400', 'completed', 'An elegant duplex residence with 4 bedrooms, double-height living room, terrace garden, modern kitchen, and premium woodwork. Features Vastu-compliant design and eco-friendly construction.', 'From planning to handover, every step was transparent and professional. The construction quality exceeded our expectations. Thank you for building our beautiful home!', 5, 1, '2025-03-10', '2025-12-15'),
('Premium Apartment Complex', 'premium-apartment-complex', 'Vetri Housing Pvt Ltd', 'Madurai, Tamil Nadu', '₹8 Crores', '45000', 'ongoing', 'A premium 24-unit apartment complex with world-class amenities including swimming pool, gym, clubhouse, children play area, and 24/7 security. Each unit features smart home automation and premium finishes.', NULL, 0, 1, '2025-09-01', NULL),
('Warehouse & Factory', 'warehouse-factory', 'Patel Industries', 'Sivakasi Industrial Area', '₹1.2 Crores', '15000', 'ongoing', 'A large-scale industrial warehouse with factory setup, heavy-duty flooring, ventilation systems, loading dock, and complete electrical infrastructure. Built to withstand heavy industrial usage.', NULL, 0, 0, '2026-01-15', NULL),
('Modern Showroom', 'modern-showroom', 'Kumar Textiles', 'Srivilliputhur Main Road', '₹45 Lakhs', '1800', 'upcoming', 'A contemporary showroom design with glass facade, modern lighting, display areas, customer lounge, and storage facilities. Designed for maximum customer engagement and brand visibility.', NULL, 0, 0, NULL, NULL);

-- Add dummy videos to projects
UPDATE projects SET video = 'https://www.youtube.com/embed/tgbNymZ7vqY';

-- Sample Project Images
INSERT INTO project_images (project_id, image, sort_order) VALUES
(1, 'villa.png', 1),
(1, 'sample.mp4', 2),
(2, 'office.png', 1),
(3, 'duplex.png', 1),
(4, 'apartment.png', 1),
(4, 'sample.mp4', 2),
(5, 'warehouse.png', 1),
(6, 'showroom.png', 1);
