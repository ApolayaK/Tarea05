-- Consultas simples
SELECT * FROM categorias ORDER BY id;
SELECT * FROM cursos ORDER BY id;
SELECT * FROM vista_cursos_todos; -- Test vista

-- Procedimientos almacenados
CALL spu_cursos_registrar(1, 'Geometría Analítica', 50, 'Intermedio', 200.00, '2025-08-01');
CALL spu_cursos_filtrar_nivel('Intermedio');

-- Modificamos un registro y validamos acción del trigger
UPDATE cursos SET precio = 220.00 WHERE id = 2; -- Luego verifique campo "modificado"