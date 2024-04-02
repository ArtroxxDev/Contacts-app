-- Elimina la tabla si existe para evitar errores si se ejecuta el script más de una vez
DROP TABLE IF EXISTS contacts;

-- Crea la tabla de contactos
CREATE TABLE contacts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255),
    number INTEGER
);

-- Muestra el contenido de la tabla de contactos actualmente, si deseas
SELECT * FROM contacts;

-- Inserta datos de ejemplo en la tabla de contactos
INSERT INTO contacts (name, number) VALUES ('hola mundo', 7897988);

-- Muestra el contenido de la tabla de contactos después de la inserción, si deseas
SELECT * FROM contacts;


-- Cambio del nombre de la columna
ALTER TABLE contacts RENAME COLUMN number TO phone_number;

create table usuarios (
	id serial primary key,
	name varchar(255)not null,
	email varchar(255) unique not null,
	password varchar(255) not null
)