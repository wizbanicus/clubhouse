  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div id="navbar">
			<a class="navbar-brand pull-left" href="#"><small>Clubhouse sign in - admin</small></a>
          <span style="color:white;" class="pull-right">
	          <?php  if(isset($_SESSION['user']) && $_SESSION['user']) { echo 'hi ' . $_SESSION['user'] . 
              '  ' . '<a href="do_logout.php"><span class="glyphicon glyphicon-log-out"> </span></a>';}
             ?> 
          </span>
 			<span><?php if (isset($signedInMembers) && $signedInMembers) { echo '<h2 style="color:white;">' . count($signedInMembers) . "</h2>"; } ?></span>
        </div><!--/.navbar-collapse -->
      </div>

    </nav>
                   
