SET collation_connection = 'utf8mb4_general_ci';
ALTER DATABASE your_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE your_table CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;