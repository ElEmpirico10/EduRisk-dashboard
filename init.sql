-- ======================================
-- ENUM para tipo de documento
-- ======================================
DO $$
BEGIN
   IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'tipo_documento') THEN
      CREATE TYPE tipo_documento AS ENUM ('tarjeta_identidad', 'cedula', 'cedula_extranjera');
   END IF;
END$$;

-- ======================================
-- TABLA FICHA
-- ======================================
CREATE TABLE IF NOT EXISTS Ficha (
    id_ficha SERIAL PRIMARY KEY,
    nombre_ficha VARCHAR(30) NOT NULL,
    codigo_ficha BIGINT NOT NULL UNIQUE
);

-- ======================================
-- TABLA EXAMEN
-- ======================================
CREATE TABLE IF NOT EXISTS Examen (
    id_examen SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    fecha_inicio TIMESTAMP NOT NULL,
    fecha_fin TIMESTAMP NOT NULL,
    habilitado BOOLEAN DEFAULT FALSE,
    estado VARCHAR(100) NOT NULL,
    id_ficha INT NOT NULL REFERENCES Ficha (id_ficha),
    CONSTRAINT unique_nombre_ficha UNIQUE (nombre, id_ficha)
);

-- ======================================
-- TABLA ASPIRANTE
-- ======================================
CREATE TABLE IF NOT EXISTS Aspirante (
    id_aspirante SERIAL PRIMARY KEY,
    primer_nombre VARCHAR(50) NOT NULL,
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50) NOT NULL,
    segundo_apellido VARCHAR(50),
    email VARCHAR(100) NOT NULL,
    tipo_tarjeta tipo_documento NOT NULL,
    numero_tarjeta BIGINT NOT NULL,
    contrasena TEXT NOT NULL,
    id_ficha INT NOT NULL REFERENCES Ficha(id_ficha),
    CONSTRAINT unique_email_numero UNIQUE (email, numero_tarjeta)
);

-- ======================================
-- TABLA EXAMEN_ASPIRANTE
-- ======================================
CREATE TABLE IF NOT EXISTS Examen_Aspirante (
    id_examen_aspirante SERIAL PRIMARY KEY,
    id_examen INT NOT NULL REFERENCES Examen(id_examen),
    id_aspirante INT NOT NULL REFERENCES Aspirante(id_aspirante),
    fecha_realizacion TIMESTAMP,
    CONSTRAINT unique_examen_aspirante UNIQUE (id_examen, id_aspirante)
);

-- ======================================
-- TABLA PREGUNTA
-- ======================================
CREATE TABLE IF NOT EXISTS Pregunta (
    id_pregunta SERIAL PRIMARY KEY,
    texto_pregunta TEXT NOT NULL,
    tipo_pregunta VARCHAR(50) NOT NULL,
    contenido TEXT,
    CONSTRAINT unique_pregunta UNIQUE (texto_pregunta, tipo_pregunta)
);

-- ======================================
-- TABLA EXAMEN_PREGUNTA (relación N:M)
-- ======================================
CREATE TABLE IF NOT EXISTS Examen_Pregunta (
    id_examen_pregunta SERIAL PRIMARY KEY,
    id_examen INT NOT NULL REFERENCES Examen(id_examen),
    id_pregunta INT NOT NULL REFERENCES Pregunta(id_pregunta),
    CONSTRAINT unique_examen_pregunta UNIQUE (id_examen, id_pregunta)
);

-- ======================================
-- TABLA RESPUESTA
-- ======================================
CREATE TABLE IF NOT EXISTS Respuesta (
    id_respuesta SERIAL PRIMARY KEY,
    texto_respuesta TEXT,
    valor_respuesta INT,
    id_aspirante INT NOT NULL REFERENCES Aspirante(id_aspirante),
    id_pregunta INT NOT NULL REFERENCES Pregunta(id_pregunta),
    id_examen INT NOT NULL REFERENCES Examen(id_examen),
    CONSTRAINT unique_respuesta UNIQUE (id_aspirante, id_pregunta, id_examen)
);

-- ======================================
-- DATOS DE PRUEBA
-- ======================================

-- INSERT FICHA DE PRUEBA
INSERT INTO Ficha (nombre_ficha, codigo_ficha)
VALUES ('ADSO 2934070', 2934070)
ON CONFLICT (codigo_ficha) DO NOTHING;

-- INSERT ASPIRANTE DE PRUEBA
INSERT INTO Aspirante (
    primer_nombre, segundo_nombre, primer_apellido, segundo_apellido,
    email, tipo_tarjeta, numero_tarjeta, contrasena, id_ficha
) VALUES (
    'Juan', 'Carlos', 'Perez', 'Lopez',
    'juan@example.com', 'cedula', 123456789,
    '$2y$10$p1Zpde4FDfNTJbm9JOphsexRPCsXZ2/XooeZdy1/.EYe/BrdRdXcS',
    1
)
ON CONFLICT (email, numero_tarjeta) DO NOTHING;

