-- Asegúrate de estar en la base de datos correcta
CREATE DATABASE RegistroPeliculas;
GO

USE RegistroPeliculas;
GO

-- Tabla: Géneros
CREATE TABLE Generos (
    IdGenero INT PRIMARY KEY IDENTITY(1,1),
    Nombre VARCHAR(50) NOT NULL UNIQUE
);
GO

-- Tabla: Plataformas (Netflix, Cine, Prime, etc.)
CREATE TABLE Plataformas (
    IdPlataforma INT PRIMARY KEY IDENTITY(1,1),
    Nombre VARCHAR(50) NOT NULL UNIQUE
);
GO

-- Tabla: Directores
CREATE TABLE Directores (
    IdDirector INT PRIMARY KEY IDENTITY(1,1),
    NombreCompleto VARCHAR(100) NOT NULL
);
GO

-- Tabla: Películas
CREATE TABLE Peliculas (
    IdPelicula INT PRIMARY KEY IDENTITY(1,1),
    Titulo VARCHAR(150) NOT NULL,
    Anio INT CHECK (Anio >= 1888 AND Anio <= YEAR(GETDATE())),
    DuracionMin INT CHECK (DuracionMin > 0),
    IdGenero INT NOT NULL,
    IdDirector INT NOT NULL,
    FOREIGN KEY (IdGenero) REFERENCES Generos(IdGenero),
    FOREIGN KEY (IdDirector) REFERENCES Directores(IdDirector)
);
GO

-- Tabla intermedia: Películas en Plataformas (muchos a muchos)
CREATE TABLE PeliculasPlataformas (
    IdPelicula INT NOT NULL,
    IdPlataforma INT NOT NULL,
    PRIMARY KEY (IdPelicula, IdPlataforma),
    FOREIGN KEY (IdPelicula) REFERENCES Peliculas(IdPelicula),
    FOREIGN KEY (IdPlataforma) REFERENCES Plataformas(IdPlataforma)
);
GO

-- Tabla: Historial de visualización
CREATE TABLE HistorialVisualizacion (
    IdHistorial INT PRIMARY KEY IDENTITY(1,1),
    IdPelicula INT NOT NULL,
    FechaVista DATE NOT NULL,
    Estado VARCHAR(20) NOT NULL CHECK (Estado IN ('Por ver', 'Viendo', 'Vista', 'Favorita', 'Recomendada')),
    Puntuacion INT CHECK (Puntuacion BETWEEN 1 AND 10),
    Comentario VARCHAR(500),
    FOREIGN KEY (IdPelicula) REFERENCES Peliculas(IdPelicula)
);
GO

ALTER TABLE Peliculas ADD Activo BIT NOT NULL DEFAULT 1;
GO

CREATE PROCEDURE sp_RegistrarPelicula
    @Titulo VARCHAR(150),
    @Anio INT,
    @DuracionMin INT,
    @IdGenero INT,
    @IdDirector INT
AS
BEGIN
    INSERT INTO Peliculas (Titulo, Anio, DuracionMin, IdGenero, IdDirector, Activo)
    VALUES (@Titulo, @Anio, @DuracionMin, @IdGenero, @IdDirector, 1);
END
GO

CREATE PROCEDURE sp_ActualizarPelicula
    @IdPelicula INT,
    @Titulo VARCHAR(150),
    @Anio INT,
    @DuracionMin INT,
    @IdGenero INT,
    @IdDirector INT
AS
BEGIN
    UPDATE Peliculas
    SET Titulo = @Titulo,
        Anio = @Anio,
        DuracionMin = @DuracionMin,
        IdGenero = @IdGenero,
        IdDirector = @IdDirector
    WHERE IdPelicula = @IdPelicula AND Activo = 1;
END
GO

CREATE PROCEDURE sp_EliminarPelicula
    @IdPelicula INT
AS
BEGIN
    UPDATE Peliculas
    SET Activo = 0
    WHERE IdPelicula = @IdPelicula;
END
GO

CREATE PROCEDURE sp_ListarPeliculas
AS
BEGIN
    SELECT p.IdPelicula, p.Titulo, p.Anio, p.DuracionMin,
           g.Nombre AS Genero, d.NombreCompleto AS Director
    FROM Peliculas p
    INNER JOIN Generos g ON p.IdGenero = g.IdGenero
    INNER JOIN Directores d ON p.IdDirector = d.IdDirector
    WHERE p.Activo = 1;
END
GO

CREATE PROCEDURE sp_ObtenerPeliculaPorId
    @IdPelicula INT
AS
BEGIN
    SELECT p.IdPelicula, p.Titulo, p.Anio, p.DuracionMin,
           g.Nombre AS Genero, d.NombreCompleto AS Director
    FROM Peliculas p
    INNER JOIN Generos g ON p.IdGenero = g.IdGenero
    INNER JOIN Directores d ON p.IdDirector = d.IdDirector
    WHERE p.IdPelicula = @IdPelicula AND p.Activo = 1;
END
GO
