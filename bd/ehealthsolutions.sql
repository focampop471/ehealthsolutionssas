CREATE DATABASE ehealthsolutions;
USE ehealthsolutions;

CREATE TABLE usuario(
	usu_id INT NOT NULL,
	usu_usuario VARCHAR(20) NOT NULL,
	usu_nombres VARCHAR(100) NOT NULL,
	usu_apellidos VARCHAR(100) NOT NULL,
	usu_contrasena VARCHAR(20) NOT NULL,
	usu_activo BOOL NOT NULL
)TYPE=InnoDB;

ALTER TABLE usuario ADD CONSTRAINT usu_id_pk PRIMARY KEY (usu_id);
ALTER TABLE usuario MODIFY COLUMN usu_id INT AUTO_INCREMENT;
ALTER TABLE usuario ADD CONSTRAINT usu_usuario_uq UNIQUE (usu_usuario);


CREATE TABLE producto(
	prd_id INT NOT NULL,
	prd_nombre VARCHAR(100) NOT NULL,
	prd_descripcion TEXT,
	prd_texto TEXT,
	prd_imagen VARCHAR(100),
	prd_activo BOOL NOT NULL
)TYPE=InnoDB;

ALTER TABLE producto ADD CONSTRAINT prd_id_pk PRIMARY KEY (prd_id);
ALTER TABLE producto MODIFY COLUMN prd_id INT AUTO_INCREMENT;
ALTER TABLE producto ADD CONSTRAINT prd_nombre_uq UNIQUE (prd_nombre);



CREATE TABLE noticia_seccion(
	nts_id INT NOT NULL,
	nts_nombre VARCHAR(100) NOT NULL,
	nts_activo BOOL NOT NULL
)TYPE=InnoDB;

ALTER TABLE noticia_seccion ADD CONSTRAINT nts_id_pk PRIMARY KEY (nts_id);
ALTER TABLE noticia_seccion MODIFY COLUMN nts_id INT AUTO_INCREMENT;


CREATE TABLE noticia(
	not_id INT NOT NULL,
	not_fecha TIMESTAMP NOT NULL DEFAULT NOW(),
	not_titulo VARCHAR(100) NOT NULL,
	not_lead TEXT,
	not_texto TEXT,
	not_activo BOOL NOT NULL,
	not_nts_id INT NOT NULL,
	not_usu_id INT NOT NULL
)TYPE=InnoDB;

ALTER TABLE noticia ADD CONSTRAINT not_id_pk PRIMARY KEY (not_id);
ALTER TABLE noticia MODIFY COLUMN not_id INT AUTO_INCREMENT;
ALTER TABLE noticia ADD CONSTRAINT not_nts_id_fk FOREIGN KEY (not_nts_id) REFERENCES noticia_seccion(nts_id);
ALTER TABLE noticia ADD CONSTRAINT not_usu_id_fk FOREIGN KEY (not_usu_id) REFERENCES usuario(usu_id);


CREATE TABLE direcciones
(
dir_id INT NOT NULL,
dir_nombres VARCHAR(100) NOT NULL,
dir_apellidos VARCHAR(100) NOT NULL,
dir_correo VARCHAR(100) NOT NULL,
dir_telefono VARCHAR(100) NULL,
dir_celular VARCHAR(100) NULL,
dir_direccion VARCHAR(100) NOT NULL,
dir_ciudad VARCHAR(100) NOT NULL,
dir_departamento VARCHAR(100) NOT NULL

)TYPE=InnoDB;

ALTER TABLE direcciones ADD CONSTRAINT dir_id_pk PRIMARY KEY (dir_id);
ALTER TABLE direcciones MODIFY COLUMN dir_id TINYINT AUTO_INCREMENT;


CREATE TABLE visita(
	vis_id TINYINT NOT NULL,
	vis_cantidad BIGINT UNSIGNED
)TYPE=InnoDB;

ALTER TABLE visita ADD CONSTRAINT vis_id_pk PRIMARY KEY (vis_id);
ALTER TABLE visita MODIFY COLUMN vis_id TINYINT AUTO_INCREMENT;

