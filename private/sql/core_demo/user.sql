CREATE USER 'core_demo'@'localhost' IDENTIFIED BY 'p1a2s3s4w5o6r7d8';

GRANT ALL PRIVILEGES ON `core_demo`.* TO 'core_demo'@'localhost' WITH GRANT OPTION;

FLUSH PRIVILEGES;

-- SHOW GRANTS FOR 'core_demo'@'localhost';