CREATE DATABASE academia;
USE academia;

-- Tabla de Categorías
CREATE TABLE categorias
(
	id 				INT AUTO_INCREMENT PRIMARY KEY,
    categoria 		VARCHAR(40) 	NOT NULL,
    creado 			DATETIME 		NOT NULL DEFAULT NOW(),
    modificado 		DATETIME 		NULL,
    CONSTRAINT uk_categoria_nombre UNIQUE (categoria)
)ENGINE = INNODB;

-- Tabla de Cursos
CREATE TABLE cursos
(
	id 				INT AUTO_INCREMENT PRIMARY KEY,
    idcategoria 	INT 			NOT NULL,
    titulo 			VARCHAR(70) 	NOT NULL,
    duracionhoras 	INT 			NOT NULL,
    nivel 			ENUM('Básico', 'Intermedio', 'Avanzado') NOT NULL DEFAULT 'Básico',
    precio 			DECIMAL(7,2) 	NOT NULL,
    fechainicio 	DATE 			NOT NULL,
    creado 			DATETIME 		NOT NULL DEFAULT NOW(),
    modificado 		DATETIME 		NULL,
    CONSTRAINT fk_idcategoria_cursos FOREIGN KEY (idcategoria) REFERENCES categorias (id)
)ENGINE = INNODB;

-- Insertar algunas categorías
INSERT INTO categorias (categoria) VALUES
	('Matemáticas'),
    ('Comunicación'),
    ('Literatura');

-- Insertar algunos cursos
INSERT INTO cursos (idcategoria, titulo, duracionhoras, nivel, precio, fechainicio) VALUES
	(1, 'Álgebra Básica', 40, 'Básico', 150.00, '2025-05-01'),
    (2, 'Redacción Efectiva', 30, 'Intermedio', 120.00, '2025-06-10'),
    (3, 'Análisis Literario', 45, 'Avanzado', 180.00, '2025-07-15');

-- Crear vista para ver todos los cursos con nombre de categoría
CREATE VIEW vista_cursos_todos
AS
	SELECT
		CR.id,
        CT.categoria,
        CR.titulo,
        CR.duracionhoras,
        CR.nivel,
        CR.precio,
        CR.fechainicio
    FROM cursos CR
    INNER JOIN categorias CT ON CR.idcategoria = CT.id
    ORDER BY CR.id;

-- Procedimiento para filtrar cursos según su nivel
DELIMITER //
CREATE PROCEDURE spu_cursos_filtrar_nivel(IN _nivel VARCHAR(20))
BEGIN
	SELECT * FROM vista_cursos_todos WHERE nivel = _nivel;
END //

-- Procedimiento para registrar un nuevo curso
DELIMITER //
CREATE PROCEDURE spu_cursos_registrar(
	IN _idcategoria 	INT, 
    IN _titulo 			VARCHAR(70),
    IN _duracionhoras 	INT,
    IN _nivel 			VARCHAR(20),
    IN _precio 			DECIMAL(7,2),
    IN _fechainicio 	DATE
)
BEGIN
	INSERT INTO cursos (idcategoria, titulo, duracionhoras, nivel, precio, fechainicio) 
		VALUES (_idcategoria, _titulo, _duracionhoras, _nivel, _precio, _fechainicio);
END //

-- Trigger para actualizar la fecha de modificación cuando se edita un curso
DELIMITER //
CREATE TRIGGER cursos_actualizar_fecha_modificacion
BEFORE UPDATE ON cursos
FOR EACH ROW
BEGIN
	SET NEW.modificado = NOW();
END //
