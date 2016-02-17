<?php
include 'configPDO.php';
include 'db.php';
include 'data.php';
include 'admin-logic.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>
  <body>


<?php include 'navbar.php' ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="bg">
      <div class="row">
        <div class="panel">
          <div class="panel-body meths">
          <?php 
            if (isset($_SESSION['user']) && $_SESSION['user'] ) 
              { if ($_SESSION['role'] == "admin") {
                include 'view_admin_options.php';  
                } else {include 'view_choose_mode.php';}
              } else
              { include 'view_authenticate_panel.php';} 
          ?>
          </div>
        </div>  
        <?php if(isset($message) && $message) {include 'view_message.php';} ?>   
      </div>
      <br /> <br /><br /> <br /><br /> <br /><br /> <br />  
    </div>
    <?php include 'view_footer.php'; ?>


  </body>
</html>
