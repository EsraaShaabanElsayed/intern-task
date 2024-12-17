# **LAMP Stack Web Server Setup on AWS EC2**

## **Overview**

This repository provides instructions for setting up a **LAMP (Linux, Apache, MySQL, PHP)** stack on an **AWS EC2 instance**. The project demonstrates configuring a PHP-based web application that connects to a MySQL database. The web application displays the user's IP address and the current server time. Sensitive data, such as database credentials, is securely stored in a configuration file (`config.php`), which is excluded from the public repository for security.

---

## **Table of Contents**
1. [Prerequisites](#prerequisites)
2. [Clone the Repository](#clone-the-repository)
3. [EC2 Instance Setup](#ec2-instance-setup)
4. [LAMP Stack Installation](#lamp-stack-installation)
5. [Database Configuration](#database-configuration)
6. [Application Setup](#application-setup)
7. [Testing and Access](#testing-and-access)
8. [Networking Basics](#networking-basics)
9.[Conclusion](#conclusion)
   

---

## **1. Prerequisites**

Before starting with the setup, make sure you have:

- An **AWS account** to create and manage EC2 instances.
- **SSH access** to your EC2 instance via a `.pem` key pair.
- **Basic knowledge of Linux commands** and working with SSH.

---

## **2. Clone the Repository**

To begin, clone the repository to your local machine or directly onto your EC2 instance. In your terminal, run the following commands:

```bash
git clone https://github.com/EsraaShaabanElsayed/lamp-stack-ec2-deployment.git
cd lamp-stack-ec2-deployment
```

This will download the project files to your machine or instance.

---

## **3. EC2 Instance Setup**

### **3.1 Launch an EC2 Instance**

Follow these steps to create and configure an EC2 instance:

1. **Log in to the AWS Management Console** and navigate to the **EC2 Dashboard**.
2. **Launch a new instance**:
   - Select **Ubuntu Server 20.04 LTS** as the AMI (Amazon Machine Image).
   - Choose an instance type (e.g., `t2.micro` for the free tier).
   - Configure the **security group** to allow:
     - **SSH (port 22)**: For remote access to the server.
     - **HTTP (port 80)**: To allow web traffic.
3. **Create a new SSH key pair** and download the `.pem` file to access the instance securely.

### **3.2 Connect to the EC2 Instance**

Once your EC2 instance is running, connect to it via SSH:

```bash
ssh -i /path/to/your-key.pem ubuntu@<your-ec2-public-ip>
```

Replace `<your-ec2-public-ip>` with the actual public IP of your EC2 instance.

---

## **4. LAMP Stack Installation**

### **4.1 Update the System**

Ensure the system is up-to-date before proceeding with any installations:

```bash
sudo apt-get update
```

### **4.2 Install Apache, MySQL, and PHP**

Install the necessary packages to set up the LAMP stack:

```bash
sudo apt-get install apache2 mysql-server php libapache2-mod-php php-mysql -y
```

### **4.3 Start Apache Server**

Enable and start Apache to serve your website:

```bash
sudo systemctl start apache2
sudo systemctl enable apache2
```

### **4.4 Verify Apache Installation**

To verify that Apache is running, visit the EC2 instance's public IP address in a browser:

```
http://<your-ec2-public-ip>
```

You should see the default Apache welcome page.

---

## **5. Database Configuration**

### **5.1 Secure MySQL Installation**

Run the MySQL secure installation script to configure your database:

```bash
sudo mysql_secure_installation
```

Follow the prompts to configure the root password and secure your installation.

### **5.2 Create a MySQL Database and User**

Log in to MySQL and create a new database and user:

```bash
sudo mysql -u root -p
```

Inside the MySQL shell, run the following commands:

```sql
CREATE DATABASE web_db;
CREATE USER 'web_user'@'localhost' IDENTIFIED BY 'StrongPassword123';
GRANT ALL PRIVILEGES ON web_db.* TO 'web_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

This creates a database named `web_db` and a user `web_user` with access to the database.

---

## **6. Application Setup**

### **6.1 Clone and Copy Files from GitHub Repository**

1. SSH into your EC2 instance (if not already done).
2. Install Git if it isn't already installed:

   ```bash
   sudo apt-get install git -y
   ```

3. Clone your GitHub repository into the `/var/www/html` directory:

   ```bash
   cd /var/www/html
   git clone https://github.com/EsraaShaabanElsayed/lamp-stack-ec2-deployment.git .
   ```

   The `.` ensures that files are cloned directly into the web root directory.

### **6.2 Create `config.php` for Database Credentials**

Create a `config.php` file in the `/var/www/html` directory:

```bash
sudo nano /var/www/html/config.php
```

Add the following content (update with your credentials):

```php
<?php
$servername = "localhost";
$username = "web_user";
$password = "StrongPassword123";
$dbname = "web_db";
?>
```


## **7. Testing and Access**

1. Restart Apache to apply the changes:

   ```bash
   sudo systemctl restart apache2
   ```

2. Open a web browser and navigate to your EC2 instance's public IP address:

   ```
   http://<your-ec2-public-ip>/
   ```

3. You should see the PHP page displaying your **IP address** and the **current time**.

---
![Screenshot from 2024-12-17 14-19-25](https://github.com/user-attachments/assets/837f28f7-3db7-432c-9ab8-2df04187b1f0)


## **8. Networking Basics**

### **1. IP Address: What It Is and Its Purpose in Networking**

An **IP address** (Internet Protocol address) is a unique identifier assigned to every device connected to a network, such as a computer, server, or router. Its main purpose is to allow devices to **communicate with each other** over the internet or within a local area network (LAN). The IP address ensures that data packets sent across the network reach the correct destination.

There are two main versions of IP addresses:
- **IPv4**: The most commonly used version, consisting of four sets of numbers separated by dots (e.g., `192.168.1.1`).
- **IPv6**: A newer version designed to handle a larger number of devices. It consists of eight sets of hexadecimal numbers separated by colons (e.g., `2001:0db8:85a3:0000:0000:8a2e:0370:7334`).

In networking, **routing** is based on IP addresses, where routers use these addresses to direct data packets between devices across different networks. 

### **2. MAC Address: What It Is, Its Purpose, and How It Differs from an IP Address**

A **MAC address** (Media Access Control address) is a unique hardware identifier assigned to the **network interface card (NIC)** of a device, such as a computer's Ethernet or Wi-Fi adapter. Unlike an IP address, which can change based on the network the device is connected to, the MAC address is **permanently assigned** and used to identify the device at the **data link layer** of the network.

**Purpose of MAC address:**
- MAC addresses are used for communication within a local network. Devices use their MAC addresses to send and receive data frames in the same network.
- They play a key role in **Ethernet networks** or wireless communication (Wi-Fi).

**Difference between IP and MAC address:**
- **IP Address**: Used for **routing** data packets across networks (Layer 3 in the OSI model). It can be changed based on the network configuration (e.g., dynamic IPs).
- **MAC Address**: Used for identifying devices on the same local network and **communicating at the hardware level** (Layer 2 in the OSI model). It does not change and is tied to the device's network hardware.

### **3. Switches, Routers, and Routing Protocols: Basic Definitions and Their Roles in a Network**

- **Switch**: A **network device** that connects devices within a **local network (LAN)**, such as computers, printers, and servers. It operates at the **data link layer (Layer 2)** of the OSI model and forwards data frames between devices based on their MAC addresses. Unlike a hub, which sends data to all devices, a switch only sends data to the intended device, increasing network efficiency.
  - **Role**: The main role of a switch is to **manage local traffic** within a network and ensure that data is sent only to the device that needs it.

- **Router**: A **network device** that connects multiple networks, such as a local network (LAN) to the internet. It operates at the **network layer (Layer 3)** of the OSI model and **routes data packets** between different networks using **IP addresses**. Routers determine the most efficient path for data to travel and forward packets accordingly.
  - **Role**: The router's primary role is to **forward data between networks**. For example, it directs data from your local network to the wider internet.

- **Routing Protocols**: These are sets of rules used by **routers** to determine the **best path** for data to travel between networks. Some common routing protocols are:
  - **RIP (Routing Information Protocol)**: A distance-vector protocol that uses the number of hops to determine the best path.
  - **OSPF (Open Shortest Path First)**: A link-state protocol that uses the state of the network links to determine the best path.
  - **BGP (Border Gateway Protocol)**: A protocol used between different networks (or autonomous systems) to share routing information.

  **Role**: Routing protocols ensure that routers can dynamically adapt to changes in the network (like new routes or failures) and continue to route data efficiently.

### **4. Remote Connection to Cloud Instance: Steps to Connect via SSH**

To connect to your **cloud-based Linux instance** (e.g., AWS EC2) from a remote machine, you would typically use **SSH (Secure Shell)**. SSH allows you to securely access and manage the server from any remote location. Below are the steps to do so:

1. **Ensure that your EC2 instance's security group allows inbound SSH traffic** on port **22**. This can be configured during the instance setup in the AWS console.
   
2. **Obtain your EC2 instance’s public IP address** and the **private key file (.pem)** you downloaded during instance creation. The private key is necessary for authenticating your SSH connection.

3. **Open your terminal** and run the following SSH command to connect:

   ```bash
   ssh -i /path/to/your-key.pem ubuntu@<your-ec2-public-ip>
   ```

   - Replace `/path/to/your-key.pem` with the actual path to your private key file.
   - Replace `<your-ec2-public-ip>` with the actual public IP address of your EC2 instance.


