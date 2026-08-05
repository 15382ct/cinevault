# CineVault

## Movie Review Web Application

**INT1059 Advanced Web – Assessment 2**
**Marcella Galiotti & Cristina Tenorio**

## Setup Instructions

### 1. Import the Database

#### Windows (XAMPP – Marcella)

1. Open the **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Open **http://localhost/phpmyadmin** in your browser.
3. Create a new database called **cinevault**.
4. Click **Import**, select the **cinevault.sql** file, and then click **Go**.

#### Mac (MAMP – Cristina)

1. Open **MAMP** and click **Start Servers**.
2. Open **http://localhost:8888/phpmyadmin** (or use the WebStart page).
3. Create a new database called **cinevault**.
4. Import the **cinevault.sql** file.
5. Open **includes/db.php** and change the database password from `''` to `'root'`.

---

### 2. Copy the Project Files

* **XAMPP:** Copy the **cinevault** folder into:

  `C:/xampp/htdocs/`

* **MAMP:** Copy the **cinevault** folder into:

  `/Applications/MAMP/htdocs/`

---

### 3. Run the Project

Open your browser and use the appropriate URL:

* **XAMPP:** `http://localhost/cinevault`
* **MAMP:** `http://localhost:8888/cinevault`

If everything has been configured correctly, the CineVault home page should load successfully.

---

# Project Structure

```text
cinevault/
├── index.php              Home page
├── cinevault.sql          Database file
├── css/
│   └── style.css          Main stylesheet
├── js/
│   └── main.js            JavaScript functionality
├── includes/
│   ├── db.php             Database connection and session
│   ├── header.php         Navigation bar
│   └── footer.php         Footer
└── pages/
    ├── movie.php          Movie details and reviews
    ├── search.php         Search and genre filtering
    ├── login.php          User login
    ├── register.php       User registration
    ├── logout.php         Logout
    ├── favourites.php     Favourite movies
    └── account.php        User profile and settings
```

---

# Main Features

The CineVault application includes the following features developed for Assessment 2:

* A MySQL database containing 20 movies.
* A home page that displays featured movies randomly.
* A movie details page with descriptions, posters, genres, release year, and reviews.
* User registration with securely hashed passwords.
* Login and logout using PHP session management.
* A 1–5 star rating system for movie reviews.
* Users can write and update their own reviews.
* Search movies by title or director.
* Filter movies by genre.
* Save favourite movies to a personal favourites list.
* An account page where users can update their profile, change their password, and manage their reviews.

---

# Technologies Used

* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Development Tools:** XAMPP, MAMP, GitHub, Figma, and Google Docs
