<!-- Header -->
<?php include "../header.php"?>

<?php
   // checking if the variable is set or not and if set adding the set data value to variable postId
   if(isset($_GET['post_id'])) {
      $postId = $_GET['post_id']; 
   }
   // SQL query to select all the data from the table where id = $postId
   $query = "SELECT * FROM post WHERE id = $postId ";
   $view_users = mysqli_query($conn, $query);
   while($row = mysqli_fetch_assoc($view_users)) {
      $id = $row['id'];
      $title = $row['title'];
      $contents = $row['content'];
      $images = $row['images'];
   }
   //Processing form data when form is submitted
   if(isset($_POST['update'])) {

      $image = $_FILES['image_upload'];
      $image_name = $_FILES['image_upload']['name'];
      $imageTmpName = $_FILES['image_upload']['tmp_name'];
      $imageSize = $_FILES['image_upload']['size'];
      $imageError = $_FILES['image_upload']['error'];
      $imageType = $_FILES['image_upload']['type'];
      $title = $_POST['title'];
      $content = $_POST['content'];
      $imageExt = explode('.', $image_name);
      $imageName_convertor = strtolower(end($imageExt));

      $allowed  = array('jpg', 'jpeg', 'png');
      if(in_array($imageName_convertor,$allowed)){
        if($imageError === 0){
          if($imageSize < 500000){
              $image_new_name =  uniqid('', true).".".$imageName_convertor;
              $fileDestination = 'asset/images/'.$image_new_name;
              move_uploaded_file($imageTmpName, $fileDestination);  
                // SQL query to insert user data into the users table
                  $query = "UPDATE post SET title = '{$title}', content = '{$content}', images = '{$images}' WHERE id = $postId";
                  $update_user = mysqli_query($conn, $query);
                    if (!$update_user) {
                      echo "something went wrong ". mysqli_error($conn);
                    } else { 
                      echo "<script type='text/javascript'>alert('Post .{$id}. updated successfully!'); window.location.href = 'home.php';</script>";
                    }
          }else{
            echo "Your image is too big!";
          }
        }else{
          echo "there was an error on your file!";
        }
      }else{
        echo "You can't upload this file!";
      }
   }             
?>

<h1 class="text-center">Update post</h1>
<div class="container">
   <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
         <label for="title">Username</label>
         <input type="text" name="title" class="form-control" value="<?php echo $title ?>">
      </div>

      <div class="form-group">
         <label for="email">Contents</label>
         <textarea type="text" name="content" class="form-control"><?php echo $contents ?></textarea>
      </div>

      <div class="form-group" style="width: 200px; height: 200px;">
         <label for="pass">Images</label>
         <div class="form-control"><img src="./asset/images/<?php echo $images; ?>" alt="" width="100%" height="100%"></div>
      </div>  

      <div class="form-group">
         <label for="pass">New Images</label>
         <input type="file" name="image_upload" class="form-control" value="<?php echo $images; ?>">
      </div>  
      
      <div class="form-group">
         <input type="submit" name="update" class="btn btn-primary mt-2" value="Update">
      </div>
   </form>    
</div>
<div class="container text-center  mb-3">
   <a href="..\index.php" class="btn btn-warning mt-2">Back</a>
</div>
<!-- a BACK button to go to the home page -->

