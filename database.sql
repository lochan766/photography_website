CREATE DATABASE photography_portfolio;
USE photography_portfolio;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin:
-- email: admin@example.com
-- pass : admin123
INSERT INTO admins (email, password)
VALUES ('lochanrana777@gmail.com', MD5('Lochan123lop#'));

CREATE TABLE photos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  category VARCHAR(100) NOT NULL,
  description TEXT,
  image VARCHAR(255) NOT NULL,
  location VARCHAR(150),
  shot_date DATE NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
