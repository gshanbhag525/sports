<?php
  //To Handle Session Variables on This Page
  session_start();
  //Including Database Connection From db.php file to avoid rewriting in all files
  require_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Sports Events</title>
  </head>
  <body>

    <div class="container">
      <div class="top-bar">
          <h2 id="logo">Sports Events</h2>

          <div class="search">
            <input id="search" type="text" name="search" placheholder="search here">
            <label id="searchLabel" for="search"><i class="fas fa-search"></i></label>
          </div>
          <div class="user">
            <h4>
              <?php if(isset($_SESSION['id_admin'])) 
                echo '<a href="admin/dashboard2.php">Dashboard</a>';?>
            </h4>  
          </div>
          <div class="logout">
          <?php if (isset($_SESSION['id_admin']) ) echo '<a href="logout.php">Logout</a>'; ?>
          </div>
      </div>
      <div class="main">

      <?php
      $limit = 6;
      $sql = "SELECT * FROM events where e_Featured=1 and e_isEnabled=1 limit $limit";
      $result = $conn->query($sql);

      $count=$result->num_rows;
      if($count>= 1){
          while ($row = $result->fetch_array()) {
              $rows[]=$row;
          }
          $sliderList=$rows;
      }
    ?>
      <div class="slideshow-container">
      <?php
          $a=0;
          if(count($sliderList)){
              foreach ($sliderList as $value) {
                if($a==0){ ?>

                  <div class="mySlides fade">
                      <div class="event-type">Featured Events </div>

                      <div class="numbertext"><?php echo $a+1; ?> / <?php echo $count; ?> </div>
                      
                      <?php echo '<img class="mySlidesImages" src="data:image/jpg;base64,'.base64_encode($value["e_image"] ).'" />' ?>
                      
                      <div class="text"><?php echo $value["name"]." event on";?> <br>
                        <?php $dtime = new DateTime($value['e_date']);
                            echo $dtime->format("jS F Y") ; ?>
                      </div>

                  </div>
                <?php
                  $a++;
                ?>
          
                <a class="prev">&#10094;</a>
                <a class="next">&#10095;</a>
                
              <?php  } else { ?>
                  
                <div class="mySlides fade">
                    <div class="event-type">Featured Events </div>
                    
                    <div class="numbertext"><?php echo $a+1; ?> / <?php echo $count; ?> </div>
                  
                    <?php echo '<img class="mySlidesImages" src="data:image/jpg;base64,'.base64_encode($value["e_image"] ).'" />' ?>
                    
                    <div class="text"><?php echo $value["name"]." event on";?> <br>
                      <?php $dtime = new DateTime($value['e_date']);
                          echo $dtime->format("jS F Y") ; ?>
                    </div>
                </div>
                  
                <?php
                  $a++;
                } 
              }
            } ?>

        <div style="text-align:center">
        <?php
            $i=0;
            if(count($sliderList)){
              foreach ($sliderList as $value) {
                if($i==0){   ?>
                  <span class="dot"></span>
                  <?php $i++;
                }
                  else
                { ?>
                  <span class="dot"></span>
                  <?php $i++;
                }
              }
            } ?>
        </div>
      </div>      
    </div>
  </div>

  <script type="text/javascript">

    (function() {

    init(); //on page load - show first slide, hidethe rest

    function init() {

      parents = document.getElementsByClassName('slideshow-container');

      for (j = 0; j < parents.length; j++) {
        var slides = parents[j].getElementsByClassName("mySlides");
        var dots = parents[j].getElementsByClassName("dot");

        slides[0].classList.add('active-slide');
        dots[0].classList.add('active');
      }

    }

  dots = document.getElementsByClassName('dot'); //dots functionality

  for (i = 0; i < dots.length; i++) {

    dots[i].onclick = function() {

      slides = this.parentNode.parentNode.getElementsByClassName("mySlides");

      for (j = 0; j < this.parentNode.children.length; j++) {
        this.parentNode.children[j].classList.remove('active');
        slides[j].classList.remove('active-slide');
        if (this.parentNode.children[j] == this) {
          index = j;
        }
      }
      this.classList.add('active');
      slides[index].classList.add('active-slide');

    }
  }
  //prev/next functionality
  links = document.querySelectorAll('.slideshow-container a');

  for (i = 0; i < links.length; i++) {
    links[i].onclick = function() {
      current = this.parentNode;

      var slides = current.getElementsByClassName("mySlides");
      var dots = current.getElementsByClassName("dot");
      curr_slide = current.getElementsByClassName('active-slide')[0];
      curr_dot = current.getElementsByClassName('active')[0];
      curr_slide.classList.remove('active-slide');
      curr_dot.classList.remove('active');
      if (this.className == 'next') {

        if (curr_slide.nextElementSibling.classList.contains('mySlides')) {
          curr_slide.nextElementSibling.classList.add('active-slide');
          curr_dot.nextElementSibling.classList.add('active');

        } else {
          slides[0].classList.add('active-slide');
          dots[0].classList.add('active');
        }
      }

      if (this.className == 'prev') {

        if (curr_slide.previousElementSibling) {
          curr_slide.previousElementSibling.classList.add('active-slide');
          curr_dot.previousElementSibling.classList.add('active');
        } else {
          slides[slides.length - 1].classList.add('active-slide');
          dots[slides.length - 1].classList.add('active');
        }
      }
    }
  }
  })();
    </script>
  </body>
</html>