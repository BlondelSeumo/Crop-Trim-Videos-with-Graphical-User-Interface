 <div class="col-md-12" >
<div class="collapse" id="e_vm_CONVERT">
  <div class="card card-body">
		<!-- Watermark Video Form -->
        <div class="col-md-12" style="background-color: #e8e8e8;">
            <h2> Watermark It!</h2>
             <form method="post" action="" enctype="multipart/form-data">
              <div class="col-md-6">
                <div class="input-group">
                    Make New File <input type="radio" name="make" value="new" class="form-control" checked>
                    <br>
                    Convert Same File<input type="radio" name="make" value="same" class="form-control">
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-group">
                    <select name="toext" class="form-control" required>
                        <option value="">Select Format</option>
                <?php 
                $file = $_GET['f'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $extarry = array('mp4','3gp','avi','mkv','flv');
                foreach($extarry as $eext){
                     if($eext == $ext){
                        continue;
                }
		            echo '<option value="'.$eext.'">'.$eext.'</option>';
	            }
                
                ?>
                </select>
               
                 <span class="input-group-btn">
                 <input class="btn btn-primary" type="submit" name="convert" id="crop" value="convert" >
                 </span>
                </div></div>
               
            </form>
            </br>
            <small>
                Info : Select Watermark and Drag To Posistion > Doubble Click On IT and Hit The Watermark Button.
            </small>  
        
        </div>

  </div>
</div>
 </div>
 
<?php
// Watermark Over Video Image
if (isset($_POST["convert"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $toext = $_POST['toext'];
    $make = $_POST['make'];
    
    $fileo = $folder . $file;
    
  
    $tofile = $folder . $file.'_.' .$toext;

    //$cmd ="$ffmpeg -i $fileo -vcodec copy -acodec copy $tofile 2>&1";
    // $cmd ="$ffmpeg -i $fileo -c:v libx264 -c:a libmp3lame -b:a 384K $tofile 2>&1";
    //exec($cmd,$output);
    exec("$ffmpeg -i $fileo -c:v libx264 -crf 20 -c:a aac -strict -2 '$tofile'");
  
    
  
    if($make == 'same'){
        unlink($fileo);
    }
    
   
    $thumb = "$tofile.jpeg";
    
    
    
    if (file_exists($thumb)) {
        unlink($thumb);
    }
    echo "<script> window.location = 'list.php'; </script>";
}
?>
