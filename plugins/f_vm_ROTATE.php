 <div class="col-md-12" >
<div class="collapse" id="f_vm_ROTATE">
  <div class="card card-body">
		<!-- Watermark Video Form -->
        <div class="col-md-12" style="background-color: #e8e8e8;">
            <h2> Rotate Video</h2>
             <form method="post" action="" enctype="multipart/form-data">
               
                 <div class="col-md-3" align="center">
                 <input type="radio" value="1" name="angle" class="form-control">
                 <img src="img/1.jpg">
                 <br>
                 90Clockwise
                 <br>
                </div>
                 <div class="col-md-3" align="center">
                 <input type="radio" value="2" name="angle" class="form-control">
                 <img src="img/2.jpg">
                 <br>
                 90CounterClockwise
                 <br>
                </div>
                 <div class="col-md-3" align="center">
                 <input type="radio" value="0" name="angle" class="form-control">
                 <img src="img/0.jpg">
                 <br>
                 90CounterCLockwise and Vertical Flip
                 <br>
                </div>
                 <div class="col-md-3" align="center">
                 <input type="radio" value="3" name="angle" class="form-control">
                 <img src="img/3.jpg">
                 <br>
                 90Clockwise and Vertical Flip
                 <br>
                </div>
                
               
               
                <br><br>
                <div class="col-md-12">
                 <input class="btn btn-primary btn-block" type="submit" name="rotateit" id="rotate" value="Rotate The Video" >
                
                </div>
               
            </form>
            </br>
            <small>
                Info : Set IN and Out Time In Seconds > Select Watermark and Drag To Posistion > Doubble Click On IT and Hit The Watermark Button.
            </small>  
        
        </div>

  </div>
</div>
 </div>

<?php
// Watermark Over Video Image
if (isset($_POST["rotateit"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $set = $_POST['angle'];
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_ROTATE_'.time().'.mp4';
    $cmd = $ffmpeg.' -i '.$fileo.' -vf "transpose='.$set.'" -qscale 0 '.$filew;
    exec($cmd);
    if(!$keeporiginal){
    rename($filew, $fileo);
    }
    $thumb = "$fileo.jpeg";
    
    if (file_exists($thumb)) {
        unlink($thumb);
    }
    echo "<script> window.location = 'list.php'; </script>";
}
?>
 