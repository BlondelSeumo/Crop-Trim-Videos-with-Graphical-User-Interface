<div class="col-md-12" >
<div class="collapse" id="c_vm_TRIM">
  <div class="card card-body">
	<!-- Trim Video Form -->
        <div class="row" style="background-color: #e8e8e8;">
        <h2>Trim It!</h2>
        
            <form method="post" action="" enctype="multipart/form-data">
             <?php 
              $file = $_GET['f'];
              $fileo = $folder.$file;
              $time = exec("ffmpeg -i $fileo 2>&1 | 
              grep Duration | cut -d ' ' -f 4 | sed s/,//");
              ?>
            <div class="col-md-6">
                <lable>Start Time : </lable><input class="form-control" type="text" name="times" id="times" value="00:00:00" placeholder="HH:MM:SS" required><br>
                <lable>End Time : </lable><input class="form-control" type="text" name="timee" id="timee" value="<?php echo $time; ?>" placeholder="HH:MM:SS" required><br>
                     </br></br>
               <input class="btn btn-primary" type="submit" name="cut" id="cut" value="Trim By Time">
              
            </form>
          </div>
              <div class="col-md-6">
            
             Remaining Time: <span id="remTime2"></span> / <span id="totalTime2"></span>
             </div>
             
            <br>

            
           
        </div>

  </div>
</div>
 </div>
 
<?php
//cutting Triming The Video
if (isset($_POST["cut"])) {
    $file  = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $fileo = $folder . $file;
    $filew = $folder . 'wm.mp4';
    $cuts  = $_POST['times'];
    $cute  = $_POST['timee'];

    exec("$ffmpeg -y -ss $cuts -i $fileo -vcodec copy -acodec copy -to $cute $filew");
    rename($filew, $fileo);
    
    echo "<script> window.location = 'list.php'; </script>";
}
?>
 