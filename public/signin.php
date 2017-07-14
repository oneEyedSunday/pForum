<?php
    require_once("../includes/initialize.php");
    $signinpage = true;

    include("layouts/header.php");

    echo '<h3>Sign In</h3>';
    echo $session->getMessage();
    if($session->isloggedIn()){
        $session->setMessage("You are already signed in, you can <a href=\"signout.php\">sign out</a> if you want.");
    }
     else {
      if($_SERVER['REQUEST_METHOD'] == 'GET'){
            ?>
              <form method="post" action="">
                <p>
                  <label>Username/Email: </label> <input type="text" name="usercred" required/>
                </p>
                <p>
                  <label>Password: </label><input type="password" name="userpass" required/>
                </p>
                <p>
                  <input type="submit" value="Sign in" />
                </p>
             </form>
<?php
      } elseif($_SERVER["REQUEST_METHOD"] == "POST"){
            //html5 should take care of this though.
                $errors = array();
                if(!isset($_POST['usercred'])){
                  $errors[]= 'The username/email field cannot be blank';
                }
                if(!isset($_POST['userpass'])){
                  $errors[] = 'The password field cant be blank.';
                }
                if(!empty($errors)){
                  echo 'Uh-oh.. a couple of fields are not filled in correctly..';
                echo '<ul>';
                foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
                {
                    echo '<li>' . $value . '</li>'; /* this generates a nice error list */
                }
                echo '</ul>';
            }else {
              $user = User::authenticate($database->escapeValue($_POST["usercred"]), $database->escapeValue($_POST["userpass"]));
              //print_r ($user);
              if($user){
                //print_r($user);
                $session->login($user);
                $e = 'Welcome, '.$session->userName();
                $session->setMessage($e);
                redirect_to("index.php");

              }else{
                $e = 'Username/email and password ombo wrong.';
                $session->setMessage($e);
                redirect_to("signin.php");
              }
            }
      }
    }

include('layouts/footer.php');
?>