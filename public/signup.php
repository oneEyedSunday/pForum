<?php
    require_once("../includes/initialize.php");
    require_once(LIB_PATH.DS."helpers".DS."avi_help.php");
    //require_once(LIB_PATH.DS."helpers".DS."avi_help.php");
    $signinpage = true;
    include("layouts/header.php");

    echo '<h3>Sign Up</h3>';
    if($session->isloggedIn()){
        $session->setMessage("You are already signed in, you can <a href=\"signout.php\">sign out</a> if you want.");
    }
     else {
    	if($_SERVER['REQUEST_METHOD'] == 'GET'){
            ?>
<script type="text/javascript" src="scripts/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="scripts/validateSignUp.js"></script>
        <div class="module">
          <form method="post" action="" enctype="multipart/form-data" autocomplete="off" onsubmit="return checkall();" novalidate>
              <p>
                First Name: <input type="text" name="userfirstname" required/>
              </p>
              <p>
                Surname: <input type="text" name="userlastname" required/>
              </p>
              <p>
                Username: <input type="text" name="username" id="UserName" onblur="checkname();"required/>
                <div class="name_status"></div><br>
              </p>
              <p>
                Password: <input type="password" placeholder="Password" id="password" name="userpass" onkeyup="checklen();" required/>
                <div class="password_length"></div><br>
              </p>
              <p>
                Confirm Password: <input type="password" placeholder="Confirm Password" id="cpassword" name="confirmpassword" required onkeyup="checkpass();" />
                <div class="password_status"></div><br>
              </p>
              <p>
                Email: <input type="email" name="useremail" id="UserEmail" onblur="checkemail();"  required />
                <div class="email_status"></div><br>
                </p>
              <!-- </p> -->
              <div class="avatar"><label>Select your avatar:</label><input type="file" name="avatar" id="avatar" accept="image/*" value="<?php echo DEFAULT_AVI; ?>" /></div>
  
                <input type="submit" name="submit" value="Sign Up" class="btn btn-block btn-primary"/>
              </p>
          </form>

        </div>
       <!--  module -->
<?php
    	} elseif($_SERVER["REQUEST_METHOD"] == "POST"){
            //html5 should take care of this though.
            //added some custom js validation 
            if($_POST['userpass'] == $_POST['confirmpassword']){
                  process_signup();
            }
            else {
                  $_SESSION['message'] = "The passwords do not match!";
                 }
    	}
    }

include('layouts/footer.php');
?>