-- INSERT EXAMEN DE PRUEBA
INSERT INTO Examen (nombre, fecha_inicio, fecha_fin, habilitado, estado, id_ficha)
VALUES (
    'Examen Diagnóstico ADSO',
    NOW(),
    NOW() + INTERVAL '7 days',
    TRUE,
    'Activo',
    1
)
ON CONFLICT (nombre, id_ficha) DO NOTHING;

-- INSERT PREGUNTAS
INSERT INTO Pregunta (texto_pregunta, tipo_pregunta, contenido) VALUES
('¿Por qué elegiste estudiar ADSO?', 'textarea', 'Explica las razones que te motivaron a elegir Análisis y Desarrollo de Software...'),
('¿Te gustaría trabajar en desarrollo de software en el futuro?', 'radio', '["Sí","No","Tal vez"]'),
('¿Ya has tenido experiencias previas con programación?', 'radio', '["Sí","No","Tal vez"]'),
('¿Qué tanto disfrutas resolver problemas o retos lógicos?', 'select', '["Me encanta, es lo que más disfruto","Me gusta bastante","Me gusta moderadamente","No me gusta mucho","No me gusta para nada"]'),
('¿Lees o investigas sobre tecnología por cuenta propia?', 'radio', '["Sí","No","Tal vez"]'),
('¿Tienes metas claras relacionadas con tu formación en ADSO?', 'textarea', 'Describe qué metas específicas tienes con esta formación y cómo planeas alcanzarlas...')
ON CONFLICT (texto_pregunta, tipo_pregunta) DO NOTHING;

-- VINCULA PREGUNTAS AL EXAMEN
INSERT INTO Examen_Pregunta (id_examen, id_pregunta) VALUES 
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,6)
ON CONFLICT (id_examen, id_pregunta) DO NOTHING;

