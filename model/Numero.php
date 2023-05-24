<?php
Class Numero{
    public int      $numero;
    public int   $fk_Rifa_id;
    public int   $fk_Pedido_id;
    public string   $creation_time;
    public string   $modification_time;

    public function __construct($c=0, $numero=0, $fk_Rifa_id=0, $fk_Pedido_id=0, $creation_time="", $modification_time="") {
        if($c){
          $this->numero = $numero;
          $this->fk_Rifa_id =  $fk_Rifa_id;
          $this->fk_Pedido_id = $fk_Pedido_id;
          $this->creation_time = $creation_time;
          $this->modification_time = $modification_time;
        }
      }
    
      

  public function getNumero() {
    return $this->numero;
  }

  public function setNumero($numero) {
    $this->numero = $numero;
  }

  public function getRifaId() {
    return $this->fk_Rifa_id;
  }

  public function setRifaId($fk_Rifa_id) {
    $this->fk_Rifa_id = $fk_Rifa_id;
  }

  public function getPedidoId() {
    return $this->fk_Pedido_id;
  }

  public function setPedidoId($fk_Pedido_id) {
    $this->fk_Pedido_id = $fk_Pedido_id;
  }

  public function getCreationTime() {
    return $this->creation_time;
  }

  public function setCreationTime($creation_time) {
    $this->creation_time = $creation_time;
  }

  public function getModificationTime() {
    return $this->modification_time;
  }

  public function setModificationTime($modification_time) {
    $this->modification_time = $modification_time;
  }

}