<?php
//1. Acceso al archivo
require 'Conexion.php';

//2. Heredar sus atributos y métodos
class Vehiculo extends Conexion{

  //Este objeto almacenará la conexión y se la facilitará a todos los métodos
  private $pdo;

  //3. Almacenar la conexión en el objeto
  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

  //$data es un arreglo asociativo que contiene los valores
  //requeridos por el SPU para registro vehiculos
  public function add($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_registrar(?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idmarca'],
          $data['modelo'],
          $data['color'],
          $data['tipocombustible'],
          $data['peso'],
          $data['afabricacion'],
          $data['placa']
        )
      );
      //Actualización, ahora retornamos el "idvehiculo"
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  /* ENTRADA */
  public function search($data = []){
    try{
      //El spu requiere el número de placa
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_buscar(?)");
      $consulta->execute(
        array($data['placa'])
      );

      //Devolver el registro encontrado
      //fetch()     :retorna la primera coincidencia (1)
      //fetchAll()  : retorna todas las coincidencia (n)
      //FETCH_ASSOC : define el resultado como un objeto
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function getResumenTipoCombustible(){
    try{
      $consulta = $this->pdo->prepare("CALL spu_resumen_tipocombustible()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }
}

//Prueba - NO OLVIDES BORRAR 
/* 
$vehiculo = new Vehiculo();
$registro = $vehiculo->search(["placa" => "ABC-111"]);
var_dump($registro);
 */