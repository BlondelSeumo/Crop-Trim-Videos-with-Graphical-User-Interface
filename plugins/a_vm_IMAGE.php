 <div class="col-md-12" >
<div class="collapse" id="a_vm_IMAGE">
  <div class="card card-body">
		<!-- Watermark Video Form -->
        <div class="col-md-12" style="background-color: #e8e8e8;">
            <h2> Watermark It!</h2>
             <form method="post" action="" enctype="multipart/form-data">
                 <?php
                      $d = dir("watermark");
                         while (false !== ($entry = $d->read())) {
                        if ($entry === '.' || $entry === '..') continue;
                     echo "<img src='watermark/{$entry}'> <input type='radio' id='wm' name='wm' value='watermark/{$entry}' onclick='setImage(this);'> <br><hr>";
                        }
                     $d->close();
                    ?>
                <br/>
                <div class="input-group">
                <input  class="form-control posiimg" type="text" name="pos" id="posiimg" placeholder="Watermark Position" required>
                 <span class="input-group-btn">
                 <input class="btn btn-primary" type="submit" name="watermark" id="crop" value="Watermark" >
                 </span>
                </div>
               
            </form>
            </br>
            <small>
                Info : Select Watermark and Drag To Posistion > Doubble Click On IT and Hit The Watermark Button.
            </small>  
        
        </div>

  </div>
</div>
 </div>
<script>
function setImage(select){
    var image = document.getElementsByName("image-swap")[0];
    image.src = $("input[name='wm']:checked").val();
}

$(function(){
    $(document).dblclick(function(e){
        
		var wrapper = $("#draggable").offset();
		var px = wrapper.left;
		var py = wrapper.top;
		$('.posiimg').val(px+':'+py);      
       		
    });
	
})
</script>
<?php
// Watermark Over Video Image
if (isset($_POST["watermark"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $wmt  = $_POST['wm'];
    $pos  = $_POST['pos'];
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_WM_'.time().'.mp4';
    //for older verisons
    //$cmd = "$ffmpeg -i $fileo -vf 'movie=$wmt [watermark]; [in][watermark] overlay=$pos [out]' $quality '$filew' 2>&1";
    $cmd = "$ffmpeg -i $fileo -i $wmt -filter_complex \"overlay=$pos\" $filew";
    
    exec($cmd ,$output);
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
 