<?php require_once('inc/top.php');
//session check
session_start();
if(!isset($_SESSION['username'])){
 header("Location:login.php");
}
?>
</head>
    <body>
        <div id="wrapper">
            <?php require_once('inc/header.php');?>
                <div class="container-fluid body">
                    <div class="row">
                          <?php require_once('inc/sidebar.php')?>
                              <div class="col-md-9">
                                  <h1>
                                      <i class="fa fa-database animate__animated animate__backInRight"></i> <strong>Media</h1></strong> 
                                  </h1>
                                  <hr>
                                  <ol class="breadcrumb">
                                      <li><a href="index.php">Add or View Media </a></li>
                                      
                                  </ol>
                                  <?php 
                                  if(isset($_POST['submit'])){

                                    //if add media has clicked
                                    if(count($_FILES['media']['name'])>0){//at least we have to choose 1 img and count function ,count krega kitna img liya hai
                                      for($i=0;$i<count($_FILES['media']['name']);$i++){//usko count krlega then utna time insert query chlega
                                        $image=$_FILES['media']['name'][$i];
                                        $tmp_name=$_FILES['media']['tmp_name'][$i];
                                        $query="INSERT INTO `media` (`id`, `image`) VALUES (NULL, '$image')";
                                        if(mysqli_query($con,$query)){
                                          $path="media/$image";
                                          //move the media image to medai folder that is at the front end 
                                          if(move_uploaded_file($tmp_name, "media/$image")){
                                          copy($path, "../$path");
                                        }
                                        }
                                      }
                                    }
                                  }
                                  ?>
                                 <form action="" method="post" enctype="multipart/form-data">
                                      <div class="row">
                                          <div class="col-sm-4 col-8">
                                            <!--name attribute is set as Array so that we will chosse multiple image at a time-->
                                               <input type="file" name="media[]" required multiple>
                                          </div>
                                          <div class="col-sm-4 col-4">
                                                <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Add Media">
                                           </div>
                                      </div>
                                 </form>
                              <hr>
                          <div class="row">
                        <?php 
                        //we have to display that media 
                          $get_query="SELECT * FROM media ORDER BY id DESC";
                          $get_run=mysqli_query($con,$get_query);
                          if(mysqli_num_rows($get_run)>0){
                          while($get_row=mysqli_fetch_array($get_run)){
                              $get_image=$get_row['image'];
                        ?>
                      <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                          <a href="media/<?php echo $get_image;?>">
                              <img src="media/<?php echo $get_image;?>" width="100%" alt="media-img" class="img-thumbnail">
                          </a>
                      </div>
                  <?php  
                      }
                    }
                    else{
                    echo "<center><h2>No media Available</h2></center>";
                  }
                 ?>
               </div>
          </div>
      </div>
  </div>
<?php require_once('inc/footer.php')?>