CREATE DATABASE SENATIDB;
USE SENATIDB;

CREATE TABLE marcas
(
	idmarca 	INT AUTO_INCREMENT PRIMARY KEY,
    marca		VARCHAR(30)	NOT NULL,
    create_at	DATETIME	NOT NULL DEFAULT NOW(),
    inactive_at	DATETIME	NULL,
    update_at	DATETIME 	NULL,
    CONSTRAINT uk_marca_mar	UNIQUE (marca)
)
ENGINE = INNODB;

INSERT INTO marcas (marca)
	VALUES
		("Toyota"),
        ("Nissan"),
        ("Volvo"),
        ("Hyundai"),
        ("KIA");
        
CREATE TABLE vehiculos
(
	idvehiculo		INT AUTO_INCREMENT PRIMARY KEY,
    idmarca			INT 		NOT NULL,
    modelo			VARCHAR(50)	NOT NULL,
    color			VARCHAR(30)	NOT NULL,
    tipocombustible CHAR(3)		NOT NULL,
    peso			SMALLINT 	NOT NULL,
    afabricacion	CHAR(4)		NOT NULL,
    placa			CHAR(7)		NOT NULL,
    create_at		DATETIME	NOT NULL DEFAULT NOW(),
    inactive_at		DATETIME	NULL,
    update_at		DATETIME 	NULL,
    CONSTRAINT fk_idmarca_veh FOREIGN KEY (idmarca) REFERENCES marcaS (idmarca),
    CONSTRAINT ck_tipocombustible_veh CHECK (tipocombustible IN ('GLP', 'DSL','GNV','GLP')),
    CONSTRAINT ck_peso_veck CHECK (peso > 0),
	CONSTRAINT uk_placa_vek UNIQUE (placa)
)
ENGINE = INNODB;

DELETE FROM vehiculos;
ALTER TABLE vehiculos auto_increment 1;
ALTER TABLE vehiculos ADD CONSTRAINT uk_placa_vek UNIQUE (placa);

INSERT INTO vehiculos
	(idmarca, modelo, color, tipocombustible, peso, afabricacion, placa)
    VALUES
		(1,'Hilux', 'blanco','DSL',1800,'2020','ABC-111'),
        (2,'Sentra','gris','GLP',1200,'2021','ABC-112'),
        (3,'EX30','negro','GNV',1350,'2023','ABC-113'),
        (4,'Tucson','rojo','GLP',1800,'2022','ABC-114'),
        (5,'Sportage','azul','DSL',1500,'2010','ABC-115');
 
DELIMITER $$
CREATE PROCEDURE spu_vehiculos_buscar(IN _placa CHAR(7))
BEGIN
	SELECT 
		VEH.idvehiculo,
        MAR.marca,
        VEH.modelo,
        VEH.color,
        VEH.tipocombustible,
        VEH.peso,
        VEH.afabricacion,
        VEH.placa
		FROM vehiculos VEH
        INNER JOIN marcas MAR ON MAR.idmarca = VEH.idmarca
        WHERE	(VEH.inactive_at IS NULL)	AND
				(VEH.placa = _placa);
END $$

CALL spu_vehiculos_buscar('ABC-111');

DELIMITER $$
CREATE PROCEDURE spu_vehiculos_registrar(
	IN _idmarca				INT,
	IN _modelo				VARCHAR(50),
    IN _color				VARCHAR(30),
    IN _tipocombustible 	CHAR(3),
    IN _peso				SMALLINT,
    IN _afabricacion		CHAR(4),
    IN _placa				CHAR(7)	
)
BEGIN
	INSERT INTO vehiculos
					(idmarca, modelo, color, tipocombustible, peso, afabricacion, placa)
    VALUES (_idmarca, _modelo, _color, _tipocombustible, _peso, _afabricacion, _placa);
    
    SELECT @@last_insert_id 'idvehiculo';
END $$

CALL spu_vehiculos_registrar(4,'Santa Fe','Guinda','GLP',1900 ,'2020','ABC-777');
CALL spu_vehiculos_registrar(4,'Create','Azul elético','GNV',1200 ,'2023','ABC-128');


DELIMITER $$
CREATE PROCEDURE spu_marcas_listar()
BEGIN
	SELECT
		idmarca,
        marca
        FROM marcas
        WHERE inactive_at IS NULL
        ORDER BY marca;
END$$

DELIMITER $$
CREATE PROCEDURE spu_sede_listar()
BEGIN
	SELECT
		idsede,
        sede
        FROM sedes
        WHERE inactive_at IS NULL
        ORDER BY sede;
END$$

CALL spu_marcas_listar();