-- ======================================
-- FUNCION: buscar_aspirante
-- ======================================
CREATE OR REPLACE FUNCTION buscar_aspirante(
    p_tipo_tarjeta tipo_documento,
    p_numero_tarjeta BIGINT
)
RETURNS TABLE (
    id_aspirante INT,
    primer_nombre VARCHAR,
    segundo_nombre VARCHAR,
    primer_apellido VARCHAR,
    segundo_apellido VARCHAR,
    email VARCHAR,
    tipo_tarjeta tipo_documento,
    numero_tarjeta BIGINT,
    contrasena TEXT,
    id_ficha INT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        a.id_aspirante,
        a.primer_nombre,
        a.segundo_nombre,
        a.primer_apellido,
        a.segundo_apellido,
        a.email,
        a.tipo_tarjeta,
        a.numero_tarjeta,
        a.contrasena,
        a.id_ficha
    FROM Aspirante a
    WHERE a.tipo_tarjeta = p_tipo_tarjeta
      AND a.numero_tarjeta = p_numero_tarjeta;
END;
$$ LANGUAGE plpgsql;

-- ======================================
-- PROCEDIMIENTO: INSERTAR_ASPIRANTE
-- ======================================

CREATE OR REPLACE PROCEDURE insertar_aspirante(
    IN p_primer_nombre VARCHAR(50),
    IN p_segundo_nombre VARCHAR(50) ,
    IN p_primer_apellido VARCHAR(50),
    IN p_segundo_apellido VARCHAR(50) ,
    IN p_email VARCHAR(100),
    IN p_tipo_tarjeta tipo_documento,
    IN p_numero_tarjeta BIGINT,
    IN p_contrasena TEXT,
    IN p_id_ficha INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Aspirante (
        primer_nombre,
        segundo_nombre,
        primer_apellido,
        segundo_apellido,
        email,
        tipo_tarjeta,
        numero_tarjeta,
        contrasena,
        id_ficha
    ) VALUES (
        p_primer_nombre,
        p_segundo_nombre,
        p_primer_apellido,
        p_segundo_apellido,
        p_email,
        p_tipo_tarjeta,
        p_numero_tarjeta,
        p_contrasena,
        p_id_ficha
    );
END;
$$;
-- ======================================
-- PROCEDIMIENTO: ELIMINAR_ASPIRANTE
-- ======================================

CREATE OR REPLACE PROCEDURE eliminar_aspirante(
    IN p_id_aspirante INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM Aspirante 
    WHERE id_aspirante = p_id_aspirante;
END;
$$;
-- ======================================
-- PROCEDIMIENTO: ACTUALIZAR_ASPIRANTE
-- ======================================
CREATE OR REPLACE PROCEDURE actualizar_aspirante(
    IN p_id_aspirante INT,
    IN p_primer_nombre VARCHAR(50),
    IN p_segundo_nombre VARCHAR(50) ,
    IN p_primer_apellido VARCHAR(50),
    IN p_segundo_apellido VARCHAR(50) ,
    IN p_email VARCHAR(100),
    IN p_tipo_tarjeta tipo_documento,
    IN p_numero_tarjeta BIGINT,
    IN p_id_ficha INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE Aspirante 
    SET 
        primer_nombre = p_primer_nombre,
        segundo_nombre = p_segundo_nombre,
        primer_apellido = p_primer_apellido,
        segundo_apellido = p_segundo_apellido,
        email = p_email,
        tipo_tarjeta = p_tipo_tarjeta,
        numero_tarjeta = p_numero_tarjeta,
        id_ficha = p_id_ficha
    WHERE id_aspirante = p_id_aspirante;
END;
$$;
-- ======================================
-- FUNCION: obtener_aspirantes
-- ======================================

CREATE OR REPLACE FUNCTION obtener_aspirantes()
RETURNS TABLE(
    id_aspirante INT,
    primer_nombre VARCHAR(50),
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50),
    segundo_apellido VARCHAR(50),
    email VARCHAR(100),
    tipo_tarjeta tipo_documento,
    numero_tarjeta BIGINT,
    id_ficha INT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        a.id_aspirante,
        a.primer_nombre,
        a.segundo_nombre,
        a.primer_apellido,
        a.segundo_apellido,
        a.email,
        a.tipo_tarjeta,
        a.numero_tarjeta,
        a.id_ficha
    FROM Aspirante a
    ORDER BY a.id_aspirante;
END;
$$ LANGUAGE plpgsql;
-- ======================================
-- PROCEDIMIENTO: insertar_ficha
-- ======================================

CREATE OR REPLACE PROCEDURE insertar_ficha(
    IN p_nombre_ficha VARCHAR(30),
    IN p_codigo_ficha BIGINT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Ficha (
        nombre_ficha,
        codigo_ficha
    ) VALUES (
        p_nombre_ficha,
        p_codigo_ficha
    );
END;
$$;

-- ======================================
-- PROCEDIMIENTO: actualizar_ficha
-- ======================================
CREATE OR REPLACE PROCEDURE actualizar_ficha(
    IN p_id_ficha INT,
    IN p_nombre_ficha VARCHAR(30),
    IN p_codigo_ficha BIGINT
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE Ficha 
    SET 
        nombre_ficha = p_nombre_ficha,
        codigo_ficha = p_codigo_ficha
    WHERE id_ficha = p_id_ficha;
END;
$$;

-- ======================================
-- PROCEDIMIENTO: eliminar_ficha
-- ======================================
CREATE OR REPLACE PROCEDURE eliminar_ficha(
    IN p_id_ficha INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM Ficha 
    WHERE id_ficha = p_id_ficha;
END;
$$;

-- ======================================
-- FUNCION: obtener_ficha
-- ======================================
CREATE OR REPLACE FUNCTION obtener_fichas()
RETURNS TABLE(
    id_ficha INT,
    nombre_ficha VARCHAR(30),
    codigo_ficha BIGINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        f.id_ficha,
        f.nombre_ficha,
        f.codigo_ficha
    FROM Ficha f
    ORDER BY f.id_ficha;
END;
$$ LANGUAGE plpgsql;
-- ======================================
-- PROCEDIMIENTO: insertar_examen
-- ======================================
CREATE OR REPLACE PROCEDURE insertar_examen(
    IN p_nombre VARCHAR(50),
    IN p_fecha_inicio TIMESTAMP,
    IN p_fecha_fin TIMESTAMP,
    IN p_habilitado BOOLEAN ,
    IN p_estado VARCHAR(100),
    IN p_id_ficha INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Examen (
        nombre,
        fecha_inicio,
        fecha_fin,
        habilitado,
        estado,
        id_ficha
    ) VALUES (
        p_nombre,
        p_fecha_inicio,
        p_fecha_fin,
        p_habilitado,
        p_estado,
        p_id_ficha
    );
END;
$$;
-- ======================================
-- PROCEDIMIENTO: actualizar_examen
-- ======================================
CREATE OR REPLACE PROCEDURE actualizar_examen(
    IN p_id_examen INT,
    IN p_nombre VARCHAR(50),
    IN p_fecha_inicio TIMESTAMP,
    IN p_fecha_fin TIMESTAMP,
    IN p_habilitado BOOLEAN,
    IN p_estado VARCHAR(100),
    IN p_id_ficha INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE Examen 
    SET 
        nombre = p_nombre,
        fecha_inicio = p_fecha_inicio,
        fecha_fin = p_fecha_fin,
        habilitado = p_habilitado,
        estado = p_estado,
        id_ficha = p_id_ficha
    WHERE id_examen = p_id_examen;
END;
$$;
-- ======================================
-- PROCEDIMIENTO: eliminar_examen
-- ======================================
CREATE OR REPLACE PROCEDURE eliminar_examen(
    IN p_id_examen INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM Examen 
    WHERE id_examen = p_id_examen;
END;
$$;
-- ======================================
-- FUNCION: obtener_examenes
-- ======================================
CREATE OR REPLACE FUNCTION obtener_examenes()
RETURNS TABLE(
    id_examen INT,
    nombre VARCHAR(50),
    fecha_inicio TIMESTAMP,
    fecha_fin TIMESTAMP,
    habilitado BOOLEAN,
    estado VARCHAR(100),
    id_ficha INT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        e.id_examen,
        e.nombre,
        e.fecha_inicio,
        e.fecha_fin,
        e.habilitado,
        e.estado,
        e.id_ficha
    FROM Examen e
    ORDER BY e.id_examen;
END;
$$ LANGUAGE plpgsql;
-- ======================================
-- PROCEDIMIENTO: insertar_examen_aspirante
-- ======================================

CREATE OR REPLACE PROCEDURE insertar_examen_aspirante(
    IN p_id_examen INT,
    IN p_id_aspirante INT,
    IN p_fecha_realizacion TIMESTAMP DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Examen_Aspirante (
        id_examen,
        id_aspirante,
        fecha_realizacion
    ) VALUES (
        p_id_examen,
        p_id_aspirante,
        p_fecha_realizacion
    );
END;
$$;

-- ======================================
-- PROCEDIMIENTO: insertar_pregunta
-- ======================================
CREATE OR REPLACE PROCEDURE insertar_pregunta(
    IN p_texto_pregunta TEXT,
    IN p_tipo_pregunta VARCHAR(50),
    IN p_contenido TEXT DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Pregunta (
        texto_pregunta,
        tipo_pregunta,
        contenido
    ) VALUES (
        p_texto_pregunta,
        p_tipo_pregunta,
        p_contenido
    );
END;
$$;

-- ======================================
-- PROCEDIMIENTO: actualizar_pregunta
-- ======================================
CREATE OR REPLACE PROCEDURE actualizar_pregunta(
    IN p_id_pregunta INT,
    IN p_texto_pregunta TEXT,
    IN p_tipo_pregunta VARCHAR(50),
    IN p_contenido TEXT DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE Pregunta 
    SET 
        texto_pregunta = p_texto_pregunta,
        tipo_pregunta = p_tipo_pregunta,
        contenido = p_contenido
    WHERE id_pregunta = p_id_pregunta;
END;
$$;
-- ======================================
-- PROCEDIMIENTO: eliminar_pregunta
-- ======================================
CREATE OR REPLACE PROCEDURE eliminar_pregunta(
    IN p_id_pregunta INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM Pregunta 
    WHERE id_pregunta = p_id_pregunta;
END;
$$;
-- ======================================
-- FUNCION:obtener_preguntas
-- ======================================
CREATE OR REPLACE FUNCTION obtener_preguntas()
RETURNS TABLE(
    id_pregunta INT,
    texto_pregunta TEXT,
    tipo_pregunta VARCHAR(50),
    contenido TEXT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        p.id_pregunta,
        p.texto_pregunta,
        p.tipo_pregunta,
        p.contenido
    FROM Pregunta p
    ORDER BY p.id_pregunta;
END;
$$ LANGUAGE plpgsql;
-- ======================================
-- PROCEDIMIENTO: insertar_examen_pregunta
-- ======================================

CREATE OR REPLACE PROCEDURE insertar_examen_pregunta(
    IN p_id_examen INT,
    IN p_id_pregunta INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Examen_Pregunta (
        id_examen,
        id_pregunta
    ) VALUES (
        p_id_examen,
        p_id_pregunta
    );
END;
$$;
-- ======================================
-- PROCEDIMIENTO: insertar_respuesta
-- ======================================
CREATE OR REPLACE PROCEDURE insertar_respuesta(
    IN p_texto_respuesta TEXT ,
    IN p_valor_respuesta INT ,
    IN p_id_aspirante INT,
    IN p_id_pregunta INT,
    IN p_id_examen INT
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Respuesta (
        texto_respuesta,
        valor_respuesta,
        id_aspirante,
        id_pregunta,
        id_examen
    ) VALUES (
        p_texto_respuesta,
        p_valor_respuesta,
        p_id_aspirante,
        p_id_pregunta,
        p_id_examen
    );
END;
$$;