<?php
    $conexion = mysqli_connect('localhost', 'root', '', 'SENATIDB'); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Empleado</title>
    <link rel="stylesheet" href="../estilos/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Estilos adicionales */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .button-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .button-container button {
            margin-right: 10px;
        }
        .cabezado {
            background-color: #343a40;
            color: #fff;
        }
        .table td,
        .table th {
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
     <div class="container">
        <h2>Mostrar Empleados</h2>

        <div class="button-container">
            <button type="button" class="btn btn-outline-success">
                <a href="registrar-empleado.php" style="color: black; text-decoration: none;">Registrar empleado</a>
            </button>

            <button type="button" class="btn btn-outline-success">
                <a href="buscar-empleados.php" style="color: black; text-decoration: none;">Buscar empleado</a>
            </button>

            <button type="button" class="btn btn-outline-success">
                <a href="Cuadrobarras.php" style="color: black; text-decoration: none;">mostrar cuadro de Barras</a>
            </button>
        </div>
        
        <table class="table">
            <thead>
                <tr class="cabezado">
                    <th>Id Empleado</th>
                    <th>Sede</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Número de Documento</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
            <?php
                //Realiza una llamada al procedimiento almacenado para obtener la lista de empleados.
                //La consulta se ejecuta utilizando mysqli_query y los resultados se almacenan en la variable $result.
                $sql = "CALL spu_empleado_listar();";
                $result = mysqli_query($conexion, $sql);

                //Utilizamos un bucle que recorre los resultados de la consulta SQL y genera filas de una tabla HTML con la información de cada empleado.
                //Mientras haya filas de resultados disponibles, la función mysqli_fetch_array obtiene una fila de resultados como un array asociativo 
                while ($row = mysqli_fetch_array($result)) {
            ?>

            <tr>
                <td><?php echo $row['idempleado'] ?></td>
                <td><?php echo $row['Sede'] ?></td>
                <td><?php echo $row['apellidos'] ?></td>
                <td><?php echo $row['nombres'] ?></td>
                <td><?php echo $row['nrodocumento'] ?></td>
                <td><?php echo $row['fechanac'] ?></td>
                <td><?php echo $row['telefono'] ?></td>
            </tr>

            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>