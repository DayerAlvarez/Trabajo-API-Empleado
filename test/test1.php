<?php

//Variables
$apellidos = "De la Cruz Peñaloza";
$nombres = "Yazuri Fiorella";

//Constantes
define("DNI", "72845296");

//echo $apellidos ." ". $nombres ." ". DNI;

//Arreglo (1) - UNI-DIMENSIONAL
$amigos = array("Selene", "Viviana", "Camila", "Yasmin", "Renata", "Ariana");
$paises = ["Perú", "Argentina", "Venezuela", "Brasil"];

//Función imprime: Tipo, Longitud, Dato (DEBUG)
//var_dump($amigos);

/*  
foreach($paises as $pais){
  echo $pais;
}
*/

//Arreglo (2) MULTI-DIMENSIONAL
$softwares = [
  ["Eset", "Avast", "Windows Defender", "Avira", "Karspersky"],
  ["WarZone", "GOW", "FreeFire", "Pepsiman", "MarioBross"],
  ["VSCode", "NetBeans", "AndroidStudio", "Pseint"]
];

/*  
echo $softwares[0][3] . "<br>"; //avira
echo $softwares[2][0] . "<br>"; //VSCode
echo $softwares[2][2] . "<br>"; //Android Studio
echo $softwares[1][0] . "<br>"; //WarZone
*/

/* 
foreach($softwares as $lista){
  foreach($lista as $software){
    echo $software . "<br>";
  }
}
*/

//Arreglo (3) ASOCIATIVO (sin índice)
//PHP, JS (Asociativo), JAVA (Mapas), C# (Listas), Python (Diccionario)
$catalogo = [
  "so" => "Windows 10",
  "antivirus" => "Panda",
  "utilitario" => "WinRAR",
  "videojuego" => "MarioBross"
];

//echo $catalogo["utilitario"];

//Arreglo (4) MULTIDIMENSIONAL + ASOCIATIVO (con/sin índice)
$desarrollador = [
  "datospersonales" => [
    "apellidos" => "de la cruz peñaloza",
    "nombres"   => "Eloy Alexander",
    "edad"      => 18,
    "telefono"  => ["920520306", "987456123"]
  ],
  "formacion"       => [
    "inicial"   => ["Sebastian Barranca"],
    "primaria"  => ["Sebastian Barranca"],
    "secundaria"=> ["John F. Kennedy", "Maranguita School"]
  ],
  "habilidades"     => [
    "bd"        => ["MySQL", "MSSQL", "MONGODB"],
    "Frameworks"=> ["Laravel", "CodeIgniter","Hibernite", "Zend"]
  ]
];

//echo "<pre>";
//var_dump($desarrollador);
//echo "</pre>";

echo json_encode($desarrollador);

