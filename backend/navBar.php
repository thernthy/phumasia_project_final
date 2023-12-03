
<style>
  .asking {
    padding: 20px 15px;
    border-radius: 10px;
    top: 4rem;
    position: fixed;
    background-color: white;
    /* ...existing styles... */
    right: -1000px;/* Initially hide the menu div */
    transition: right 0.3s ease; /* Add transition for smooth sliding */
  }
  .asking a{
    text-decoration: none;
    padding: 10px 0;

  }

  .asking.show {
    right: 3rem;/* Show the menu div by setting right to 0 */
  }
  .menu-bar-content {
    top: 0;
    position: fixed;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    background-color: white;
  }

  .menu-bar-content li {
    list-style: none;
  }

  .dropdown {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  .dropdown .dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    background-color: #fff;
    padding: 10px;
    border-radius: 4px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  }
  .dropdown .dropdown-content a{
    text-decoration: none;
  }
  #notification{
    margin-right: 200px;
  }
  #Usermenu{
    margin-left: 200px;
  }
  #count{
    position: relative;
    border-radius: 50%;
    top: -15px;
    left: 0;
    font-size: .6rem;
  }
  .aking{
    position: fixed;
    z-index: 20;
    top: 5px;
    right: 3rem;
    font-size: 1.4rem;
    margin-right: 20px;
    color: white;
  }
</style>
<div class="menu-bar-content shadow-sm bg-body-tertiary">
      <?php
      $query = "SELECT * FROM users WHERE id "; // SQL query to fetch all table data
      $view_users = mysqli_query($conn, $query); // sending the query to the database
      //  displaying all the data retrieved from the database using while loop
      while ($row = mysqli_fetch_assoc($view_users)) {
        $userName = $row['username'];
        $userEmail = $row['email'];
      }
      ?>
      <li class="dropdown">
      <strong><?php echo "{$userName}"; ?></strong>
        <a href="#"><i class="bi bi-caret-down-fill"></i></a>
        <div class="dropdown-content" id="Usermenu">
        <a href="?Admin=home" class='btn btn-outline-dark mb-2'  style="font-size:.5rem;"><i class="bi bi-plus-lg"></i>Home</a>
        <a href="?Admin=activitypost" class='btn btn-outline-dark mb-2' style="font-size: .5rem;"> <i class="bi bi-add"></i>A-post</a>  
        <a href="?Admin=productpost" class='btn btn-outline-dark mb-2' style="font-size: .5rem;"> <i class="bi bi-add"></i>P-post</a>  
          <form method='post' action="">
                  <input type="submit" class="btn btn-danger mt-2" value="Logout" name="but_logout" style="font-size: .5rem;">
          </form>
        </div>
      </li>
      <li><h5 class="text-center">Phumasia Admin Dashboard</h5></li>
        <li class="dropdown notification">
          <a href="#">
            <?php 
              $countMessage = 0;
              $query = "SELECT * FROM message WHERE status= 0";
              $view_users = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($view_users)){
                  $messageEmail = $row['email'];
                  $countMessage++;
                }
            ?>
            <i class="bi bi-envelope-fill" style="font-size: 1.5rem; color:<?php if($countMessage === 0){
                  echo"green";
              }else{
                  echo"red";
              }
             ?>;"></i><span class="badge badge-danger" style=" background-color:
              <?php if($countMessage === 0){
                  echo"green";
              }else{
                  echo"red";
              }
             ?>;" id="count"><?php echo "{$countMessage}" ?></span>  
          </a>
        <div class="dropdown-content" id="notification">
         <?php 
              $query = "SELECT * FROM message WHERE status= 0";
              $view_users = mysqli_query($conn, $query);
              while($row = mysqli_fetch_assoc($view_users)){
                    $id = $row['id'];
                    $messageEmail = $row['email'];
                    echo "<a href='message/viwemessage.php?viewmessage={$id}'>{$messageEmail}</a> <br/>";
                    $countMessage++;
              }
              if($countMessage === 0){
                echo"<p class='alert alert-danger' role='alert'>
                 There is no message!
                </p>";
                echo"<a href='?Admin=oldmessages' style>Old message</a>";
              }
          ?>
        </div>
      </li>
      <span class="aking">
        <?php 
          $checkAskingMessag = 0;
          $query = "SELECT * FROM asking WHERE action= 0";
          $viwe_asking = mysqli_query($conn, $query);
          while($row = mysqli_fetch_assoc($viwe_asking)){
            $checkAskingMessag++;
          }
        ?>
        <?php echo "<sub style='color:red; font-size: 15px;'>{$checkAskingMessag}</sub>"; ?>
        <i class="bi bi-question-circle-fill" style="color:
        <?php if($checkAskingMessag === 0 ){echo"green";}else{echo"red";}?>"
        >
        </i></span>
    </div>
    <div class="asking shadow-sm bg-body-tertiary">
    <?php 
              $query = "SELECT * FROM asking WHERE action = 0";
              $view_users = mysqli_query($conn, $query);
              while($row = mysqli_fetch_assoc($view_users)){
                    $id = $row['id'];
                    $senderName  = $row['sender_name'];
                    echo "<a href='message/viewquestion.php?viewquestion={$id}'>{$senderName}</a> <br/>";
                    $countMessage++;
              }
              if($countMessage === 0){
                echo"<p class='alert alert-danger' role='alert'>
                 There is no message!
                </p>";
                echo"<a href='?Admin=oldmessages' style>Old message</a>";
              }
          ?>
    </div>
<script>
  document.addEventListener('click', function (event) {
    var isClickInsideDropdown = event.target.closest('.dropdown');
    var dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function (dropdown) {
      if (dropdown !== isClickInsideDropdown) {
        dropdown.querySelector('.dropdown-content').style.display = 'none';
      }
    });
  });

  var dropdownTriggers = document.querySelectorAll('.dropdown > a');
  dropdownTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', function (event) {
      event.stopPropagation();
      var dropdownContent = this.parentNode.querySelector('.dropdown-content');
      dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
    });
  });

  var dropdownTriggers = document.querySelectorAll('.aking > a');
  dropdownTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', function (event) {
      event.stopPropagation();
      var dropdownContent = this.parentNode.querySelector('.aking');
      dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
    });
  });
  var aking = document.querySelector('.aking');
  aking.addEventListener('click', function() {
    var menuBarContent = document.querySelector('.asking');
    menuBarContent.classList.toggle('show');
  });
</script>
