<?php require_once('inc/top.php');
session_start();
if(!isset($_SESSION['username'])){
 header("Location:login.php");
}
elseif (isset($_SESSION['username']) && $_SESSION['role']=='author'){
  //author as a user come here ,then it will directly send to index page
  header("Location:index.php");
}
//delete query
if(isset($_GET['del'])){
$del_id=$_GET['del'];
$del_check_query="SELECT * FROM users WHERE id =$del_id";
$del_check_run=mysqli_query($con,$del_check_query);
if(mysqli_num_rows($del_check_run)> 0){     
$del_query="DELETE FROM `users` WHERE `users`.`id` = $del_id";
if (isset($_SESSION['username']) && $_SESSION['role']=='admin'){
if(mysqli_query($con,$del_query)){
  $msg="Users has been Deleted";
}
else{
  $error="Users has not been Deleted";
  }
 }
}
else{
 header("Location:index.php");
}
}
//for converting admin to author and vice versa
if(isset($_POST['checkboxes'])){
  
  
  foreach($_POST['checkboxes'] as $user_id){
   //echo $bulk_option=$_POST['bulk-options'];
   $bulk_option=$_POST['bulk-options'];

   if($bulk_option=='delete'){
    $bulk_del_query="DELETE FROM `users` WHERE `users`.`id` =$user_id";
    mysqli_query($con,$bulk_del_query);
   }
   else if ($bulk_option=='author'){
    $bulk_author_query="UPDATE `users` SET `role` = 'author' WHERE `users`.`id` = $user_id";
    mysqli_query($con,$bulk_author_query);
  }
   else if ($bulk_option=='admin'){
    $bulk_admin_query="UPDATE `users` SET `role` = 'admin' WHERE `users`.`id` = $user_id";
    mysqli_query($con,$bulk_admin_query);
  }
}
}
?>
<body>
   <div id="wrapper">
         <?php require_once('inc/header.php');?>
              <div class="container-fluid body">
                  <div class="row">
                      <?php require_once('inc/sidebar.php');?>
                           <div class="col-md-9">
                                <h1>
                                   <i class="fa fa-user" aria-hidden="true"></i><strong> Users</strong>
                                </h1>
                                <ol class="breadcrumb">
                                    <li><a href="">View All Users</li>
                                  
                                    </a>
                                </ol>
                              <?php
                            $query="SELECT * FROM users order by id DESC";
                            //latest ke liye DESC means choose highest id first so that (id1>id2) for DESC
                            $run=mysqli_query($con,$query);
                            if(mysqli_num_rows($run)> 0)
                            {     
                              ?>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select name="bulk-options" id="selectallboxes" class="form-control">
                                                          <option value="delete">Delete</option>
                                                          <option value="author">Change to author</option>
                                                          <option value="admin">Change to admin</option>
                                                          </select>
                                                </div>
                                            </div>
                                        <div class="col-8">
                                            <input type="submit" class="btn btn-success " value="Apply">
                                           
                                               <a href="add-user.php" class="btn btn-primary float-right">Add new</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        if(isset($error)){
                          echo "<span style='color:red;' class='pull-right'>$error</span>";
                        }
                        else if(isset($msg)){
                         echo "<span style='color:green;' class='pull-right'>$msg</span>";
                        }
                      ?>
                  <table class="table table-hover table-bordered striped">
                      <thead>
                          <tr>
                              <th> <input type="checkbox" id="select_all"></th>
                              <th>Sr.</th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Username</th>
                              <th>Email</th>
                              <th>Image</th>
                              <th>Password</th>
                              <th>Role</th>
                              <th>Edit</th>
                              <th>Del</th>
                          </tr>
                      </thead>
                    <tbody>
                  <?php
                  //feteching all data from db and display in table
                    while($row=mysqli_fetch_array($run)){
                      $id=$row['id'];
                      $first_name=ucfirst($row['first_name']);
                      $last_name=ucfirst($row['last_name']);
                      $email=$row['email'];
                      $username=$row['username'];
                      $role=$row['role'];
                      $image=$row['image'];
                      $date=getdate(strtotime($row['date']));
                    // $date=getdate($row['date']);
                      $day=$date['mday'];
                      $month=substr($date['month'],0,3);
                      $year=$date['year'];
                     ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id;?>">
                        </td>
                        <td><?php echo $id;?></td>
                        <td><?php echo "$day $month $year";?></td>
                        <td><?php echo "$first_name  $last_name";?></td>
                        <td><?php echo $username;?></td>
                        <td><?php echo $email;?></td>
                        <td>
                            <img src="img/<?php echo $image;?> "width="30px" alt="Post Image">
                        </td>
                        <td>*********</td>
                        <td><?php echo ucfirst($role);?></td>
                        <td><a href="edit-user.php?edit=<?php echo $id;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                        <td><a href="users.php?del=<?php echo $id;?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              <?php
                }
                else{
                  echo "<center><h2>No Users Availbale</h2></center>";
                }
              ?>
            </form>
          </div>
        </div>
    </div>
<?php require_once('inc/footer.php');?>


