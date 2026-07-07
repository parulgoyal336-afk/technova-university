CREATE DATABASE IF NOT EXISTS smart_college_db;
USE smart_college_db;

-- Table for Admin Users
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Students
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    dob DATE,
    address TEXT,
    profile_pic VARCHAR(255) DEFAULT 'default_profile.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Courses
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    course_code VARCHAR(20) NOT NULL UNIQUE,
    description TEXT,
    duration VARCHAR(50),
    fees DECIMAL(10, 2),
    faculty_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Student Enrollments
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Table for Attendance
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    attendance_date DATE,
    status ENUM('Present', 'Absent', 'Late') DEFAULT 'Present',
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Table for Marks / Grades
CREATE TABLE IF NOT EXISTS marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    subject_name VARCHAR(100),
    marks_obtained INT,
    max_marks INT DEFAULT 100,
    grade VARCHAR(2),
    exam_date DATE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Table for Notifications / Announcements
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    target_role ENUM('All', 'Student', 'Admin') DEFAULT 'All',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default Admin user (password: admin123)
INSERT INTO admins (username, password, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@college.com');
