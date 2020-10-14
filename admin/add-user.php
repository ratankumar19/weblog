<?php require_once('inc/top.php');
session_start();
if(!isset($_SESSION['username'])){
 header("Location:login.php");
}
elseif (isset($_SESSION['username']) && $_SESSION['role']=='author'){
  //user who is author if come anyhow on this page then it will directly go index page 
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
                <i class="fa fa-user-plus animate__animated animate__backInRight" aria-hidden="true"></i> 
                  <strong>Add Users</strong>
              </h1>
              <ol class="breadcrumb">
                <li>
                  <a href="">
                    Add New User
                  </a>
                </li>
              </ol>
            <?php
            if(isset($_POST['submit'])){
              //if submit button is clicked
              $first_name=mysqli_real_escape_string($con,$_POST['first_name']);
               //mysqli_real_escape_string helps to  Escapes special characters in a string 
              $last_name=mysqli_real_escape_string($con,$_POST['last_name']); 
              $username=mysqli_real_escape_string($con,strtolower($_POST['username'])); 
              $username_trim=preg_replace('/\s+/','',$username);//trim the sapce between the username
              $email=mysqli_real_escape_string($con,strtolower($_POST['email']));
              //if email has uppercase letter then converts into lower
              $password=mysqli_real_escape_string($con,$_POST['password']);
              $role=$_POST['role'];
              $image=$_FILES['image']['name'];
              $image_tmp=$_FILES['image']['tmp_name'];

              //try
              /*$salt_query="SELECT * from users order by id desc limit 1";
              $salt_run=mysqli_query($con,$salt_query);
              $salt_row=mysqli_fetch_array($salt_run);
              $salt=$salt_row['salt'];
              $password=crypt($password,$salt);
              */


              /*if(empty($image)){
              $image=$e_image;
              }*/
              $check_query="select * from users where username='$username' or email='$email'";
              //check email or username is already exist or not
              $check_run=mysqli_query($con,$check_query); 

              $salt_query="SELECT * from users order by id desc limit 1";//choose latest one for crypting the pass
              $salt_run=mysqli_query($con,$salt_query);
              $salt_row=mysqli_fetch_array($salt_run);
              $salt=$salt_row['salt'];
              //echo $password;
              $password=crypt($password,$salt);
              
              if(empty($first_name) or empty($last_name) or empty($username) or empty($email) or empty($password) or empty($image)){
               $error="All(*) fields are required";
              }
              else if($username !=$username_trim){
              $error="Don't use Spaces in username"; 
              }
              else if(mysqli_num_rows($check_run)> 0){
                $error="Username or Email already exist";
              }
            else{
            $insert_query="INSERT INTO `users`(`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`) VALUES (null,CURRENT_TIMESTAMP,'$first_name','$last_name','$username','$email','$image',
            '$password','$role')";
            $insert_run=mysqli_query($con,$insert_query);
            if($insert_run){
              $msg="User has been added";
              move_uploaded_file($image_tmp, "img/$image");
              //basic synatx move_uploaded_file ( string $filename , string $destination ) is bool type
              //if the file is valid, it will be moved to the filename given by destination.
              //Returns TRUE on success.
              //If filename is not a valid upload file, then no action will occur, and move_uploaded_file() will return FALSE.
              //If filename is a valid upload file, but cannot be moved for some reason, no action will occur, and move_uploaded_file() will return FALSE. Additionally, a warning will be issued.

              $image_check="SELECT * FROM  users ORDER BY id DESC LIMIT 1";//1st latest to display the profile image of user
              $image_run=mysqli_query($con,$image_check);
              $image_row=mysqli_fetch_array($image_run);
              $check_image=$image_row['image'];
              //after successfull adding we have to empty the entries
              $first_name="";
              $last_name="";
              $username="";
              $email="";
              }
              else{
              
              $error="Users has not been added";
              }
            }
          }
        ?>
        <div class="row">
            <div class="col-md-8">
                <form action=""method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="first_name">First_Name*:</label>
                     <?php 
                      if(isset($error)){
                        echo "<span class='pull-right' style='color:red;'>$error</span>";
                      }
                      else if(isset($msg))
                      {
                      echo "<span class='pull-right' style='color:green;'>$msg</span>";
                      }
                      ?>
                      <input type="text" class="form-control" id="first_name" name="first_name" 
                        value="<?php if(isset($first_name)){echo $first_name;}
                          //lets suppose ,i clicked submit button without completing mandatory fields but jo data bhr diya hua hai wo hmko reatin krna hai 
                        ?>" 
                        placeholder="First_Name">
                      </div>
                      <div class="form-group">
                          <label for="last_name">Last_Name*:</label>
                          <input type="text" class="form-control" id="last_name" name="last_name"
                          value="<?php if(isset($last_name)){echo $last_name;}?>"
                          placeholder="Last_Name">
                      </div>
                    <div class="form-group">
                      <label for="username">Username*:</label>
                      <input type="text" class="form-control" id="username" name="username"
                      value="<?php if(isset($username)){echo $username;}?>"
                      placeholder="Username">
                    </div>
                    <div class="form-group">
                      <label for="email">Email*:</label>
                      <input type="email" class="form-control" id="email" name="email"
                      value="<?php if(isset($email)){echo $email;}?>"
                      placeholder="Email Address">
                    </div>
                    <div class="form-group">
                      <label for="Password">Password*:</label>
                      <input type="password" class="form-control" id="password" name="password"placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="role">Role*:</label>
                          <select name="role" id="role" class="form-control" name="role">
                              <option value="author">Author</option>
                              <option value="admin">Admin</option>
                          </select>
                    </div>
                   <div class="form-group">
                      <label for="image">Profile Picture*</label>
                      <input type="file"  name="image" id="image" >
                    </div>
                        <input type="submit" name="submit" value="Add user" class="btn btn-primary">
                      </form>
                  </div>
                <div class="col-md-4">
                    <?php
                    //submitted image of user will be display 
                    if(isset($check_image)){
                      echo "<img src ='img/$check_image' width ='100%'>";
                    }
                    ?>
                </div>
              </div>
           </div>
        </div>
    </div>
<?php require_once('inc/footer.php');?>


