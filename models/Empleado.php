<?php
require 'Conexion.php';
class Empleado extends Conexion{

  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function add($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_empleados_registrar(?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idsede'],
          $data['apellidos'],
          $data['nombres'],
          $data['nrodocumento'],
          $data['fechanac'],
          $data['telefono']
        )
      );
      
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function search($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_empleado_buscar(?)");
      $consulta->execute(
        array($data['nrodocumento'])
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}