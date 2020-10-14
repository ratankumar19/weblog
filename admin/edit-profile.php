<?php require_once('inc/top.php');
session_start();
if(!isset($_SESSION['username'])){
 header("Location:login.php");}
//new page me jo data edit krne ke badd wala hai ...
$session_username=$_SESSION['username'];
//edit button from profile page is clicked 
if(isset($_GET['edit'])){
// The isset() function checks whether a variable is set, which means that it has to be declared and is not NULL.
$edit_id=$_GET['edit'];//extract that edit id 
$edit_query="SELECT * FROM users WHERE id = $edit_id";//select that user whose id =edit id
$edit_query_run=mysqli_query($con,$edit_query);
if(mysqli_num_rows($edit_query_run) >0){//agrr aisa koi row exist kre to

  $edit_row=mysqli_fetch_array($edit_query_run);
  //fetech the array Returns an array that corresponds to the fetched row and moves the internal data pointer ahead.
  $e_username=$edit_row['username'];//extract the username from db

  if($e_username==$session_username){//if username from db equal  to session username
  $e_first_name=$edit_row['first_name'];//data comes from prifle page
  $e_last_name=$edit_row['last_name'];
  $e_role=$edit_row['role'];
  $e_image=$edit_row['image'];
  $e_details=$edit_row['details'];

}
else{
 header("Location:index.php"); 
}

}
else{
header("Location:index.php");
}
}
else{
header("Location:index.php");
}
?>
</head>
  <body>
     <div id="wrapper">
        <?php require_once('inc/header.php');?>
            <div class="container-fluid body">
                <div class="row">
                    <?php require_once('inc/sidebar.php');?>
                       <div class="col-md-9">
                          <h1>
                              <i class="fa fa-user" aria-hidden="true"></i> 
                              <strong>Edit Profile</strong> 
                          </h1>
                          <ol class="breadcrumb">
                              <li><a href=""><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li>
                            </ol>
                          <?php

                          //if edit button is clicked
                         if(isset($_POST['submit'])){
                                                  $first_name=mysqli_real_escape_string($con,$_POST['first_name']);
                          //mysqli_real_escape_string helps to  Escapes special characters in a string for use in an SQL statement, 
                          //if i want to add some special char in first name then i have to use this concept
                          $last_name=mysqli_real_escape_string($con,$_POST['last_name']); 
                          $password=mysqli_real_escape_string($con,$_POST['password']);
                          $role=$_POST['role'];
                          $image=$_FILES['image']['name'];
                          $image_tmp=$_FILES['image']['tmp_name'];
                          $details=mysqli_real_escape_string($con,$_POST['details']);
                          if(empty($image)){
                          $image=$e_image;//if image is not changed then ,image from profile page is considered
                         }
                          $salt_query="SELECT * from users order by id desc limit 1";//choose 1 user from db
                          $salt_run=mysqli_query($con,$salt_query);
                          $salt_row=mysqli_fetch_array($salt_run);
                          $salt=$salt_row['salt'];

                          //Salt is a two-character string (the 12 bits of the Salt is used to perturb the DES algorithm) chosen from the character set "A-Z", "a-z","0-9","."(period) and "/". Salt is used to vary the hashing algorithm,

                          $insert_password=crypt($password,$salt);
                          //The salt parameter is optional. However, crypt() creates a weak hash without the salt
                          if(empty($first_name) or empty($last_name) or empty($image)){//cehck all fields are mandatory
                          $error="All(*) fields are required";
                          }
                          else{//(. used for concatenation)
                           // print($con->error);
                          $update_query="UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `image` = '$image', `role` = '$role', `details` = '$details'";
                          if(isset($password)){//if passwrd me kuch update kiya hu to hi ye query chlega 
                          $update_query .=",`password`='$insert_password'";
                          }
                          $update_query .=" WHERE `users`.`id` = $edit_id";
                          if(mysqli_query($con,$update_query)){//if update query has succefully done
                            $msg="users has been updated";
                            //for refreshing page ,itna time ke badd page refresh hoke new data ke sth update ho jayega at  the same page(becz url me same page ka address diya hua hai)
                            header("refresh:1;url=edit-profile.php?edit=$edit_id");
                         }
                         else{
                           $error="users has not  been updated"; 
                          }
                         }
                       }
                   ?>
  <div class="row">
      <div class="col-md-8">
         <form action=""method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="first_name">First_Name*:</label>
                <?php //msg printing
                if(isset($error)){
                  echo "<span class='pull-right' style='color:red;'>$error</span>";
                }
                else if(isset($msg))
                {
                echo "<span class='pull-right' style='color:green;'>$msg</span>";
                }
                ?>
                  <input type="text" class="form-control" id="first_name" name="first_name" 
                  value="<?php echo $e_first_name;
                    //printing the name that comes from profile page 
                  ?>" 
                  placeholder="first_Name">
            </div>
                <div class="form-group">
                  <label for="last_name">Last_Name*:</label>
                  <input type="text" class="form-control" id="last_name" name="last_name"
                  value="<?php echo $e_last_name;?>"
                  placeholder="$e_last_Name">
                </div>
              <div class="form-group">
                <label for="Password">Password*:</label>
                <input type="password" class="form-control" id="password" name="password"placeholder="Password">
              </div>
              <div class="form-group">
                <label for="image">Profile Picture*</label>
                <input type="file"  name="image" id="image" >
              </div>
              <div class="form-group">
                <label for="details">Details:*</label>
                  <textarea name="details" id="details" cols="30" rows="10" class="form-control">
                    <?php echo $e_details;?>
                  </textarea>
              </div>
                <input type="submit" name="submit" value="Edit" class="btn btn-primary">
            </form>
          </div>
        <div class="col-md-4">
      <?php
        echo "<img src ='img/$e_image' width ='100%'>";
        ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once('inc/footer.php');?>


