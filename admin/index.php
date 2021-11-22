<?php
  //To Handle Session Variables on This Page
  session_start(); 

  //If user is already logged in then redirect them back to dashboard. 
  //This is required if user tries to manually enter login.php in URL.
  if(isset($_SESSION['id_admin'])) {
    header("Location: dashboard2.php");
    exit();
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sports Events</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="../css/admin-login.css">
    <!-- Login page for admin -->
  </head>
  <body>
    
    <!-- NAVIGATION BAR -->
    <header>
      <div class="top-bar">
          <h2>Sports Events</h2>
          <div class="home">
            <h2><a href="../index.php">Home</a></h2>  
          </div>
        </div>
    </header>

    <section>
    
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" action="checklogin.php">
        <h3>Login Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Email or Phone" id="username" name="username">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password">

        <button>Log In</button>

        <?php 
              //If User Failed To log in then show error message.
              if(isset($_SESSION['loginError'])) {
                ?>
                <div>
                  <p class="text-center">Invalid Username/Password! Try Again!</p>
                </div>
              <?php
                unset($_SESSION['loginError']); }
              ?>   
        
    </form>

    </section>
  </body>
</html>