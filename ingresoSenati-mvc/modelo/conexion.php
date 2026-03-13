<?php
# CLASE PARA LA CONEXION AL SERVIDOR Y BASE DE DATOS
class Conexion
{
    # MÉTODO PARA REALIZAR LA CONEXIÓN A LA BASE DE DATOS
    public static function conectar()
    {
        try {
            // Definimos los parámetros de conexión
            $host = "localhost";
            $dbname = "dblogin";
            $username = "root";
            $password = "";

            // Creamos la instancia PDO con opciones para manejo de errores
            $link = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

            // Configurar para que lance excepciones en caso de error
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $link;
        } catch (PDOException $e) {
            // Mostrar mensaje de error en caso de fallo en la conexión
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}