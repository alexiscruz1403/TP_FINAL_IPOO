CREATE DATABASE bd_viajes; 

USE bd_viajes;

CREATE TABLE empresa(
    idEmpresa bigint AUTO_INCREMENT,
    nombre varchar(150),
    direccion varchar(150),
    PRIMARY KEY (idEmpresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona(
    nroDocumento varchar(15),
    nombre varchar(150),
    apellido varchar(150),
    telefono bigint,
    PRIMARY KEY(nroDocumento)
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE responsable (
    numeroEmpleado bigint AUTO_INCREMENT,
    numeroLicencia bigint,
	nroDocumento varchar(15),
    PRIMARY KEY (numeroEmpleado),
    FOREIGN KEY (nroDocumento) REFERENCES Persona(nroDocumento) ON UPDATE CASCADE ON DELETE CASCADE	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE viaje (
    objViaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	destino varchar(150),
    cantMaxPasajeros int,
	objEmpresa bigint,
    objResponsable bigint,
    importe float,
    costosAbonados float,
    PRIMARY KEY (idViaje),
    FOREIGN KEY (idEmpresa) REFERENCES empresa (idEmpresa),
	FOREIGN KEY (objResponsable) REFERENCES responsable (objResponsable)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;

CREATE TABLE pasajero (
    idPasajero bigint AUTO_INCREMENT,
	idViaje bigint,
    nroAsiento int,
    nroTicket int,
    nroDocumento varchar(15),
    PRIMARY KEY (idPasajero),
	FOREIGN KEY (idViaje) REFERENCES viaje (idViaje) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (nroDocumento) REFERENCES Persona(nroDocumento) ON UPDATE CASCADE ON DELETE CASCADE	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
 
  
