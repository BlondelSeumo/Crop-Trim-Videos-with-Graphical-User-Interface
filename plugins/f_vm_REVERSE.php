 <div class="col-md-12" >
<div class="collapse" id="f_vm_REVERSE">
  <div class="card card-body">
		<!-- Watermark Video Form -->
        <div class="col-md-12" style="background-color: #e8e8e8;">
            <h2> Reverse Video</h2>
             <form method="post" action="" enctype="multipart/form-data">
               
                 <div class="col-md-4" align="center">
                 <input type="radio" value="1" name="revaudio" class="form-control" checked>                
                 <br>
                 Reverse Audio
                 <br>
                </div>
                 <div class="col-md-4" align="center">
                 <input type="radio" value="2" name="revaudio" class="form-control">
                 
                 <br>
                 Do Not Reverse Audio
                 <br>
                </div>
                 <div class="col-md-4" align="center">
                 <input type="radio" value="3" name="revaudio" class="form-control">                
                 <br>
                 Remove Audio
                 <br>
                </div>           
                
               
               
                <br><br>
                <div class="col-md-12">
                 <input class="btn btn-primary btn-block" type="submit" name="reverseit" id="reverse" value="Reverse Video" >
                
                </div>
               
            </form>
            </br>
            <small>
                Info : Reverse Video, Also choose if you want to reverse audio as well.
            </small>  
        
        </div>

  </div>
</div>
 </div>

<?php
// Watermark Over Video Image
if (isset($_POST["reverseit"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $audio = $_POST['revaudio'];

    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_WM_REVERSE_'.time().'.mp4';
    if($audio == 1){
        $cmd = "$ffmpeg -i $fileo -vf reverse -af areverse $filew";
    }elseif($audio == 2){
        $cmd = "$ffmpeg -i $fileo -vf reverse  $filew";
    }elseif($audio == 3){
        $cmd = "$ffmpeg -i $fileo -vf reverse -an $filew";
    }

    
    
  
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
 