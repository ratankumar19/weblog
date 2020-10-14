
<footer>
  <div class="container text-center " style="width: 100%">
      Copyright &copy; by <a href="">Ratan Singh</a>.
      All Right Reserved from 2017-<?php echo date('Y');?> 
   </div>
</footer>
</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    
     <script src="https://cdn.tiny.cloud/1/hbggzuzx799a8g31ovc978d6cmw1xtwc7own9e7glew21qq9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="js/code.js"></script>
   
<script>

tinymce.init({
  selector: 'textarea#textarea',
  height: 300,
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table paste imagetools wordcount"
  ],

<?php
//for edit or insert image that img will be come from all  media
  $media_query="SELECT * FROM media  ORDER BY id DESC";
  $media_run=mysqli_query($con,$media_query);
  if(mysqli_num_rows($media_run) >0){


  ?>

image_list: [


 <?php 
 //mysqli_fetch_array — Fetch a result row as an associative, a numeric array, or both
  while($media_row=mysqli_fetch_array($media_run)){
    $media_name=$media_row['image'];
  
  ?>
   {title: '<?php echo $media_name;?>', value: 'media/<?php echo $media_name;?>'},
   
 <?php }?>
   ],
   <?php }?>



  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  content_css: '//www.tiny.cloud/css/codepen.min.css'
});


    </script>
    
  </body>
</html>