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
    <link rel="stylesheet" href="../css/categories.css">
    
    <title>Sports Events </title>

  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <ul>
        <li>
            <a href="dashboard2.php">
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
            <input id="search" type="text" name="search" placheholder="search here">
            <label id="searchLabel" for="search"><i class="fas fa-search"></i></label>
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
          
        </div>

        <div class="tables">
          <div class="event-categories">
            <div class="heading">
              <h2>All Categories</h2>
                <a id="modalBtn" class="btn">Add</a>
                
                <div id="simpleModal" class="modal">
                  <div class="modal-content">
                    <h2 class="add-category-h2">Add Category</h2>
                    <div class="close">
                      <span id="closeBtn">&times;</span>
                    </div>    
                    <div class="form-content">
                      <form action="add-category.php" method="post">
                        <label for="category">Category</label>
                        <input id="category" type="text" name="category" placheholder="Enter category name" required>
                        <input type="submit" value="Submit">  
                      </form>
                    </div>
                  </div>
                </div>

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
                          <a id="modalUpdateBtn" onclick="openUpdateModal('<?php echo $row['category_id'];?>',
                              '<?php echo $row['name'];?>')">
                            <i class="far fa-edit"></i>
                          </a>
                          <a href="delete-category.php?id=<?php echo $row['category_id']; ?>">
                            <i class="far fa-trash-alt"></i>
                          </a>
                          <input type="hidden" name="target_id" value="<?php echo $_GET['id']; ?>">
                        </td>
                        
                      </tr>
                    <?php
                  }
                }
              ?>
              </tbody>
            </table>

            <div id="updateModal" class="modal">
                  <div class="modal-content">
                    <h2 class="add-category-h2">Update Category</h2>
                    <div class="close">
                      <span id="closeUpdateBtn">&times;</span>
                    </div>    
                    <div class="form-content">
                      <form action="edit-category.php" method="post">
                        <label for="category">Category</label>
                        
                        <input id="categoryUpdate" type="text" name="category_name">
                        <input id="categoryUpdateSubmit" type="submit" value="Submit">  

                        <input type="hidden" name="category_id" id="categoryIdHidden">
                      </form>
                    </div>
                  </div>
                </div>
          </div>
          
        </div>
      </div>

    </div>
  </body>

  <script type="text/javascript" src="../js/main.js"></script>
    
</html>