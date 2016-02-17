        <div class="panel">
          <div class="panel-body">
            <h4>You're not a member yet, tell us abut yourself!</h4>
            <form class="form-inline" action="do_self_sign_up.php" method="post">
            <input type="text" class="form-control" name="fname" placeholder="first name" required autofocus="autofocus" />
            <input type="text" class="form-control" name="lname" placeholder="last name" required/>
            <label for="dob">birthdate</label>
            <input id="dob" type="text" class="form-control" name="birthdate" value="null" />
 
            <label for="gender" class="form-control">gender
            <select name="gender" id="gender" required>
              <option value="null" selected>click to choose</option>
              <option value="female">female</option>
              <option value="male">male</option>
              <option value="other">other</option>
            </select>
            </label>
            <button type="submit" class="form-control btn btn-success" name="sign" value="up">Sign up</button>
            </form>
            <form class="form-inline" action="clubhouse.php">
              <button class="form-control btn btn-warning pull-right" name="sign" value="cancel">Cancel</button>
            </form>
          </div>
        </div> 
