        <div class="panel">
          <div class="panel-body">
            <form class="form-inline" action="do_sign_in_out.php" method="post" autocomplete="off"> 
            <input id="inout" class="<?php if($members) { echo 'awesomplete';} ?> form-control sign-in" 
                <?php if ($members) {
            echo 'data-list="';
            foreach ($members as $member) {
              echo $member['full_name'] . ',';
                    }
                    echo '"';
                }?>
            name="member_name" placeholder="name or id number"
            autofocus="autofocus" data-autofirst="true" />
            <button type="submit" class="form-control btn btn-success" name="sign" value="in">go!</button>
            </form>
          </div>
        </div> 
        

