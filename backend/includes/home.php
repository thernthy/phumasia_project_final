<!-- Header -->
<?php 
include "header.php"; ?>
        <table class="table table-striped table-bordered table-hover">
          <thead class="shadow-sm bg-body-tertiary rounded">
            <tr>
              <th  scope="col">Id</th>
              <th  scope="col">Tile</th>
              <th  scope="col">Post date</th>
              <th  scope="col">Content</th>
              <th  scope="col">images Name</th>
              <th  scope="col" colspan="3" class="text-center">CRUD Operations</th>
            </tr>  
          </thead>
            <tbody>
              <tr>
  
          <?php
            $query="SELECT * FROM post";               // SQL query to fetch all table data
            $view_users= mysqli_query($conn,$query);    // sending the query to the database
 
            //  displaying all the data retrieved from the database using while loop
            while($row= mysqli_fetch_assoc($view_users)){
              $id = $row['id'];                
              $title= $row['title'];        
              $datepost= $row['date'];        
              $content = $row['content'];         
              $images = $row['images'];      
 
              echo "<tr >";
              echo " <th scope='row' >{$id}</th>";
              echo " <td >{$title}</td>";
              echo " <td >" . date('F/d/Y', strtotime($datepost)) ."</td>";
              echo " <td >{$content} </td>";
              echo " <td ><img src='/backend/images/{$images}' width='250px' height='200px'></td>";
              echo " <td class='text-center' > <a href='includes/update.php?edit&post_id={$id}' class='btn btn-secondary'><i class='bi bi-pencil'></i> EDIT</a> </td>";
 
              echo " <td  class='text-center'>  <a href='includes/delete.php?delete={$id}' class='btn btn-danger'> <i class='bi bi-trash'></i> DELETE</a> </td>";
              echo " </tr> ";
                  }  
                ?>
              </tr>  
            </tbody>
        </table>
  </div>
 
