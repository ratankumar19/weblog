  <?php
  $session_role1=$_SESSION['role'];
  $get_comment="SELECT * FROM comments WHERE status ='pending'";
  $get_comment_run=mysqli_query($con,$get_comment);
  $num_of_rows=mysqli_num_rows($get_comment_run);

  ?>




      <div class="col-md-3">
            <div class="list-group">
                  <a href="index.php" class="list-group-item list-group-item-action active">
                    <i class="fa fa-tachometer"></i> Dashboard
                  </a>

                  <a href="posts.php" class="list-group-item list-group-item-action">
                
                  <i class="fa fa-file-text"></i> All Post 
                  </a>


                  <a href="media.php" class="list-group-item list-group-item-action">
                
                  <i class="fa fa-database"></i> Media 
                  </a>
<?php
           if($session_role1=='admin'){      
//only admin can access this Author nii krr skta

?>
     
              <a href="comments.php" class="list-group-item list-group-item-action">
       
                <i class="fa fa-comment"></i> Comments  
              
                <?php
                  if($num_of_rows >0){
                    echo " <span class='badge badge-light float-right'>$num_of_rows</span>";
                  }

                ?>


              </a>
               <a href="categories.php" class="list-group-item list-group-item-action">
        

               <i class="fa fa-folder-open"></i> Categories 


              </a>


              <a href="users.php" class="list-group-item list-group-item-action ">
        
       

                <i class="fa fa-users"></i> Users 


               </a>
               <?php 
                }

               ?>


      </div>

    </div>