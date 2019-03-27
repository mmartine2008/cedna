CREATE TABLE dbo.ElementosProteccionPersonal (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_ElementosProteccionPersonal PRIMARY KEY (Id),
);

INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Casco');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Anteojos de Seguridad');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Antiparras');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Calzado de seguridad');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Ropa especial de trabajo');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Chaleco reflectivo');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Arnés Completo');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Mangas de Cuero');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Botas de goma');  
INSERT INTO dbo.ElementosProteccionPersonal(Descripcion) VALUES ('Mameluco');  

        
CREATE TABLE dbo.HerramientasDeTrabajo (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_HerramientasDeTrabajo PRIMARY KEY (Id),
);

INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Compresor');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Perforadoras');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Herramientas Manuales');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Tablero Eléctrico Portátil');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Herramientas Antichispas');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Sogas, Cables, Cadenas');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Sopletes');  
INSERT INTO dbo.HerramientasDeTrabajo(Descripcion) VALUES ('Plataforma autoelevador');  


CREATE TABLE dbo.LugaresDeObra (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_LugaresDeObra PRIMARY KEY (Id),
);  

INSERT INTO dbo.LugaresDeObra(Descripcion) VALUES ('Deposito');  
INSERT INTO dbo.LugaresDeObra(Descripcion) VALUES ('Planta 1');  
INSERT INTO dbo.LugaresDeObra(Descripcion) VALUES ('Planta 2');  
INSERT INTO dbo.LugaresDeObra(Descripcion) VALUES ('Zona 1');  
INSERT INTO dbo.LugaresDeObra(Descripcion) VALUES ('Zona 2');  

CREATE TABLE dbo.ActividadesDeObras (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_ActividadesDeObras PRIMARY KEY (Id),
); 

INSERT INTO dbo.ActividadesDeObras(Descripcion) VALUES ('Pintura');  
INSERT INTO dbo.ActividadesDeObras(Descripcion) VALUES ('Mambo');  
INSERT INTO dbo.ActividadesDeObras(Descripcion) VALUES ('Yeso');  
        

CREATE TABLE dbo.RiesgosAmbientales (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_RiesgosAmbientales PRIMARY KEY (Id),
); 

INSERT INTO dbo.RiesgosAmbientales(Descripcion) VALUES ('Existe posibilidad de incendio');  
INSERT INTO dbo.RiesgosAmbientales(Descripcion) VALUES ('Existe posibilidad de explosión');  
INSERT INTO dbo.RiesgosAmbientales(Descripcion) VALUES ('Existe posibilidad de emisiones de gases tóxicos');  
INSERT INTO dbo.RiesgosAmbientales(Descripcion) VALUES ('Existe posibilidad de emisión de radiación');  
INSERT INTO dbo.RiesgosAmbientales(Descripcion) VALUES ('Existe posibilidad de emisiones de líquidos tóxicos');  

        
 CREATE TABLE dbo.RiesgosAdicionalesFrio (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_RiesgosAdicionalesFrio PRIMARY KEY (Id),
);  

INSERT INTO dbo.RiesgosAdicionalesFrio(Descripcion) VALUES ('Requiere guardia de operación');  
INSERT INTO dbo.RiesgosAdicionalesFrio(Descripcion) VALUES ('Requiere control de emergencia');  
INSERT INTO dbo.RiesgosAdicionalesFrio(Descripcion) VALUES ('Requiere guardia de seguridad');  
INSERT INTO dbo.RiesgosAdicionalesFrio(Descripcion) VALUES ('Requiere equipo contra incendio');  

 
 CREATE TABLE dbo.RiesgosAdicionalesCalor (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_RiesgosAdicionalesCalor PRIMARY KEY (Id),
); 

INSERT INTO dbo.RiesgosAdicionalesCalor(Descripcion) VALUES ('Require uso de pantallas UV');  
INSERT INTO dbo.RiesgosAdicionalesCalor(Descripcion) VALUES ('Requiere presencia de la birgada durante la tarea');  
INSERT INTO dbo.RiesgosAdicionalesCalor(Descripcion) VALUES ('Requiere control preriódico de la Atmosfera');  
INSERT INTO dbo.RiesgosAdicionalesCalor(Descripcion) VALUES ('Requiere etraer los gases o vapores producidos por la tarea');


CREATE TABLE dbo.RiesgosAdicionalesAltura (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_RiesgosAdicionalesAltura PRIMARY KEY (Id),
);

INSERT INTO dbo.RiesgosAdicionalesAltura(Descripcion) VALUES ('Requiere proteger los objetos que pueden caer');  
INSERT INTO dbo.RiesgosAdicionalesAltura(Descripcion) VALUES ('Requiere señalización de la zona de trabajo');  
INSERT INTO dbo.RiesgosAdicionalesAltura(Descripcion) VALUES ('Requiere cambio de escalera');  
INSERT INTO dbo.RiesgosAdicionalesAltura(Descripcion) VALUES ('Requiere cambio de andamio');  


CREATE TABLE dbo.PruebasDeGases (
    Id int IDENTITY(1,1) NOT NULL,
    Descripcion varchar(1000) not null,

    CONSTRAINT PK_PruebasDeGases PRIMARY KEY (Id),
); 

INSERT INTO dbo.PruebasDeGases(Descripcion) VALUES ('LEL, % <= 10');  
INSERT INTO dbo.PruebasDeGases(Descripcion) VALUES ('O2 % 19.5 a 23');  
INSERT INTO dbo.PruebasDeGases(Descripcion) VALUES ('CO, ppm <= 35');  
INSERT INTO dbo.PruebasDeGases(Descripcion) VALUES ('H2S, ppm <= 10');