-- Consulta de resumen (campos rendundantes (que se puede repetir))
SELECT * FROM vehiculos;

DELIMITER $$
CREATE PROCEDURE spu_resumen_tipocombustible()
BEGIN
	SELECT
		tipocombustible, count(tipocombustible) AS'total'-- Esto es un seudonimo
		FROM vehiculos
        GROUP BY tipocombustible
        ORDER BY total;
END $$

CALL spu_resumen_tipocombustible();




//TRABAJO RECIEN POR REALIZAR//



CREATE TABLE sedes
(
    idsede          INT AUTO_INCREMENT PRIMARY KEY,
    sede            VARCHAR(50),
    create_at       DATETIME    NOT NULL DEFAULT NOW(),
    inactive_at     DATETIME    NULL,
    update_at       DATETIME    NULL,
    CONSTRAINT uk_sede_sed UNIQUE (sede)
)
ENGINE = INNODB;

INSERT INTO sedes (sede)
    VALUES
        ("Chincha"),
        ("Lima"),
        ("Ayacucho"),
        ("Piura"),
        ("Chiclayo");

CREATE TABLE empleados 
(
    idempleado      INT AUTO_INCREMENT PRIMARY KEY,
    idsede          INT,
    apellidos       VARCHAR(30),
    nombres         VARCHAR(30),
    nrodocumento    CHAR(8),
    fechanac        DATE,
    telefono        CHAR(9),
    create_at       DATETIME    NOT NULL DEFAULT NOW(),
    inactive_at     DATETIME    NULL,
    update_at       DATETIME    NULL,
    CONSTRAINT fk_idsede_emp FOREIGN KEY (idsede) REFERENCES sedes (idsede),
    CONSTRAINT uk_nrodoc_emp UNIQUE (nrodocumento)
)
ENGINE = INNODB;

INSERT INTO empleados
    (idsede, apellidos, nombres, nrodocumento, fechanac, telefono)
    VALUES
        (1,'Fernandez Vilpa', 'Manuel',74593456,'2004/08/04',934567892),
        (2,'Aburto Acevedo', 'Jhostyn',74052670,'2005/06/01',937165623),
        (3,'Huaman Verez', 'Marta',43526703,'2003/09/11',947256732),
        (4,'Espino Marez', 'Mirta',45732568,'2003/11/05',945673424),
        (5,'Vera Colon', 'Issac',74563425,'2004/12/08',934567234);

DELIMITER $$
CREATE PROCEDURE spu_empleado_buscar(IN _nrodocumento CHAR(8))
BEGIN
    SELECT 
        EMP.idempleado,
        SED.sede,
        EMP.apellidos,
        EMP.nombres,
        EMP.nrodocumento,
        EMP.fechanac,
        EMP.telefono
    FROM empleados EMP
    INNER JOIN sedes SED ON SED.idsede = EMP.idsede
    WHERE (EMP.inactive_at IS NULL) AND
          (EMP.nrodocumento = _nrodocumento);
END $$

CALL spu_empleado_buscar(45732568);

DELIMITER $$
CREATE PROCEDURE spu_empleados_registrar(
    IN _idsede             INT,
    IN _apellidos         VARCHAR(30),
    IN _nombres           VARCHAR(30),
    IN _nrodocumento      CHAR(8),
    IN _fechanac          DATE,
    IN _telefono          CHAR(9)
)
BEGIN
    INSERT INTO empleados
                (idsede, apellidos, nombres, nrodocumento, fechanac, telefono)
    VALUES (_idsede, _apellidos, _nombres, _nrodocumento, _fechanac, _telefono);
    
    SELECT @@last_insert_id 'idempleado';
END $$

CALL spu_empleados_registrar(2,"Gutierres Alvaron","Hugo", 64983427, "2002/08/04", 946235623);

DELIMITER $$
CREATE PROCEDURE spu_sedes_listar()
BEGIN
    SELECT
        idsede,
        sede
    FROM sedes
    WHERE inactive_at IS NULL
    ORDER BY sede;
END$$

CALL spu_sedes_listar;

DELIMITER $$
CREATE PROCEDURE spu_empleado_listar()
BEGIN
    SELECT
        EMP.idempleado,
        SD.sede AS Sede,
        EMP.apellidos,
        EMP.nombres,
        EMP.nrodocumento,
        EMP.fechanac,
        EMP.telefono
    FROM
        empleados EMP
    LEFT JOIN sedes SD ON EMP.idsede = SD.idsede;
END $$

CALL spu_empleado_listar;

SELECT * FROM empleados;

DROP DATABASE SENATIDB;
