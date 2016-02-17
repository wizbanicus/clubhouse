<?php
include 'configPDO.php';
include 'data.php';
include 'shared_functions.php';
include 'edit_member-logic.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
  <body>

<?php include 'navbar.php' ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="bg">
      <div class="row">
        <div class="panel">
          <div class="panel-body panel-body-321 meths">
            <form class="form-inline" action="edit_member.php" method="post" autocomplete="off">
      		<div>
                <input class="form-control sign-in <?php if ($members) { echo "awesomplete"; } ?> " 
                <?php if ($members) {
                  echo 'data-list="';
                  foreach ($members as $member) {echo $member['full_name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?> onclick="button_submit()" onblur="button_button()"
                name="member_name" placeholder="name or id number"
                autofocus="autofocus" />
	            <button id="button" type="submit" class="form-control btn btn-success" name="do" value="edit_member" onclick="button_submit()">edit</button>
	         </div><br />
              </form>
              <h2>member</h2>
              <form class="form-inline" action="do_edit_member.php" method="post" autocomplete="off">
              <div onkeypress="button_cancel()">
              <input class="form-control" name="fname" value="<?php if($memberFull['fname']) {echo $memberFull['fname'];}?>" placeholder="first name">
              <input class="form-control" name="lname" value="<?php if($memberFull['lname']) {echo $memberFull['lname'];}?>" placeholder="last name">
              <label for="gender" class="form-control">gender
                <select name="gender" id="gender" >
                  <option value='' <?php if(!$memberFull['gender']) { echo " selected";} ?>>choose</option>
                  <option value="female"<?php if($memberFull['gender'] == 'female') { echo " selected";} ?> >female</option>
                  <option value="male"<?php if($memberFull['gender'] == 'male') { echo " selected";} ?>>male</option>
                  <option value="other"<?php if($memberFull['gender'] == 'other') { echo " selected";} ?>>other</option>
                </select>
              </label>
              <input type="text" class="form-control" name="birthdate" value="<?php if($memberFull['birthdate']) {echo date("d/m/Y", strtotime($memberFull['birthdate']));}?>" >
              <input class="form-control" name="card_no" value="<?php if($memberFull['card_no']) {echo $memberFull['card_no'];}?>" placeholder="card number">
              <input class="form-control" name="comments" value="<?php if($memberFull['comments']) {echo $memberFull['comments'];}?>" placeholder="comments">
              <input class="form-control <?php if (isset($schools) && $schools) { echo "awesomplete"; } ?> " 
                <?php if (isset($schools) && $schools) {
                  echo 'data-list="';
                  foreach ($schools as $school) {echo $school['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?> 
                name="school" value="<?php if($memberFull['school']) {echo $memberFull['school'];}?>" placeholder="school" />
              <input class="form-control <?php if (isset($ethnicities) && $ethnicities) { echo "awesomplete"; } ?> " 
                <?php if (isset($ethnicities) && $ethnicities) {
                  echo 'data-list="';
                  foreach ($ethnicities as $ethnicity) {echo $ethnicity['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?> 
                name="ethnicity" value="<?php if($memberFull['ethnicity']) {echo $memberFull['ethnicity'];}?>" placeholder="ethnicity">
              <input class="form-control <?php if (isset($member_types) && $member_types) { echo "awesomplete"; } ?> " 
                <?php if (isset($member_types) && $member_types) {
                  echo 'data-list="';
                  foreach ($member_types as $member_type) {echo $member_type['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?>  
                name="member_type_name" value="<?php if($memberFull['member_type_name']) {echo $memberFull['member_type_name'];}?>" placeholder="member type">
              <label class="form-control" for="verified">verified
                <input type="checkbox" name="verified" value="1" <?php if($memberFull['verified']) {echo " checked ";}?> >
              </label>
              <input readonly tabindex="-1" class="form-control" name="organisation" value="<?php if($memberFull['organisation']) {echo $memberFull['organisation'];}?>" placeholder="organisation">
              <input readonly tabindex="-1" class="form-control" name="first_visit" value="<?php if($memberFull['first_visit']) {echo $memberFull['first_visit'];}?>" placeholder="date first visit">
              <input readonly tabindex="-1" class="form-control" name="member_id" value="<?php if($memberFull['member_id']) {echo $memberFull['member_id'];} ?>" placeholder="system id">
              <div><h2>contact</h2>
              <input class="form-control" name="street_address" value="<?php if($memberFull['street_address']) {echo $memberFull['street_address'];}?>" placeholder="street address">
              <input class="form-control <?php if (isset($suburbs) && $suburbs) { echo "awesomplete"; } ?> " 
                <?php if (isset($suburbs) && $suburbs) {
                  echo 'data-list="';
                  foreach ($suburbs as $suburb) {echo $suburb['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?>  
                name="suburb" value="<?php if($memberFull['suburb']) {echo $memberFull['suburb'];}?>" placeholder="suburb">
              <input class="form-control <?php if (isset($cities) && $cities) { echo "awesomplete"; } ?> " 
                <?php if (isset($cities) && $cities) {
                  echo 'data-list="';
                  foreach ($cities as $city) {echo $city['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?>  
                name="city" value="<?php if($memberFull['city']) {echo $memberFull['city'];}?>" placeholder="city">
              <input class="form-control <?php if (isset($countries) && $countries) { echo "awesomplete"; } ?> " 
                <?php if (isset($countries) && $countries) {
                  echo 'data-list="';
                  foreach ($countries as $country) {echo $country['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?>  
                name="country" value="<?php if($memberFull['country']) {echo $memberFull['country'];}?>" placeholder="country">
              <input class="form-control <?php if (isset($states) && $states) { echo "awesomplete"; } ?> " 
                <?php if (isset($states) && $states) {
                  echo 'data-list="';
                  foreach ($states as $state) {echo $state['name'] . ',';} 
                  echo '" data-autofirst="true"'; }
                ?>  
                name="state" value="<?php if($memberFull['state']) {echo $memberFull['state'];}?>" placeholder="state">
              <input class="form-control" name="zip_code" value="<?php if($memberFull['zip_code']) {echo $memberFull['zip_code'];}?>" placeholder="zip_code">
              <input class="form-control" name="phone1" value="<?php if($memberFull['phone1']) {echo $memberFull['phone1'];}?>" placeholder="phone1">
              <input class="form-control" name="phone2" value="<?php if($memberFull['phone2']) {echo $memberFull['phone2'];}?>" placeholder="phone2">
              <input class="form-control" name="phone3" value="<?php if($memberFull['phone3']) {echo $memberFull['phone3'];}?>" placeholder="phone3">
              </div>
              <div><h2>emergency</h2>
              <input class="form-control" name="guardian_fname" value="<?php if($memberFull['guardian_fname']) {echo $memberFull['guardian_fname'];}?>" placeholder="guardian first name">
              <input class="form-control" name="guardian_lname" value="<?php if($memberFull['guardian_lname']) {echo $memberFull['guardian_lname'];}?>" placeholder="guardian last name">
              <input class="form-control" name="guardian_relationship" value="<?php if($memberFull['guardian_relationship']) {echo $memberFull['guardian_relationship'];}?>" placeholder="guardian relationship">
              <input class="form-control" name="guardian_phone1" value="<?php if($memberFull['guardian_phone1']) {echo $memberFull['guardian_phone1'];}?>" placeholder="guardian phone1">
              <input class="form-control" name="guardian_phone2" value="<?php if($memberFull['guardian_phone2']) {echo $memberFull['guardian_phone2'];}?>" placeholder="guardian phone2">
              <input class="form-control" name="emergency_fname" value="<?php if($memberFull['emergency_fname']) {echo $memberFull['emergency_fname'];}?>" placeholder="emergency first name">
              <input class="form-control" name="emergency_lname" value="<?php if($memberFull['emergency_lname']) {echo $memberFull['emergency_lname'];}?>" placeholder="emergency last name">
              <input class="form-control" name="emergency_relationship" value="<?php if($memberFull['emergency_relationship']) {echo $memberFull['emergency_relationship'];}?>" placeholder="emergency relationship">
              <input class="form-control" name="emergency_phone1" value="<?php if($memberFull['emergency_phone1']) {echo $memberFull['emergency_phone1'];}?>" placeholder="emergency phone1"> 
              <input class="form-control" name="emergency_phone2" value="<?php if($memberFull['emergency_phone2']) {echo $memberFull['emergency_phone2'];}?>" placeholder="emergency phone2">
              </div>
              </div>
              <div class="pull-right">
                <button class="btn btn-success" type="submit" name="member_button" value="save">save</button>
                <button class="btn btn-warning" id="done" type="submit" name="member_button" value="cancel" onmouseup="button_done()" >done</button>
                <button class="btn btn-danger" type="submit" name="member_button" value="delete">delete</button>
              </div>
            </form>
          </div>
        </div>  
        <?php if(isset($message) && $message) {include 'view_message.php';} ?>   
      </div>
      <br /> <br /><br /> <br /><br /> <br /><br /> <br />  
    </div>
    <?php include 'view_footer.php' ?>      
  </body>
</html>
