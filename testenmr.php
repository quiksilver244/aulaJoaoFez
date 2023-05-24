<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post">
  <label for="numero">Numero:</label>
  <input type="number" id="numero" name="numero" required>
  <br>
  <label for="fk_Rifa_id">Rifa id:</label>
  <input type="number" id="fk_Rifa_id" name="fk_Rifa_id" required>
  <br>
  <label for="fk_Pedido_id">Pedido id:</label>
  <input type="number" id="fk_Pedido_id" name="fk_Pedido_id" required>
  <br>

  <input type="submit" value="Cadastrar">
</form>
    <?php
    require_once './model/NumeroDAO.php';
    require_once './model/Numero.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numero = $_POST['numero'];
        $fk_Rifa_id = $_POST['fk_Rifa_id'];
        $fk_Pedido_id = $_POST['fk_Pedido_id'];
        // $creation_time = $_POST['creation_time'];
        // $modification_time = $_POST['modification_time'];
    
      $numero = new Numero(true, $numero, $fk_Rifa_id, $fk_Pedido_id, 'CURRENT_TIMESTAMP', 'CURRENT_TIMESTAMP');
    
      //var_dump($numero);

      $numeroDAO = new NumeroDAO();
      $numero = $numeroDAO->insert($numero);
      // $numero = $numeroDAO->selectByNum(1);
      if($numero){
        var_dump($numero);
      }
      else{
        var_dump($numeroDAO->getErro());
      }         
      
    }

    ?>
</body>
</html>