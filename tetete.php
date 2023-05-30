<?php

require_once './model/NumeroDAO.php';
require_once './model/Numero.php';

$numeroDAO = new NumeroDAO();
$numero = $numeroDAO->delete(4, 2, 1);
if($numero){
  var_dump($numero);
}
else{
  var_dump($numeroDAO->getErro());
}