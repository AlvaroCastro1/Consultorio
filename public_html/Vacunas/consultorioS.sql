DROP DATABASE consultorioS;
Create database consultorioS;

USE `consultorioS` ;

-- -----------------------------------------------------
-- Tabla `Paciente`
-- -----------------------------------------------------
CREATE TABLE Paciente (
  idPaciente INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  apellidoPaterno VARCHAR(45) NOT NULL,
  apellidoMaterno VARCHAR(45) NOT NULL,
  fechaNacimiento DATE NOT NULL,
  sexo VARCHAR(45) NOT NULL,
  telefono VARCHAR(10) NOT NULL,
  email VARCHAR(45) NOT NULL,
  pais VARCHAR(45) NOT NULL,
  estado VARCHAR(45) NOT NULL,
  municipio VARCHAR(45) NOT NULL,
  localidad VARCHAR(45) NOT NULL,
  numero_ext VARCHAR(45) NOT NULL,
  numero_int VARCHAR(45) NOT NULL,
  codigoPostal VARCHAR(45) NOT NULL,
  tipoSangre VARCHAR(45) NOT NULL,
  PRIMARY KEY (idPaciente)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `consultorio`.`Cita`
-- -----------------------------------------------------
CREATE TABLE Cita (
  idCita INT NOT NULL AUTO_INCREMENT,
  idPacienteC INT NOT NULL,
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  asistencia BOOLEAN NOT NULL,
  PRIMARY KEY (idCita),
  FOREIGN KEY (idPacienteC) REFERENCES Paciente (idPaciente)
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`Expediente`
-- -----------------------------------------------------
CREATE TABLE `Expediente` (
  idExpediente INT NOT NULL AUTO_INCREMENT,
  idPacienteE INT NOT NULL,
  fechaUltimaActualizacion DATE NOT NULL,
  PRIMARY KEY (idExpediente),
  FOREIGN KEY (idPacienteE) REFERENCES Paciente (idPaciente)
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`Vacunas`
-- -----------------------------------------------------
CREATE TABLE Vacunas (
  idVacunas INT NOT NULL AUTO_INCREMENT,
  sustanciaActiva VARCHAR(45) NOT NULL,
  enfermedad VARCHAR (50) NOT NULL,
  formula VARCHAR(100) NOT NULL,
  laboratorio VARCHAR(50) NOT NULL,
  dosis FLOAT NOT NULL,
  gramaje FLOAT NOT NULL,
  fechaCaducidad DATE NOT NULL,
  lote INT NOT NULL,
  PRIMARY KEY (idVacunas)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `consultorio`.`detalleVacunas`
-- -----------------------------------------------------
CREATE TABLE detalleVacunas (
  idDetalleVacunas INT NOT NULL AUTO_INCREMENT,
  idExpedienteDV INT NOT NULL,
  idVacunasDV INT NOT NULL,
  fechaAplicacion DATE NOT NULL,
  PRIMARY KEY (idDetalleVacunas),
  FOREIGN KEY (idVacunasDV) REFERENCES Vacunas (idVacunas),
  FOREIGN KEY (idExpedienteDV) REFERENCES Expediente (idExpediente)
)ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`Alergias`
-- -----------------------------------------------------
CREATE TABLE Alergias (
  idAlergias INT NOT NULL AUTO_INCREMENT,
  tipoAlergia VARCHAR(50) NOT NULL,
  alergeno VARCHAR(45) NOT NULL,
  PRIMARY KEY (idAlergias)
)ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`detalleAlergias`
-- -----------------------------------------------------
CREATE TABLE detalleAlergias (
  idDetalleAlergias INT NOT NULL AUTO_INCREMENT,
  idExpedienteDA INT NOT NULL,
  idAlergiasDA INT NOT NULL,
  score FLOAT NOT NULL,
  PRIMARY KEY (idDetalleAlergias),
  FOREIGN KEY (idExpedienteDA) REFERENCES Expediente (idExpediente),
  FOREIGN KEY (idAlergiasDA) REFERENCES Alergias (idAlergias)
)ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`Estudios`
-- -----------------------------------------------------
CREATE TABLE Estudios (
  idEstudios INT NOT NULL AUTO_INCREMENT,
  nombreEstudio VARCHAR(45) NOT NULL,
  tipoEstudio VARCHAR(50) NOT NULL,
  descripcionEstudio VARCHAR(100) NOT NULL,
  PRIMARY KEY (idEstudios)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `consultorio`.`Elementos`
-- -----------------------------------------------------
CREATE TABLE Elementos (
  idElementos INT NOT NULL AUTO_INCREMENT,
  nombreElemento VARCHAR(45) NOT NULL,
  rango VARCHAR(50) NOT NULL,
  PRIMARY KEY (idElementos)
)ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle Estudios`
-- -----------------------------------------------------
CREATE TABLE detalleEstudios (
  idDetalleEstudios INT NOT NULL AUTO_INCREMENT,
  idEstudiosDE INT NOT NULL,
  idExpedienteDE INT NOT NULL,
  fechaEstudio DATE NOT NULL,
  PRIMARY KEY (idDetalleEstudios),
  FOREIGN KEY (idExpedienteDE) REFERENCES Expediente (idExpediente),
  FOREIGN KEY (idEstudiosDE) REFERENCES Estudios (idEstudios)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `consultorio`.`detalleResultados`
-- -----------------------------------------------------
CREATE TABLE detalleResultados (
  idDetalleResultados INT NOT NULL AUTO_INCREMENT,
  idDetalleEStudiosDR INT NOT NULL,
  idElementosDR INT NOT NULL,
  valor FLOAT NOT NULL,
  interpretacion VARCHAR(100) NOT NULL,
  PRIMARY KEY (idDetalleResultados),
  FOREIGN KEY (idDetalleEStudiosDR) REFERENCES detalleEstudios (idDetalleEstudios),
  FOREIGN KEY (idElementosDR) REFERENCES Elementos (idElementos)
)ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`Signos`
-- -----------------------------------------------------
CREATE TABLE Signos (
  idSignos INT NOT NULL AUTO_INCREMENT,
  fechaActualizacion DATE NOT NULL,
  temperatura FLOAT NOT NULL,
  frecuenciaRespiratoria VARCHAR(45) NOT NULL,
  frecuenciaCardiaca VARCHAR(45) NOT NULL,
  oxigenacion FLOAT NOT NULL,
  presionArterial FLOAT NOT NULL,
  estadoHidratacion VARCHAR(45) NOT NULL,
  estadoConciencia VARCHAR(45) NOT NULL,
  estadoNeurologico VARCHAR(45) NOT NULL,
  PRIMARY KEY (idSignos)
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle Signos`
-- -----------------------------------------------------
CREATE TABLE detalleSignos (
  idDetalleSignos INT NOT NULL AUTO_INCREMENT,
  idExpedienteDS INT NOT NULL,
  idSignosDS INT NOT NULL,
  PRIMARY KEY (idDetalleSignos),
  FOREIGN KEY (idExpedienteDS)REFERENCES Expediente (idExpediente),
  FOREIGN KEY (idSignosDS)REFERENCES Signos (idSignos)
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Antecedentes`
-- -----------------------------------------------------
CREATE TABLE Antecedentes (
  idAntecedentes INT NOT NULL AUTO_INCREMENT,
  tipoAntecedente VARCHAR(50) NOT NULL,
  nombrePadecimiento VARCHAR(45) NOT NULL,
  descripcion VARCHAR(200) NOT NULL,
  PRIMARY KEY (idAntecedentes)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `detalle Antecedentes`
-- -----------------------------------------------------
CREATE TABLE detalleAntecedentes (
  idDetalleAntecedentes INT NOT NULL AUTO_INCREMENT,
  idExpedienteDA INT NOT NULL,
  idAntecedentesDA INT NOT NULL,
  PRIMARY KEY (idDetalleAntecedentes),
  FOREIGN KEY (idExpedienteDA) REFERENCES Expediente (idExpediente),
  FOREIGN KEY (idAntecedentesDA) REFERENCES Antecedentes (idAntecedentes)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Tratamiento`
-- -----------------------------------------------------
CREATE TABLE Tratamiento (
  idTratamiento INT NOT NULL AUTO_INCREMENT,
  descripcionTratamiento VARCHAR(45) NOT NULL,
  duracion VARCHAR(45) NOT NULL,
  PRIMARY KEY (idTratamiento)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `detalle Tratamiento`
-- -----------------------------------------------------
CREATE TABLE detalleTratamiento (
  idDetalleTratamiento INT NOT NULL AUTO_INCREMENT,
  idTratamientoDT INT NOT NULL,
  idExpedienteDT INT NOT NULL,
  fechaTratamiento DATE NOT NULL,
  diagnostico VARCHAR(45) NOT NULL,
  PRIMARY KEY (idDetalleTratamiento),
  FOREIGN KEY (idExpedienteDT) REFERENCES Expediente (idExpediente),
  FOREIGN KEY (idTratamientoDT) REFERENCES Tratamiento (idTratamiento)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Procedimientos`
-- -----------------------------------------------------
CREATE TABLE Procedimiento (
  idProcedimiento INT NOT NULL AUTO_INCREMENT,
  nombreProceso VARCHAR (100) NOT NULL,
  descripcionProcedimiento VARCHAR(45) NOT NULL,
  PRIMARY KEY (idProcedimiento)
  ) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `detalleProcedimientos`
-- -----------------------------------------------------
CREATE TABLE detalleProcedimiento (
  idDetalleProcedimiento INT NOT NULL AUTO_INCREMENT,
  idExpedienteDP INT NOT NULL,
  idProcedimientoDP INT NOT NULL,
  observaciones VARCHAR(45) NOT NULL,
  fechaProceso DATE NOT NULL,
  PRIMARY KEY (idDetalleProcedimiento),
  FOREIGN KEY (idExpedienteDP) REFERENCES Expediente (idExpediente),
  FOREIGN KEY (idProcedimientoDP) REFERENCES Procedimiento (idProcedimiento)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Control de crecimiento`
-- -----------------------------------------------------
CREATE TABLE ControlCrecimiento (
  idControlC INT NOT NULL AUTO_INCREMENT,
  fechaControl DATE NOT NULL,
  altura FLOAT NOT NULL,
  peso FLOAT NOT NULL,
  indiceMasaCorporal FLOAT NOT NULL,
  circunferenciaDelCraneo FLOAT NOT NULL,
  evaluacion VARCHAR(30) NOT NULL,
  PRIMARY KEY (idControlC)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Detalle control de crecimiento`
-- -----------------------------------------------------
CREATE TABLE detalleControlCrecimiento (
  idDetalleControlC INT NOT NULL AUTO_INCREMENT,
  idControlCDC INT NOT NULL,
  idExpedienteDC INT NOT NULL,
  PRIMARY KEY (idDetalleControlC),
  FOREIGN KEY (idControlCDC) REFERENCES ControlCrecimiento (idControlC),
  FOREIGN KEY (idExpedienteDC) REFERENCES Expediente (idExpediente)
)ENGINE = InnoDB;



