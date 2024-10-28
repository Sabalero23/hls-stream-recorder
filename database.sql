// database.sql
CREATE DATABASE IF NOT EXISTS video_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE video_system;

CREATE TABLE IF NOT EXISTS recordings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    duration VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'deleted') DEFAULT 'active',
    mime_type VARCHAR(100) NOT NULL,
    user_ip VARCHAR(45),
    user_agent VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS stream_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    stream_url TEXT NOT NULL,
    session_id VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_accessed DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_ip VARCHAR(45),
    user_agent VARCHAR(255)
);