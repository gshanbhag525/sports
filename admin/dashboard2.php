<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter dashboard.php in URL.
if(empty($_SESSION['id_admin'])) {
	header("Location: index.php");
	exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/styles.css">
    
    <title>Sports Events </title>

  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <ul>
        <li>
            <a href="#">
              <i class="fa fa-tachometer">
              </i>
              <div class="title">Dashboard</div>
            </a>
          </li>
          <li>
            <a href="category.php">
              <i class="fa fa-list-alt">
              </i>
              <div class="title">Categories</div>
            </a>
          </li>
          <li>
            <a href="event.php">
              <i class="fa fa-calendar-alt">
              </i>
              <div class="title">Events</div>
            </a>
          </li>
          <li>
            <a href="../logout.php">
              <i class="fa fa-unlock-alt">
              </i>
              <div class="title">Logout</div>
            </a>
          </li>
        </ul>      
      </div>

      <div class="main">
        <div class="top-bar">
          <div class="search">
            <input type="text" name="search" placheholder="search here">
            <label for="search"><i class="fas fa-search"></i></label>
          </div>
          <div class="user">
            <h2>Admin</h2>  
          </div>
          <div class="logout">
            <a href="../logout.php">Logout</a>
          </div>
        </div>

        <div class="cards">
          <div class="card">
            <div class="card-content">
              <div class="number">
              <?php
                $sql = "SELECT * FROM categories";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  echo $result->num_rows; 
                }
              ?>
              </div>
              <div class="card-name">Event Categories</div>
            </div>
            <div class="icon-box">
              <i class="fa fa-list-alt"></i>
            </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="number">
              <?php
                $sql = "SELECT * FROM events";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  echo $result->num_rows; 
                }
              ?>
              </div>
              <div class="card-name">Events</div>
            </div>
            <div class="icon-box">
              <i class="fa fa-calendar-alt"></i>
            </div>
          </div>
        </div>

        <div class="tables">
          <div class="event-categories">
            <div class="heading">
              <h2>Total Categories</h2>
              <a href="category.php" class="btn"> View all</a>
            </div>
            <table class="categories">
              <thead>
                <td>Sno</td>
                <td>Category</td>
                <td>Action</td>
              </thead>
              <tbody>
              <?php
                $sql = "SELECT * FROM categories";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                          <i class="far fa-eye"></i>
                          <i class="far fa-edit"></i>
                          <a href="delete-category.php?id=<?php echo $row['category_id']; ?>">
                            <i class="far fa-trash-alt"></i>
                          </a>
                        </td>
                        
                      </tr>
                    <?php
                  }
                }
              ?>
                <!-- <tr>
                  <td>1</td>
                  <td>Cricket</td>
                  <td>
                    <i class="far fa-eye"></i>
                    <i class="far fa-edit"></i>
                    <i class="far fa-trash-alt"></i>
                  </td>
                </tr> 
              -->
              </tbody>
            </table>
          </div>
          <div class="events">
            <div class="heading">
              <h2>Total Events</h2>
              <a href="event.php" class="btn"> View all</a>
            </div>
            <table class="events-data">
              <thead>
                <td>Sno</td>
                <td>Name</td>
                <td>Description</td>
                <td>Date</td>
                <!-- <td>Image</td> -->
                
                <td>Action</td>
              </thead>
              <tbody>
              <?php
                $sql = "SELECT * FROM events";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                  $i = 0;
                  while($row = $result->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['e_date']; ?></td>
                        <!-- <td><?php echo $row['e_image']; ?></td> -->
                        <td>
                          <i class="far fa-eye"></i>
                          <i class="far fa-edit"></i>
                          <a href="delete-category.php?id=<?php echo $row['category_id']; ?>">
                            <i class="far fa-trash-alt"></i>
                          </a>
                        </td>
                        
                      </tr>
                    <?php
                  }
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>



  </body>
</html>