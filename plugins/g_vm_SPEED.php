<div class="col-md-12">
    <div class="collapse" id="g_vm_SPEED">
        <div class="card card-body">
            <!-- Watermark Video Form -->
            <div class="col-md-12" style="background-color: #e8e8e8;">
               
                <div class="row">
               
                    <div class="col-md-6">
                        
                    <h2> Speed Up</h2>
                    <form method="post" action="" enctype="multipart/form-data">             
                  
                    <input  class="form-control" type="text" name="speed" value="2" placeholder="Add speed X in number, Add 2 for 2x speed" required>
                    <br> <br>
                    <input class="btn btn-primary btn-block" type="submit" name="speedup" id="speedup" value="Speed Up">
                    </form>
                  </div>
                
                   
                    <div class="col-md-6">
                        <h2> Slow Down </h2>
                    <form method="post" action="" enctype="multipart/form-data" >             
                  <select name="slow" class="form-control" required>
                  <option value="2">2x Slow Down</option>
                  <option value="4">4x Slow Down</option>       
                  </select>                 
                  <br> <br>
                  <input class="btn btn-primary btn-block" type="submit" name="slowdown" id="slowdown" value="Slow Down">
                  </form>
                         
                    </div>
                    
                   
              
                </div>
                </br>
                <small>
                   
                </small>

            </div>

        </div>
    </div>
</div>

<?php
// Speed Up Code
if (isset($_POST["speedup"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $speed = $_POST['speed']; 
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_R_SPEED_'.time().'.mp4';
   
    //speed up
    $cmd ="$ffmpeg -i $fileo -filter_complex \"[0:v]setpts=PTS/".$speed."[v];[0:a]atempo=".$speed."[a]\" -map \"[v]\" -map \"[a]\" $filew 2>&1";
    
    exec($cmd,$output);   
    
    if(!$keeporiginal){
        rename($filew, $fileo);
    }

    $thumb = "$fileo.jpeg";
    
    if (file_exists($thumb)) {
        unlink($thumb);
    }
    echo "<script> window.location = 'list.php'; </script>";
}
//Slow down code
if(isset($_POST["slowdown"])){
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));

    $slow = $_POST['slow'];
 
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_R_SPEED_'.time().'.mp4';

   
  
    if($slow == 2){
        $cmd ="$ffmpeg -i $fileo -filter_complex \"[0:v]setpts=2*PTS[v];[0:a]atempo=0.5[a]\" -map \"[v]\" -map \"[a]\" $filew 2>&1";
    }
    if($slow == 4){
        $cmd ="$ffmpeg -i $fileo -filter_complex \"[0:v]setpts=4*PTS[v];[0:a]atempo=0.5,atempo=0.5[a]\" -map \"[v]\" -map \"[a]\" $filew 2>&1";
    }  

    exec($cmd,$output);

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