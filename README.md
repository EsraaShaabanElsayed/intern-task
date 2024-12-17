# **LAMP Stack Web Server Setup**

## **Overview**
This project sets up a simple PHP-based web application on a LAMP (Linux, Apache, MySQL, PHP) stack. The application connects to a MySQL database and displays the user's IP address and the current time. Sensitive database credentials are stored securely in a separate configuration file.

---

## **Table of Contents**
1. [Project Structure](#project-structure)
2. [Requirements](#requirements)
3. [Setup Instructions](#setup-instructions)
4. [Database Configuration](#database-configuration)
5. [Testing the Application](#testing-the-application)
6. [Security Notes](#security-notes)

---

## **1. Project Structure**

The project contains the following files:
```
/var/www/html/
│-- index.php       # Main PHP file to display the application
│-- config.php      # Database configuration file (excluded from version control)
```

---

## **2. Requirements**

To run this project, ensure you have the following:
- **Linux Server** (e.g., Ubuntu 20.04)
- **Apache Web Server**
- **MySQL Database**
- **PHP 7.4+**

---

## **3. Setup Instructions**

### **3.1 Install LAMP Stack**
Run the following commands to set up the LAMP stack:
```bash
sudo apt-get update
sudo apt-get install apache2 mysql-server php libapache2-mod-php php-mysql
```

### **3.2 Configure Apache**
1. Ensure the Apache server is running:
   ```bash
   sudo systemctl start apache2
   sudo systemctl enable apache2
   ```
2. Place the project files (`index.php` and `config.php`) in the `/var/www/html/` directory.

---

## **4. Database Configuration**

### **4.1 Create a MySQL Database**
1. Log in to MySQL:
   ```bash
   sudo mysql -u root -p
   ```
2. Run the following SQL commands to create a database, user, and grant permissions:
   ```sql
   CREATE DATABASE db_name;
   CREATE USER 'user_name'@'localhost' IDENTIFIED BY 'password';
   GRANT ALL PRIVILEGES ON db_name.* TO 'user_name'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

### **4.2 Configure Credentials**
1. Create a `config.php` file in the `/var/www/html` directory:
   ```php
   <?php
   $servername = "localhost";
   $username = "user_name";
   $password = "password";
   $dbname = "db_name";
   ?>
   ```

2. Update the `index.php` to include the configuration file:
   ```php
   require_once 'config.php';
   ```

---

## **5. Testing the Application**

1. Open your browser and navigate to your server's IP address:
   ```
   http://<your-server-ip>/
   ```
2. You should see a webpage displaying:
   - Your IP address.
   - The current server time.

---

## **6. Security Notes**

- **Exclude Sensitive Files**: Ensure `config.php` is not pushed to any public repository. Add the following to your `.gitignore` file:
   ```
   config.php
   ```

- **MySQL Password**: Use strong and unique passwords for the database user.

