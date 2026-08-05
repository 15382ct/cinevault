-- ============================================
-- CineVault Database
-- INT1059 Advanced Web - Assessment 2
-- Marcella Galiotti & Cristina Tenorio
-- ============================================


-- ── USERS ────────────────────────────────────
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── MOVIES ───────────────────────────────────
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    year INT,
    genre VARCHAR(100),
    director VARCHAR(100),
    cast_members VARCHAR(255),
    description TEXT,
    poster_url VARCHAR(500),
    duration_min INT,
    rating_avg DECIMAL(3,1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── REVIEWS ──────────────────────────────────
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    UNIQUE KEY unique_review (user_id, movie_id)
);

-- ── FAVOURITES ────────────────────────────────
CREATE TABLE favourites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    UNIQUE KEY unique_fav (user_id, movie_id)
);

-- ── MOVIE DATA ────────────────────────────────
INSERT INTO movies (title, year, genre, director, cast_members, description, poster_url, duration_min) VALUES
('The Shawshank Redemption', 1994, 'Drama', 'Frank Darabont', 'Tim Robbins, Morgan Freeman', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg', 142),
('The Godfather', 1972, 'Crime', 'Francis Ford Coppola', 'Marlon Brando, Al Pacino', 'The aging patriarch of an organized crime dynasty transfers control to his reluctant son.', 'https://upload.wikimedia.org/wikipedia/en/1/1c/Godfather_ver1.jpg', 175),
('The Dark Knight', 2008, 'Action', 'Christopher Nolan', 'Christian Bale, Heath Ledger', 'Batman faces the Joker, a criminal mastermind who plunges Gotham into chaos.', 'https://upload.wikimedia.org/wikipedia/en/8/8a/Dark_Knight.jpg', 152),
('Inception', 2010, 'Sci-Fi', 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt', 'A thief who steals corporate secrets through dream-sharing technology is tasked with planting an idea.', 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg', 148),
('Interstellar', 2014, 'Sci-Fi', 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanitys survival.', 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg', 169),
('Parasite', 2019, 'Thriller', 'Bong Joon-ho', 'Song Kang-ho, Lee Sun-kyun', 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Parks and the destitute Kims.', 'https://upload.wikimedia.org/wikipedia/en/5/53/Parasite_%282019_film%29.png', 132),
('Pulp Fiction', 1994, 'Crime', 'Quentin Tarantino', 'John Travolta, Uma Thurman', 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 'https://upload.wikimedia.org/wikipedia/en/3/3b/Pulp_Fiction_%281994%29_poster.jpg', 154),
('The Matrix', 1999, 'Sci-Fi', 'Lana Wachowski', 'Keanu Reeves, Laurence Fishburne', 'A computer hacker learns about the true nature of reality and his role in the war against its controllers.', 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg', 136),
('Forrest Gump', 1994, 'Drama', 'Robert Zemeckis', 'Tom Hanks, Robin Wright', 'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate, and other historical events unfold through the perspective of an Alabama man.', 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump_poster.jpg', 142),
('The Silence of the Lambs', 1991, 'Thriller', 'Jonathan Demme', 'Jodie Foster, Anthony Hopkins', 'A young FBI cadet seeks help from an imprisoned cannibal killer to catch another serial killer.', 'https://upload.wikimedia.org/wikipedia/en/8/86/The_Silence_of_the_Lambs_poster.jpg', 118),
('Goodfellas', 1990, 'Crime', 'Martin Scorsese', 'Ray Liotta, Robert De Niro', 'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners.', 'https://upload.wikimedia.org/wikipedia/en/7/7b/Goodfellas.jpg', 146),
('Fight Club', 1999, 'Drama', 'David Fincher', 'Brad Pitt, Edward Norton', 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into something much more.', 'https://upload.wikimedia.org/wikipedia/en/f/fc/Fight_Club_poster.jpg', 139),
('The Lord of the Rings: The Fellowship of the Ring', 2001, 'Fantasy', 'Peter Jackson', 'Elijah Wood, Ian McKellen', 'A meek Hobbit and his companions set out on a journey to destroy the One Ring and the dark lord Sauron.', 'https://upload.wikimedia.org/wikipedia/en/f/fb/Lord_Rings_Fellowship_Ring.jpg', 178),
('Schindlers List', 1993, 'Drama', 'Steven Spielberg', 'Liam Neeson, Ben Kingsley', 'In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce.', 'https://upload.wikimedia.org/wikipedia/en/3/38/Schindler%27s_List_movie.jpg', 195),
('The Avengers', 2012, 'Action', 'Joss Whedon', 'Robert Downey Jr., Chris Evans', 'Earths mightiest heroes must come together to stop Loki and his alien army from enslaving humanity.', 'https://upload.wikimedia.org/wikipedia/en/8/8a/Avengers_2012_film_poster.jpg', 143),
('Whiplash', 2014, 'Drama', 'Damien Chazelle', 'Miles Teller, J.K. Simmons', 'A promising young drummer enrolls at a cutthroat music conservatory where his brilliant instructor will stop at nothing to realize a student\'s potential.', 'https://upload.wikimedia.org/wikipedia/en/0/01/Whiplash_poster.jpg', 107),
('La La Land', 2016, 'Romance', 'Damien Chazelle', 'Ryan Gosling, Emma Stone', 'While navigating their careers in Los Angeles, a pianist and an actress fall in love while attempting to reconcile their aspirations for the future.', 'https://upload.wikimedia.org/wikipedia/en/a/ab/La_La_Land_%28film%29.png', 128),
('Joker', 2019, 'Thriller', 'Todd Phillips', 'Joaquin Phoenix, Robert De Niro', 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society.', 'https://upload.wikimedia.org/wikipedia/en/e/e1/Joker_%282019_film%29_poster.jpg', 122),
('Coco', 2017, 'Animation', 'Lee Unkrich', 'Anthony Gonzalez, Gael Garcia Bernal', 'Aspiring musician Miguel, confronted with his familys ancestral ban on music, enters the Land of the Dead to find his great-great-grandfather.', 'https://upload.wikimedia.org/wikipedia/en/9/98/Coco_%282017_film%29_poster.jpg', 105),
('Get Out', 2017, 'Horror', 'Jordan Peele', 'Daniel Kaluuya, Allison Williams', 'A young African-American visits his white girlfriends parents for the weekend, where his simmering uneasiness about their reception of him eventually reaches a boiling point.', 'https://upload.wikimedia.org/wikipedia/en/a/a1/Get_Out_poster.png', 104);

-- Update average ratings with some sample data
UPDATE movies SET rating_avg = 4.9 WHERE title = 'The Shawshank Redemption';
UPDATE movies SET rating_avg = 4.8 WHERE title = 'The Godfather';
UPDATE movies SET rating_avg = 4.7 WHERE title = 'The Dark Knight';
UPDATE movies SET rating_avg = 4.6 WHERE title = 'Inception';
UPDATE movies SET rating_avg = 4.5 WHERE title = 'Interstellar';
UPDATE movies SET rating_avg = 4.6 WHERE title = 'Parasite';
UPDATE movies SET rating_avg = 4.5 WHERE title = 'Pulp Fiction';
UPDATE movies SET rating_avg = 4.4 WHERE title = 'The Matrix';
UPDATE movies SET rating_avg = 4.3 WHERE title = 'Forrest Gump';
UPDATE movies SET rating_avg = 4.4 WHERE title = 'The Silence of the Lambs';
UPDATE movies SET rating_avg = 4.5 WHERE title = 'Goodfellas';
UPDATE movies SET rating_avg = 4.3 WHERE title = 'Fight Club';
UPDATE movies SET rating_avg = 4.4 WHERE title = 'The Lord of the Rings: The Fellowship of the Ring';
UPDATE movies SET rating_avg = 4.8 WHERE title = 'Schindlers List';
UPDATE movies SET rating_avg = 4.1 WHERE title = 'The Avengers';
UPDATE movies SET rating_avg = 4.6 WHERE title = 'Whiplash';
UPDATE movies SET rating_avg = 4.2 WHERE title = 'La La Land';
UPDATE movies SET rating_avg = 4.2 WHERE title = 'Joker';
UPDATE movies SET rating_avg = 4.5 WHERE title = 'Coco';
UPDATE movies SET rating_avg = 4.3 WHERE title = 'Get Out';
