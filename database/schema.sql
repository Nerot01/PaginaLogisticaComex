-- Crear tabla de usuarios administradores
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de actividades
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    date_event DATE,
    location VARCHAR(255),
    media_url VARCHAR(500),
    media_type VARCHAR(50), -- 'image', 'youtube', 'none'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de recursos (biblioteca y lecturas)
CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_url VARCHAR(500),
    category VARCHAR(50), -- 'biblioteca' o 'lectura'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
