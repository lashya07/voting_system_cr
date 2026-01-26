CREATE DATABASE vote;
USE vote;

-- Students table
CREATE TABLE students (
    reg_no VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Insert a student
INSERT INTO students (reg_no, name, email) VALUES
('24535A0510', 'KOTHAVALA PAWAN KUMAR', 'pawankothavala78423@gmail.com');

-- Otps table
CREATE TABLE otps (
    email VARCHAR(100) PRIMARY KEY,
    otp_code VARCHAR(6) NOT NULL,
    expiry TIMESTAMP NOT NULL
);

-- Votes table
CREATE TABLE votes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE,
    candidate VARCHAR(50)
);

-- Candidates table
CREATE TABLE candidates (
    roll_number VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Insert candidates
INSERT INTO candidates (roll_number, name) VALUES
('24331A05M1', 'PRIYA'),
('24331A05M2', 'PAWAN'),
('24331A05M3', 'SAM');

-- Feedback table
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    feedback TEXT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
