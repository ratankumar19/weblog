<?php
  $session_role2=$_SESSION['role'];
    $session_username2=$_SESSION['username'];//username show krwane ke liye

  ?>




 <nav class="navbar navbar-expand-lg navbar-light bg-light navbar fixed-top ">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand  " href="#">Admin Panel</a>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item">
           Welcome<a class="nav-link fa fa-user" href="#"><?php echo ucfirst($session_username2);?></a>
        </li>

         <li class="nav-item">
          <a class="nav-link fa fa-plus-square" href="add-post.php"> Add Post</a>
        </li>


        <?php
           if($session_role2=='admin'){      
//only admin can access this Author nii krr skta

?>
        <li class="nav-item">
          <a class="nav-link fa fa-user-plus" href="add-user.php"> Add User</a>
        </li>
      <?php }?>


        <li class="nav-item">
          <a class="nav-link fa fa-user" href="profile.php"> Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fa fa-power-off" href="logout.php"> Logout</a>
        </li>
       
      
    </ul>
    
  </div>
</nav>