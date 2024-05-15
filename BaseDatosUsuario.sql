DROP DATABASE UsuariosConsultorio;
CREATE DATABASE UsuariosConsultorio;
Use UsuariosConsultorio;

CREATE TABLE Usuario(
Nombre_Usuario VARCHAR(50) NOT NULL,
Contrasena VARCHAR(255) NOT NULL,
Privilegio INT NOT NULL,
PRIMARY KEY (Nombre_Usuario)
)ENGINE = InnoDB;