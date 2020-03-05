<html>
  <head>
    <title>Registro</title>
    <link rel=""/>
    <style>
    
    tr.alternado:nth-child(odd) {
    background-color:#f2f2f2;
    }
    tr.alternado:nth-child(even) {
    background-color:#E1DDDD;
    }
    </style>
  </head>
  
  
  
    <body style="background-image:url('');">
      <table CELLPADDING="10">
        <tr>
          <th style="height: 100;color:white;"><font face="sans-serif">REGISTRO</font></th>
          <th style="height: 100;color:white;"><font face="sans-serif">ACCESOS</font></th>
        </tr>
        <tr>
        <td style="background-color:#DCDCDC;">
        <form action="" method="post">
          <p><b><font face="sans-serif">Nombre:</font></b>
          
          //Seleccionar nombre y dalre a Iniciar para insertar nombre y fecha de entrada.
          
          <select name="nombre">

              <option>Nombre 1</option>

              <option>Nombre 2</option>

              <option>Nombre 3</option>

            </select>
          </p>
          <p><b><font face="sans-serif">Descripción:</font></b></p>
          <p><textarea name="descripcion" rows="5" cols="50"></textarea></p>
          <input type="submit" name="Iniciar" value="Iniciar" />
          <input type="submit" name="Desconectar" value="Desconectar" />
          <input type="submit" name="Descargar" value="Exportar a CSV" />
          </form>
          </td>
          <td style="width: 1100; text-align: center;">
          <?php

              $servername = "Servidor_Personal";
              $database = "Nombre_BBDD";
              $username = "Usuario";
              $password = "Cualquiera";

            #Conectando a la base de datos

              $conexion = new mysqli($servername, $username, $password, $database);




          //Pintar la tabla y mostrar los tres primeros registros de cada persona



            $sql = "select * from Nombre_tabla order by fecEntrada DESC LIMIT 3";
		        $mostrar= $conexion->query($sql) or die ("error en la select");
		          if ($mostrar){
			          $fila = $mostrar->fetch_assoc();
                  echo '<table CELLPADDING="10" style="width: 1100;border: 2px solid;border-collapse:collapse; background-color:#B1B1B1;">';
                  
                  echo "<tr>";
                    echo "<th style='border: 3px solid black;'>";
                    echo '<font face="sans-serif">'.'Nombre'."</font>";
                    echo "</th>";
                    echo "<th style='border: 3px solid black;'>";
                    echo '<font face="sans-serif">'."Fecha de entrada"."</font>";
                    echo "</th>";
                    echo "<th style='border: 3px solid black;'>";
                    echo '<font face="sans-serif">'."Fecha de Salida"."</font>";
                    echo "</th>";
                    echo "<th style='border: 3px solid black;'>";
                    echo '<font face="sans-serif">'."Descripción"."</font>";
                    echo "</th>";
                  echo "</tr>";






				          while ($fila){
                  

                 

                 

					        echo '<tr class="alternado" align="left">';
					          echo '<td WIDTH="130px"  style="border: 1px solid black;"">'.'<font face="sans-serif">'."{$fila['Nombre']}"."</font>"."</td>";
					          echo '<td align="center" style="border: 1px solid black;"">'.'<font face="sans-serif">'."{$fila['fecEntrada']}"."</font>"."</td>";
					          echo '<td align="center" style="border: 1px solid black;"">'.'<font face="sans-serif">'."{$fila['fecSalida']}"."</font>"."</td>";
					          echo "<td  style='border: 1px solid black;'>".'<font face="sans-serif">'."{$fila['Descripción']}"."</font>"."</td>";
			            echo "</tr>";
		
			
	            $fila = $mostrar->fetch_assoc();
		          }
              echo "</table>";
            }
              $mostrar->close();
          ?>
         
          </td>
          </tr>
      </table>
  </body>

<?php

#Nueva conexión base de datos


$servername = "Servidor_Personal";
$database = "Nombre_BBDD";
$username = "Usuario";
$password = "Cualquiera";





#Conectando a la base de datos

$conn = new mysqli($servername, $username, $password, $database);



#Iniciar la sesión

if (isset($_POST['Iniciar']))
	{
    
    

  $nombre = $_POST['nombre'];
  $descripcion = $_POST['descripcion'];


  $conn->query("INSERT INTO Nombre_tabla (Nombre, fecEntrada, fecSalida, Descripción) values ('$nombre', NOW(), NULL, '$descripcion')") or die ($conn->error);


  //Actualiza la página para mostrar los campos insertados.

  header( "refresh:3; url=pagina-registro.php" ); 

  echo "<p style='color:white;'>".'<font face="sans-serif">'."Sesión iniciada de forma correcta. Para salir introduce tu nombre y dale al boton de Desconectar"."</font>"."</p>";

  }



#Salida


if (isset($_POST['Desconectar']))
	{
  

  $nombre = $_POST["nombre"];


    $query= ("SELECT ID FROM Nombre_tabla WHERE Nombre ='$nombre' and fecSalida is NULL ");

    $result = $conn->query($query);

    $row = $result->fetch_array(MYSQLI_NUM);


  #Salida registrando la hora, para ello, primero pones el nombre de las opciones y luego le das a desconectar

    $conn->query("UPDATE Nombre_tabla set fecSalida=NOW() where ID='$row[0]'") or die ($conn->error);
    
    //Tras hacer cick en el boton de salir con el nombre puesto en las opciones se actualiza la página y se pinta la hora de salida

    header( "refresh:0.5; url=pagina-registro.php" ); 

    echo "<p style='color:white; >".'<font face="sans-serif">'."Sesión cerrada de forma correcta."."</font>";

  }
  
  //Si le das a exportar te generau archivo donde luego podras descargarlo en la ruta configurada

  if (isset($_POST['Descargar']))

  {

    $conn->query("SELECT * FROM BBDD INTO OUTFILE '/prueba/registro_usuarios_cpd.csv' FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n\r';");

    header( "refresh:0.5;url=pagina-registro.php" );

  }













#Cerrar conexion Base de Datos

$conn->close();



?>
</html>
