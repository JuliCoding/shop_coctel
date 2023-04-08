<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pedidos</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Realizar pedido</h1>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> Id usuario : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Colocado en : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Nombre : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Número : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Correo : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Dirección : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Total productos : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Total precio : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Método de pago : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">Pendiente</option>
               <option value="completed">Completado</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Eliminar este pedido?');" class="delete-btn">Eliminar</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No hay pedidos realizados todavía!</p>';
      }
      ?>
   </div>

</section>




<script src="js/admin_script.js"></script>

</body>
</html>