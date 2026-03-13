<?php
    class MvcControlador{

        public function pagina(){
            
            include "vista/principal.php";
        }
        // ====================================================================
        # METODO PARA DIRECCIONAR PAGINAS MEDIANTE MVC

        public function enlacesPaginasControlador(){

            if(isset($_GET['action'])){
                
                $enlace = $_GET['action'];
            }

            else{

                $enlace = "index";

            }
            
            $respuesta = Paginas::enlacesPaginasModelo($enlace);

            include $respuesta;
        }
        // ====================================================================
        # METODO PARA REGISTRO DE USUARIOS

        public  function registroUsuarioControlador(){

            if(isset($_POST["usuarioRegistro"])){

                $datosControlador = array(  "usuario" => $_POST["usuarioRegistro"],
                                            "nombre" => $_POST["nombreRegistro"],
                                            "email" => $_POST["emailRegistro"],
                                            "password" => $_POST["passwordRegistro"],
                                        );

                 // Crear una instancia de la clase Datos
                 $datos = new Datos();
                $respuesta = $datos->registroUsuarioModelo($datosControlador, "usuarios");


                if($respuesta == "success"){

                    header("location:index.php?action=ok");
                    //header("location:index.php?action=ok#signup-agile");

                }else{
                    header("location:index.php");
                }


            }
        }
        // ====================================================================
        #METODO PARA INGRESAR AL SISTEMA POR LOGIN 

        public function ingresoUsuarioControlador(){

            if(isset($_POST["usuarioIngreso"])){

                $datosControlador = array(  "usuario" => $_POST["usuarioIngreso"],
                                            "password" => $_POST["passwordIngreso"],
                                        );

               // Crear una instancia de la clase Datos
                 $datos = new Datos();

                // Llamar al método de la instancia
                 $respuesta = $datos->ingresoUsuarioModelo($datosControlador, "usuarios");

                

                if($respuesta["usuario"]==$_POST["usuarioIngreso"] && $respuesta["password"]==$_POST["passwordIngreso"]){

                    session_start();

                    $_SESSION["validar"] = true;
                    
                    header("location:index.php?action=usuarios");

                }else{

                    header("location:index.php?action=fallo");
                }
            }

        }

        #METODO PARA LISTAR USUARIOS EN TABLA

        // Método para listar usuarios en tabla
public function vistaUsuariosControlador(){

    $datos = new Datos(); // Crear una instancia de la clase Datos
    $respuesta = $datos->vistaUsuariosModelo("usuarios"); // Llamar al método a través de la instancia

    foreach($respuesta as $row => $item){
        echo    '<tr>
                    <td>'.$item["id"].'</td>
                    <td>'.$item["usuario"].'</td>
                    <td>'.$item["nombre"].'</td>
                    <td>'.$item["email"].'</td>
                    <td>'.$item["password"].'</td>
                    <td><a class="btn btn-warning" href="index.php?action=editar&id='.$item["id"].'">Editar</a></td>
                    <td>
                    <a class="btn btn-danger" onclick="javascript:return confirm("¿Seguro de eliminar este registro?");" href="index.php?action=usuarios&idBorrar='.$item["id"].'">Borrar</a>
                    </td>
                </tr>';
    }
}

        
	#EDITAR USUARIO
	#------------------------------------
  
 public function editarUsuarioControlador() {
    if (isset($_GET["id"])) {
        // Obtenemos el ID del usuario que queremos editar
        $datosControlador = $_GET["id"];

        // Creamos una instancia de la clase Datos
        $datos = new Datos();

        // Llamamos al modelo para obtener los datos del usuario a editar
        $respuesta = $datos->editarUsuarioModelo($datosControlador, "usuarios");

        // Verificamos si se encontró el usuario
        if ($respuesta) {
            // Mostramos el formulario de edición con los valores actuales
            echo '
                <form method="POST">
                    <input type="hidden" value="' . htmlspecialchars($respuesta["id"]) . '" class="form-control" name="idEditar">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" value="' . htmlspecialchars($respuesta["usuario"]) . '" class="form-control" name="usuarioEditar" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre y Apellido</label>
                        <input type="text" value="' . htmlspecialchars($respuesta["nombre"]) . '" class="form-control" name="nombreEditar" required>
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" value="' . htmlspecialchars($respuesta["email"]) . '" class="form-control" name="emailEditar" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" value="' . htmlspecialchars($respuesta["password"]) . '" class="form-control" name="passwordEditar" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="actualizarUsuario">Actualizar Registro</button>
                        <a href="index.php?action=usuarios" class="btn btn-secondary">Volver</a>
                    </div>
                </form>';
        } else {
            echo "Usuario no encontrado.";
        }
    }
}

# https://www.youtube.com/watch?v=76Tz7mjpg-E

	#ACTUALIZAR USUARIO
	#------------------------------------

public function actualizarUsuarioControlador() {
    if (isset($_POST["actualizarUsuario"])) {
        // Recibimos los datos del formulario
        $datosControlador = array(
            "id" => $_POST["idEditar"],
            "usuario" => $_POST["usuarioEditar"],
            "nombre" => $_POST["nombreEditar"],
            "email" => $_POST["emailEditar"],
            "password" => $_POST["passwordEditar"]
        );

        // Crear una instancia de la clase Datos
        $datos = new Datos();

        // Llamamos al método para actualizar el usuario
        $respuesta = $datos->actualizarUsuarioModelo($datosControlador, "usuarios");

        // Verificamos si la actualización fue exitosa
        if ($respuesta == "success") {
            // Mensaje de éxito
            $_SESSION["mensaje"] = "Usuario actualizado correctamente.";
            // Redirigimos al usuario a la página de usuarios con el mensaje
            header("location:index.php?action=usuarios");
            exit(); // Aseguramos que el script se detenga aquí
        } else {
            // Si ocurre un error, mostramos un mensaje
            $_SESSION["mensaje"] = "Error al actualizar el usuario.";
            header("location:index.php?action=editar&id=" . $_POST["idEditar"]);
            exit(); // Aseguramos que el script se detenga aquí
        }
    }
}


 

	#BORRAR USUARIO
	#------------------------------------
	// Método para borrar un usuario
public function borrarUsuarioControlador(){

    if(isset($_GET["idBorrar"])){

        $datosControlador = $_GET["idBorrar"];

        // Crear una instancia de la clase Datos
        $datos = new Datos();

        // Llamar al método borrarUsuarioModelo a través de la instancia
        $respuesta = $datos->borrarUsuarioModelo($datosControlador, "usuarios");

        if($respuesta == "success"){
            header("location:index.php?action=usuarios");
        }
    }
}





        
    }

?>