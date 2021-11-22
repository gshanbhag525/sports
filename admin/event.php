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
    <link rel="stylesheet" href="../css/events.css">
    
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
          
          <div class="events">
            <div class="heading">
              <h2>All Events</h2>
              <a id="modalEventBtn" class="btn">Add</a>

              <div id="addEventModal" class="modal">
                  <div class="modal-content">
                    <h2 class="add-category-h2">Add Event</h2>
                    <div class="close">
                      <span id="closeEventBtn">&times;</span>
                    </div>    
                    <div class="form-content">
                      <form action="add-event.php" method="post" enctype="multipart/form-data">
                        <label for="event">Event name</label>
                        <input type="text" name="event" id="event" required>

                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" cols="100" required></textarea>
                        
                        <label for="categoryname">Category</label>
                        <select name="categoryname" id="categoryname">
                          <option value="">--- Choose a Category ---</option>
                          <?php
                          $sql = "SELECT * FROM categories";
                          $result = $conn->query($sql);
                          if($result->num_rows > 0) {
                            $i = 0;
                            while($row = $result->fetch_assoc()) {
                              ?>  
                              <option value="<?php echo $row['category_id']; ?>"><?php echo $row['name']; ?></option>
                              <?php
                            }
                          }
                        ?>
                        </select>
                        
                        <label for="date">Date</label>
                        <input name="date" type="date" id="eventdate" min="2021-01-01" max="2050-01-31" required>
                        <!-- <label for="date" id="eventdateerror" style="display: none;">Invalid date </label> -->
                        
                        <label for="image">Select Image File:</label><br>
                        <input type="file" name="image" type="file" required><br>

                        <label for="enableevent">Enable/Disable Event</label>
                        <input type="checkbox" name="enableevent" value="" required><br>
                        
                        <label for="featuredevent">Featured Event</label>
                        <input type="checkbox" name="featuredevent" value="" required>
                        
                        <input type="submit" value="Submit">  
                      </form>
                    </div>
                  </div>
                </div>

            </div>
            <table class="events-data">
              <thead>
                <td>Sno</td>
                <td>Name</td>
                <td>Description</td>
                <td>Date</td>
                <td>Image</td>
                <td>Event State</td>
                <td>Featured</td>
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
                        <td>
                          <?php
                            $dtime = new DateTime($row['e_date']);
                            // print $dtime->format("jS F Y");
                            print $dtime->format("j/m/Y"); ?>
                        </td>

                        <td>
                          <?php 
                            echo '<img src="data:image/jpg;base64,'.base64_encode($row['e_image'] ).'" height="100" width="100" />';
                          ?>  
                        </td>

                        <td><?php if($row['e_isEnabled'] == 1) echo "Enabled"; else echo "Disabled"; ?></td>

                        <td><?php if($row['e_Featured'] == 1) echo "Yes"; else echo "No"; ?></td>

                        <td>
                          <!-- <i class="far fa-eye"></i> -->
                          
                          <a id="modalUpdateBtn" onclick="openUpdateModal('<?php echo $row['category_id'];?>',
                              '<?php echo $row['name'];?>')">
                            <i class="far fa-edit" title="Edit"></i>
                          </a>
                          
                          <a href="delete-event.php?id=<?php echo $row['event_id']; ?>">
                            <i class="far fa-trash-alt" title="Delete"></i>
                          </a>
                        </td>
                        
                      </tr>
                    <?php
                  }
                }
              ?>
              </tbody>
            </table>

                <!-- <div id="updateModal" class="modal">
                  <div class="modal-content">
                    <h2 class="add-category-h2">Update Event</h2>
                    <div class="close">
                      <span id="closeUpdateBtn">&times;</span>
                    </div>    
                    <div class="form-content">
                      <form action="edit-event.php" method="post">
                        <label for="category">Category</label>
                        
                        <input type="text" name="category_name" id="categoryUpdate">
                        <input type="submit" value="Submit">  

                        <input type="hidden" name="category_id" id="categoryIdHidden">
                      </form>
                    </div>
                  </div>
                </div> -->


          </div>
        </div>
      </div>

    </div>

    <script type="text/javascript" src="../js/event.js"></script>
    

  </body>
</html>