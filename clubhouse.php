<?php
include 'configPDO.php';
include 'data.php';
include 'authentication.php';
include 'clubhouse-logic.php';
include 'shared_functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
  <body>
<?php include 'navbar-signin.php'; ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="bg">
      <div class="row">
        <?php if(isset($signUpPanel) && $signUpPanel) {include 'view_sign_up_panel.php';} 
        else {include 'view_sign_in_panel.php';} ?>  
        <?php if(isset($message) && $message) {include 'view_message.php';} ?> 
      </div>
      <div>
      <?php include 'view_signed_in.php'; ?>
      </div>
      <br /> <br /><br /> <br /><br /> <br /><br /> <br />  
    </div>
    <a href="admin.php" style="color:purple;" class="pull-right">admin</a>
    <?php include 'view_footer.php'; ?>
  </body>
</html>
