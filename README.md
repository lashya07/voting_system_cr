# Voting System

This is a **PHP and MySQL-based online voting system** that allows students to vote for their Class Representative (CR) securely. It features OTP verification, an admin panel, real-time vote counting, and candidate profile management.

## Features
- **Student Registration & Login** (with email verification)
- **Secure OTP-based Voting** (via PHPMailer)
- **One Vote Per Student Enforcement**
- **Candidate Profiles with Name, Description**
- **Real-time Vote Count (without revealing individual votes)**
- **Admin Panel to Manage Candidates & View Results**
- **Voting Summary & Analytics** (graphs for vote breakdown)
- **CAPTCHA Protection** (prevents automated voting)
- **Mobile-Friendly UI**

---

## Installation Guide

### 1. Install XAMPP
Download and install XAMPP from: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)

### 2. Clone the Repository
```sh
git clone https://github.com/PAWANKUMAR7842/voting_system.git
```

### 3. Move Project to XAMPP htdocs Folder
Copy the **voting_system** folder into `C:\xampp\htdocs\`

### 4. Start Apache & MySQL in XAMPP
- Open **XAMPP Control Panel**
- Click **Start** for **Apache** and **MySQL**

### 5. Import the Database
- Open **phpMyAdmin** (`http://localhost/phpmyadmin/`)
- Create a new database: `vote`
- Click **Import**, select `sql/data.sql` from the project folder, and upload
- "While importing the data.sql file into phpMyAdmin. In that file, insert the details of the students who are allowed to vote, or include the complete list of students from your class."

### 6. Install Composer & PHPMailer (for OTPs)
- Install Composer from: [https://getcomposer.org/download/](https://getcomposer.org/download/)
- Open the **voting_system** folder in terminal and run:
  ```sh
  composer install
  ```

### 7. Configure PHPMailer
- Open `php/config.php`
- Update SMTP details for email verification:
  ```php
  define('SMTP_HOST', 'smtp.gmail.com');
  define('SMTP_USER', 'your-email@gmail.com');
  define('SMTP_PASS', 'your-email-password');
  define('SMTP_PORT', 587);
  ```

### 8. Run the Project
Open your browser and go to:
```
http://localhost/voting_system/htmll/login.html
```

---

## Admin Login
- **URL:** `http://localhost/voting_system/admin_lohin.php`
- **Username:** `admin`
- **Password:** `admin123`

---

## Candidate Photos
To add photos for candidates:
1. Upload images to `voting_system/uploads/`
2. Ensure the filename matches the candidate’s roll number (e.g., `12345.jpg` for roll number 12345)

---

## Contributing
If you find any issues, feel free to submit a pull request or report them in the issues section.

---

### 🔥 Happy Voting! 🚀
