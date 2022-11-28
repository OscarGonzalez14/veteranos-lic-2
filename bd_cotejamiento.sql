SET collation_connection = 'utf8mb4_general_ci';
ALTER DATABASE your_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE your_table CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


/*

SQL DE INSERTED AROS MANUALES
*/

INSERT INTO `aros_manuales` (`id_aro`, `codigo_orden`, `marca`, `modelo`, `color`, `material`) VALUES 
(NULL, '1011202211', '-', '-', '-', '-'),
(NULL, '1011202213', '-', '-', '-', '-'),
(NULL, '1011202214', '-', '-', '-', '-'),
(NULL, '1011202215', '-', '-', '-', '-'),
(NULL, '1011202216', '-', '-', '-', '-'),

(NULL, '1011202217', '-', '-', '-', '-'),

(NULL, '1011202218', '-', '-', '-', '-'),
(NULL, '1011202219', '-', '-', '-', '-'),
(NULL, '101120222', '-', '-', '-', '-'),

(NULL, '1011202220', '-', '-', '-', '-'),
(NULL, '1011202221', '-', '-', '-', '-'),
(NULL, '1011202222', '-', '-', '-', '-'),

(NULL, '1011202223', '-', '-', '-', '-'),
(NULL, '1011202224', '-', '-', '-', '-'),
(NULL, '1011202225', '-', '-', '-', '-'),

(NULL, '1011202226', '-', '-', '-', '-'),
(NULL, '1011202227', '-', '-', '-', '-'),
(NULL, '1011202228', '-', '-', '-', '-'),

(NULL, '1011202229', '-', '-', '-', '-'),
(NULL, '101120223', '-', '-', '-', '-'),
(NULL, '1011202230', '-', '-', '-', '-'),
(NULL, '1011202231', '-', '-', '-', '-');