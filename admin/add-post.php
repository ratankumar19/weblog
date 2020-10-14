<?php require_once('inc/top.php');
//session start
session_start();
//session check
if(!isset($_SESSION['username'])){
 header("Location:login.php");
}
$session_username=$_SESSION['username'];//set the session in username
$session_author_image=$_SESSION['author_image'];//set the session in author_image
//echo $session_author_image;
?>
</head>
  <body>
    <div id="wrapper">
        <?php require_once('inc/header.php');?>
              <div class="container-fluid body">
                  <div class="row">
                      <?php require_once('inc/sidebar.php')?>
                            <div class="col-md-9">
                                  <h1><i class="fa fa-plus-square animate__animated animate__backInRight"></i><strong> Add Post </strong></h1> <hr>
                                        <ol class="breadcrumb">
                                              <li><a href="">Add New Post </a></li>
                                              
                                        </ol>
                                        <?php 
                                        //if add post button is clicked 
                                        if(isset($_POST['submit'])){
                                          //extract all data from corresponding  entries
                                        $title=mysqli_real_escape_string($con,$_POST['title']);
                                        //mysqli_real_escape_string helps to  Escapes special characters in a string 
                                        $post_data=mysqli_real_escape_string($con,$_POST['post-data']);
                                        $categories=$_POST['categories'];
                                        $tags=$_POST['tags'];
                                        $status=$_POST['status'];
                                        $image=$_FILES['image']['name'];
                                        $tmp_name=$_FILES['image']['tmp_name'];
                                       if(empty($title) or empty($post_data) or empty($tags) or empty($image)){
                                         $error="All (*) fields are required";
                                        }
                                        else{
                                          //username and author image will come from session var
                                        $insert_query="INSERT INTO `posts` (`id`, `date`, `title`, `author`, `author_image`, `image`, `categories`,
                                        `tags`, `post_data`, `views`, `status`) VALUES (NULL, CURRENT_TIMESTAMP, '$title', '$session_username', 
                                        '$session_author_image', '$image', '$categories', '$tags', '$post_data', '0', '$status')";
                                        if(mysqli_query($con,$insert_query)){
                                            $msg="Post Has been added";
                                            $path="img/$image";//path where  post image is to copied

                                              //successfull submit hone ke badd sbfields ko balnk bhi kkrr dena hai 
                                            $title="";
                                            $post_data="";
                                            $status="";
                                            $tags="";
                                            $categories="";
                                            //move that post image 
                                            //move_uploaded_file — Moves an uploaded file to a new location and it is bool type then return true or false
                                            //move_uploaded_file ( string $filename , string $destination ) 
                                            if(move_uploaded_file($tmp_name,$path)){
                                          //The copy() function copies a file.
                                          //If the file file already exists, it will be overwritten.
                                          //synatx -copy(from_file, to_file)
                                            copy($path,"../$path");
                                          }
                                       }
                                      else{
                                          $error="Post has not been added";
                                          }
                                         }
                                        } 
                                        ?>
                          <div class="row">
                                <div class="col-12">
                                      <form action="add-post.php" method="post" enctype="multipart/form-data">
                                      <div class="form-group">
                                      <label for="title">Title:-*</label>
                                    <?php
                                    //msg printing
                                      if(isset($error)){
                                        echo "<span style='color:red;' class='pull-right'>$error</span>";
                                      }
                                      else if(isset($msg)){
                                        echo "<span style='color:green;' class='pull-right'>$msg</span>";
                                      }
                                      ?>
                                      <input type="text" name="title" placeholder="Type Post Title Here" 
                                          value="<?php if(isset($title)){echo $title;
                                          //lets suppoose clicked submit button without filling all manadatory field
                                          // then ,jo bhra hua data wo erase na ho jaye usko echo kra diya hai.

                                          }?>" 
                                          class="form-control">
                                      </div>
                                      <div class="form-group">
                                        <a href="media.php" class="btn btn-primary">Add Media</a>
                                      </div>
                                      <div class="form-group">
                                            <textarea name="post-data" id="textarea" rows="10" class="form-control">
                                                  <?php if(isset($post_data)){echo $post_data;}?>
                                            </textarea>
                                      </div>
                                      <div class="row">
                                            <div class="col-sm-6">
                                                  <div class="form-group">
                                                 <label for="file">Post Image:-*</label>
                                                 <input type="file" name="image">

                                            </div>
                                      </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                  <label for="categories">Categories:-*</label>
                                                  <select name="categories" id="categories" class="form-control">
                                              <?php
                                              //we have to make dropdown of all categeries that is already 
                                              $cat_query="SELECT * FROM categories ORDER BY ID DESC";
                                              //jo latest category hoga wo top me ayega 
                                              $cat_run=mysqli_query($con,$cat_query);
                                              if(mysqli_num_rows($cat_run)>0){
                                                while($cat_row=mysqli_fetch_array($cat_run)){
                                                $cat_name=$cat_row['category'];
                                                //way how to take the options from php in dropdown menu
                                                echo "<option value='".$cat_name."' 
                                                ".((isset($categories) and $categories==$cat_name)?"selected":"").">".ucfirst($cat_name)."</option>";
                                                //if any options has selected ,and without filling manadatory Entries ,if we clicked submit button then it reatains the same option value in dropdown
                                                }
                                              }
                                              else{
                                                echo "<center><h6>No Categories Available</h6></center>";
                                              }
                                              ?>

                                         </select>
                                      </div>
                                  </div>
                            </div>
                                <div class="row">
                                      <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="tags">Tags:-*</label>
                                                <input type="text" name="tags" placeholder="Your Tags Here" class="form-control"  value="<?php if(isset($tags)){echo $tags;}?>">
                                            </div>
                                        </div>
                                      <div class="col-sm-6">
                              <div class="form-group">
                          <label for="status">Status:-*</label>
                                <select name="status" id="status" class="form-control">
                                      <option value="publish" <?php 
                                      //if any options has selected ,and without filling manadatory Entries ,if we clicked submit button then it reatains the same option value in dropdown
                                      if(isset($status) and $status=='publish'){echo "selected";}?>>
                                          Publish
                                      </option>
                                      <option value="draft" <?php if(isset($status) and $status=='draft'){echo "selected";}?>>
                                          Draft
                                      </option>

                                </select>
                            </div>
                           </div>
                        </div>
                      <input type="submit" name="submit" value="Add-Post" class="btn btn-primary"> 
                    </form>                  
                  </div>
                </div>
            </div>
        </div>
      </div>
<?php require_once('inc/footer.php')?>