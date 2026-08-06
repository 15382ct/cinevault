# CineVault

## Movie Review Web Application

**INT1059 Advanced Web – Assessment 3**
**Marcella Galiotti & Cristina Tenorio**

---

# Links

* **Live Website:** https://cinevault.page.gd
* **GitHub Repository:** https://github.com/15382ct/cinevault

---

# Local Setup

The project is configured to work both locally and on the live server. The `includes/db.php` file automatically detects the environment and connects to the correct database, so you don't need to change any code when moving between local development and the deployed version.

## 1. Import the Database

### Windows (XAMPP)

1. Open the **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Go to `http://localhost/phpmyadmin`.
3. Create a new database called **cinevault**.
4. Click **Import**, select the `cinevault.sql` file, and then click **Go**.

### Mac (MAMP)

1. Open **MAMP** and click **Start Servers**.
2. Open `http://localhost:8888/phpmyadmin` (or use the WebStart page).
3. Create a new database called **cinevault**.
4. Import the `cinevault.sql` file.

---

## 2. Copy the Project Files

Copy the project folder into your local web server directory.

* **XAMPP:** `C:/xampp/htdocs/cinevault/`
* **MAMP:** `/Applications/MAMP/htdocs/cinevault/`

---

## 3. Run the Project

Open the project in your browser using:

* **XAMPP:** `http://localhost/cinevault`
* **MAMP:** `http://localhost:8888/cinevault`

> **Important:** Always open the project through your local server (`localhost`). If you open `index.php` directly, the PHP code will not run correctly.

---

# Deployment

The final version of CineVault is hosted on **InfinityFree**. The application automatically checks whether it is running on `localhost` or the live website and loads the correct database connection. This allows the same project files to work in both environments without any manual configuration.

---

# Project Structure

```text
/
├── index.php                 Home page
├── cinevault.sql             Database export
├── README.md
├── css/
│   └── style.css             Main stylesheet
├── js/
│   └── main.js               JavaScript functionality
├── includes/
│   ├── db.php                Database connection and session
│   ├── header.php            Navigation bar
│   └── footer.php            Footer
└── pages/
    ├── movie.php             Movie details and reviews
    ├── search.php            Browse, search and genre filtering
    ├── login.php             User login
    ├── register.php          User registration
    ├── logout.php            User logout
    ├── favourites.php        Favourite movies
    └── account.php           User profile and account settings
```

---

# Features

CineVault includes the following features:

* A MySQL database containing 20 movies.
* Random featured movies displayed on the home page.
* Navigation menu with movie genres.
* Genre filtering for easier browsing.
* Movie pages with posters, descriptions, directors, cast, and user reviews.
* User registration with secure password hashing.
* Login and logout using PHP sessions.
* A 1–5 star rating system.
* Users can create, edit, and delete their own reviews.
* Search movies by title or director.
* Personal favourites list where users can add or remove movies.
* User account page for managing reviews and updating profile information.
* Live deployment using InfinityFree.

---

# Technologies Used

* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP (mysqli, sessions, password hashing)
* **Database:** MySQL
* **Hosting:** InfinityFree
* **Development Tools:** XAMPP, MAMP, phpMyAdmin, GitHub
