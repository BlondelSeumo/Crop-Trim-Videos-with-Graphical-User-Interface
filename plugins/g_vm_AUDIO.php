<div class="col-md-12">
    <div class="collapse" id="g_vm_AUDIO">
        <div class="card card-body">
            <!-- Watermark Video Form -->
            <div class="col-md-12" style="background-color: #e8e8e8;">
               
                <div class="row">
               
                    <div class="col-md-8">
                        
                         <h2> Replace Audio</h2>
                         <form method="post" action="" enctype="multipart/form-data" onsubmit="$('#ulani').show();">
                        <select name="audiofile" id="audiofile" class="form-control" onChange="playaudio()">
                        <option value="">Select Audio File</option>
                            <?php
                            $d = dir("audio");
                                while (false !== ($entry = $d->read())) {
                                if ($entry === '.' || $entry === '..') continue;
                                if (strpos($entry, '.mp3') == false) {
                                $fullpath ="audio/{$entry}";
                                $imgt = "audio/{$entry}.png";
                               
                            }else{
                                echo "<option value='audio/{$entry}'> {$entry} </option>";
                            }
                                }
                            $d->close();
                            ?>
                        </select>
                        <br>
                        <audio id="aplayer" controls style="display:none;">
                            <source src="" type="audio/mpeg">
                           Your browser does not support the audio element.
                        </audio><br>
                        <br>
                        
                   <input type="radio" name="aoption" value="1" checked> Cut Video To Audio Lenght
                    <br> <br>
                   <input type="radio" name="aoption" value="2" > Keep Video With No Sound Afer Audio End
                     <br> <br>
                    <input type="radio" name="aoption" value="3">Loop Audio Till Video Lenght
                    <br> <br>
                    <input type="radio" name="aoption" value="4">Remove Audio Completely
                <br> <br>
                             <input class="btn btn-primary btn-block" type="submit" name="replaceaudio" id="replaceaudio" value="Replace Audio">
                             </form>
                  </div>
                
                   
                    <div class="col-md-4">
                        <h2> Extract Audio </h2>
                         <form method="post" action="" enctype="multipart/form-data" onsubmit="$('#ulani').show();">
                        
                        <p>Convert Video To Audio. Extract Audio From This Video File. Audio Will Be Saved Inside audio folder.</p>
                    
                    <br>
                    <input class="btn btn-primary btn-block" type="submit" name="extractaudio" id="extractaudio" value="Extract Audio">
                      </form>
                    </div>
                    
                    <div class="col-md-12"><br><br>
                     
                 <div id="ulani" style="display:none;">
                        <div  align="center" class="spinner-border" role="status" >
                        <span class="sr-only">Loading...</span>
                        </div> Processing Video...</div>
                  </div>
              
                </div>
                </br>
                <small>
                   
                </small>

            </div>

        </div>
    </div>
</div>
<script>
function playaudio() {
        $("#aplayer").show();
        var asrc = $("#audiofile").val();
        $("#aplayer").attr("src", asrc);
    }
$('#wmfile').change(function(){
   
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    $('#image').attr("src", "");
    $('#image').attr("src", valueSelected);
    
});

$(function() {
    $(document).dblclick(function(e) {
        var wrapper = $("#draggable").offset();
        var px = wrapper.left;
        var py = wrapper.top;
        var wmwidth = $('#draggable img').width();
        var vidsize = document.getElementById("vdo");
        var imgwpr = $("#image").width() / $('#vdo').width() * 100;
        var calw = (vidsize.videoWidth*imgwpr)/100;
        $('.width').val(calw);
        var position = $('#draggable').position();
        var percentLeft = position.left/$('#vids').width() * 100;
        var percentTop = position.top/$('#vids').height() *100;
        $('.posi').val(percentLeft + ':' + percentTop);
    });
})
</script>




<?php
// Watermark Over Video Image
if (isset($_POST["replaceaudio"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $audiofile  = $_POST['audiofile'];
    $loop = $_POST['aoption'];
 
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_R_AUDIO_'.time().'.mp4';

    if($loop == 1){
    //cutvideo
    $cmd = "$ffmpeg -i $fileo -i $audiofile -map 0:0 -map 1:0 -c:v copy -c:a aac -b:a 256k -shortest $filew 2>&1";
    }else if($loop == 2){
    //as it is
     $cmd = "$ffmpeg -i $fileo -i $audiofile -map 0:0 -map 1:0 -c:v copy -c:a aac -b:a 256k  $filew 2>&1";
    }else if($loop == 3){
     // loop audio
      $cmd = "$ffmpeg  -i $fileo -stream_loop -1 -i $audiofile -shortest -map 0:v:0 -map 1:a:0 -y $filew 2>&1";
    }else if($loop == 4){
     // loop audio
      $cmd = "ffmpeg -i $fileo -c copy -an $filew 2>&1";
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

if(isset($_POST["extractaudio"])){
     $file = $_GET['f'];
     $file = substr($file, 0, strpos($file, "?"));
    $fileo = $folder . $file;
    $filew = 'audio/' . $file.'EX_'.time().'.mp3';
    $cmd = "$ffmpeg -i $fileo $filew 2>&1";
    exec($cmd,$output);
     var_dump($output);
    
}
?>