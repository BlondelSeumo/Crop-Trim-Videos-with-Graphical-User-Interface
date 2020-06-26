<div class="col-md-12" >
<div class="collapse" id="b_vm_CROP">
  <div class="card card-body">
	<!-- Crop Video Form -->
        <div class="col-md-4">
        <h2> Crop It!</h2>
            <form method="post" action="" enctype="multipart/form-data">
			Select aspect ratio and drag the selecter over video <br>
            <select name="art" onchange="aratio();">
                <option value="0">MUST SELECT RATIO</option>
                <option value="1">Any Ratio</option>
                <option value="2"> 16:9 HD TV</option>
                <option value="3">4:3 Popular</option>
                <option value="4">1:1 Instagram Loves It</option>
            </select><br><br>
			
                 <div class="input-group">
            <input class="form-control" type="text" name="dim" id="dim" required placeholder="width:height:left:top">
            <span class="input-group-btn">
            <input class="btn btn-primary" type="submit" name="crop" id="crop" value="Crop">
            </span>
            </div>
            </form>
            
            
            <div id="resize" class="demodiv"><a href="#" onclick="getresize();" class="btn btn-default">GET AREA</a></div>
        </div>

  </div>
</div>
 </div>
<script>
    //get acpet ratio
function aratio(){
    var rsize = $('select[name=art]').val();
    
    if (rsize == 1){
         $('#resize').resizable({
      helper: "ui-resizable-helper",
    });
        
    }else if (rsize == 2){
      $('#resize').resizable({
    helper: "ui-resizable-helper",
     aspectRatio: 16 / 9
    });
       
    }else if (rsize == 3){
      $('#resize').resizable({
    helper: "ui-resizable-helper",
     aspectRatio: 4 / 3
    });
       
    }else if (rsize == 4){
      $('#resize').resizable({
    helper: "ui-resizable-helper",
     aspectRatio: 1 / 1
    });
       
    }
    
}
</script>
<?php
// Croping the Video Portion
if (isset($_POST["crop"])) {
    $file  = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $fileo = $folder . $file;
    $filew = $folder . $file.'_CROPED_'.time().'.mp4';
    $dim   = $_POST['dim'];
    echo $dim;
    exec("$ffmpeg -i $fileo -filter:v 'crop=$dim' '$filew'");
    
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
 