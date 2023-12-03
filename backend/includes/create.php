<!-- Header -->
<?php  include "header.php" ?>
 
<?php 
  if(isset($_POST['create'])) 
    {
      $image = $_FILES['image_upload'];
      $image_name = $_FILES['image_upload']['name'];
      $imageTmpName = $_FILES['image_upload']['tmp_name'];
      $imageSize = $_FILES['image_upload']['size'];
      $imageError = $_FILES['image_upload']['error'];
      $imageType = $_FILES['image_upload']['type'];
        $tile= $_POST['title'];
        $content = $_POST['content'];
        $imageExt = explode('.', $image_name);
        $imageName_convertor = strtolower(end($imageExt));
        $allowed  = array('jpg', 'jpeg', 'png');
        if(in_array($imageName_convertor,$allowed)){
          if($imageError === 0){
            if($imageSize < 500000){
                $image_new_name =  uniqid('', true).".".$imageName_convertor;
                $fileDestination = '../backend/images/'.$image_new_name;
                move_uploaded_file($imageTmpName, $fileDestination);  
                  // SQL query to insert user data into the users table
                  $query= "INSERT INTO post(title, content, images) VALUES('{$tile}','{$content}','{$image_new_name}')";
                  $add_posts = mysqli_query($conn,$query);
                  // displaying proper message for the user to see whether the query executed perfectly or not 
                      if (!$add_posts) {
                        echo "something went wrong ". mysqli_error($conn);
                      } else { 
                          echo "<script type='text/javascript'>alert('Post successfully!')</script>";
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
 
<h1 class="text-center">Add post</h1>
  <div class="img_pop">
  </div>
  <div class="container shadow-sm">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title" class="form-label">Tile</label>
        <input type="text" name="title"  class="form-control">
      </div>
 
      <div class="form-group">
        <label for="content" class="form-label">Content</label>
        <input type="text" name="content"  class="form-control">
      </div>
      <div class="form-group">
        <label  class="form-label">Picture</label>
        <input type="file"
       class="form-control" name="image_upload">
      </div> 
      <div class="form-group">
        <input type="submit"  name="create" class="btn btn-primary mt-2" value="submit">
      </div>
    </form> 
  </div>

 