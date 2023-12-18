<!doctype html>
<html lang="es">
    <head>
        <title>Buscar Empleado</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>
        
    <body>
        <center><h1>Buscar Empleados</h1></center>
        <div class="container">
            <div class="card mt-2">
                <div class="card-body">
                    <form action="" id="formBusqueda" autocomplete="off">

                        <div class="card-header bg-secondary">
                            <input type="text" maxlength="8" placeholder="Empleado Buscado" id="nrodocumento" class="form-control text-center">
                            <br>
                            <button type="button" class="btn btn-info" id="buscar">Buscar:</button>
                        </div>
                        <small id="status">No hay Búsquedas Activas</small>
                        <br><br>
                        <div class="mb-3">
                            <label for="sede">Sede: </label>
                            <input type="text" id="sede" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="apellidos">Apellido: </label>
                            <input type="text" id="apellidos" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nombres">Nombre: </label>
                            <input type="text" id="nombres" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="fechanac">Fecha de nacimiento: </label>
                            <input type="text" id="fechanac" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="telefono">Telefono: </label>
                            <input type="text" id="telefono" class="form-control" readonly>
                        </div>
                        <button type="button" class="btn btn-outline-success">
                            <a href="mostrar-empleado.php" style="color: black; text-decoration: none;"> <- Regresar</a>
                        </button>

                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {

                function $(id) {return document.querySelector(id)}

                function buscarNrodocumento(){
                    const  nrodocumento = $("#nrodocumento").value

                    if (nrodocumento != ""){
                        const parametros = new FormData()
                        parametros.append("operacion", "search")
                        parametros.append("nrodocumento", nrodocumento)

                        $("#status").innerHTML = "Buscando, por favor espere.."

                        fetch(`../controllers/Empleado.controller.php`, {
                            method: "POST",
                            body: parametros
                        })
                            .then(respuesta => respuesta.json())
                            .then(datos => {
                                if (!datos){
                                    $("#status").innerHTML = "No se encontro el registro"
                                    $("#formBusqueda").reset()
                                    $("#nrodocumento").focus()
                                }else{
                                    $("#status").innerHTML = "Empleado encontrado"
                                    $("#sede").value = datos.sede
                                    $("#apellidos").value = datos.apellidos
                                    $("#nombres").value = datos.nombres
                                    $("#fechanac").value = datos.fechanac
                                    $("#telefono").value = datos.telefono
                                }
                            })
                            .catch(e => {
                                console.error(e)
                            })
                    }
                }

                $("#nrodocumento").addEventListener("keypress", (event) => {
                    if (event.keycode == 13){
                        buscarNrodocumento()
                    }
                })

                $("#buscar").addEventListener("click", buscarNrodocumento)
            })
        </script>
    </body>
</html>
