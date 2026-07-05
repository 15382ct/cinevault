# CineVault 🎬
**Movie Review Web Application**  
INT1059 Advanced Web — Assessment 2  
Marcella Galiotti & Cristina Tenorio

---

## Setup Instructions

### 1. Import the Database

**XAMPP (Windows — Marcella):**
1. Open XAMPP Control Panel → Start Apache + MySQL
2. Go to `http://localhost/phpmyadmin`
3. Click **New** → create database named `cinevault`
4. Click **Import** → select `cinevault.sql` → click Go

**MAMP (Mac — Cristina):**
1. Open MAMP → Start Servers
2. Go to `http://localhost:8888/phpmyadmin` (or click "Open WebStart page")
3. Click **New** → create database named `cinevault`
4. Click **Import** → select `cinevault.sql` → click Go
5. In `includes/db.php`, change `DB_PASS` from `''` to `'root'`

---

### 2. Copy Project Files

**XAMPP:** Copy the `cinevault` folder to `C:/xampp/htdocs/`  
**MAMP:** Copy the `cinevault` folder to `/Applications/MAMP/htdocs/`

---

### 3. Open in Browser

**XAMPP:** `http://localhost/cinevault`  
**MAMP:** `http://localhost:8888/cinevault`

---

## Project Structure

```
cinevault/
├── index.php              ← Home page
├── cinevault.sql          ← Database (import this)
├── css/
│   └── style.css          ← Main stylesheet
├── js/
│   └── main.js            ← JavaScript
├── includes/
│   ├── db.php             ← Database connection + session
│   ├── header.php         ← Navigation bar
│   └── footer.php         ← Footer
└── pages/
    ├── movie.php          ← Movie detail + reviews
    ├── search.php         ← Browse + search + genre filter
    ├── login.php          ← User login
    ├── register.php       ← User registration
    ├── logout.php         ← Logout
    ├── favourites.php     ← User favourites list
    └── account.php        ← User account + settings
```

---

## Features Implemented (Assessment 2)

- [x] Live dataset — 20 movies in MySQL database
- [x] Home page with random featured movies
- [x] Movie detail page (title, image, description, metadata)
- [x] User registration with password hashing
- [x] User login with session management
- [x] Star rating system (1–5 stars)
- [x] Written reviews (submit, update)
- [x] Search by title / director
- [x] Genre filter
- [x] Favourites list per user
- [x] Account page (view/delete reviews, edit profile/password)

## Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Tools:** XAMPP / MAMP, GitHub, Figma, Google Docs
