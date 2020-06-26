<div class="col-md-12">
    <div class="collapse" id="g_vm_VIDEO">
        <div class="card card-body">
            <!-- Watermark Video Form -->
            <div class="col-md-12" style="background-color: #e8e8e8;">
                <h2> Watermark Video</h2>
                <div class="row">
                <form method="post" action="" enctype="multipart/form-data" onsubmit="$('#ulani').show();">
                    <div class="col-md-6">
                        Select the watermark video
                        <select name="wm" id="wmfile" class="form-control">
                        <option value="">Select Watermark File</option>
                            <?php
                            $d = dir("watermark_video");
                                while (false !== ($entry = $d->read())) {
                                if ($entry === '.' || $entry === '..') continue;
                                if (strpos($entry, '.png') == false) {
                                $fullpath ="watermark_video/{$entry}";
                                $imgt = "watermark_video/{$entry}.png";
                                if(!file_exists($imgt)){
                                                                     
                                    $cmd = $ffmpeg.' -y -i '.$fullpath.' -t 00:00:03.000 -vframes 1 '.$imgt.' 2>&1'; 
                            
                                    exec($cmd,$output);                                                                  
                                }
                            }else{
                                echo "<option value='watermark_video/{$entry}'> {$entry} </option>";
                            }
                               
                                   
                                }
                            $d->close();
                            ?>
                        </select>
                        <br>
                         <input class="form-control posi" type="text" name="pos" id="posi"
                            placeholder="Watermark Position" required>
                            
                             <input class="form-control width" type="text" name="width" id="width"
                            placeholder="Watermark Size Width" required>
                    </div>
                    <div class="col-md-6">
                        Format Must in seocnds 1.01 Seconds = 61 Seconds
                        <div id="fields">
                        <div class="input-group">
                            <input class="1 form-control" type="text" name="delay[]" 
                                placeholder="Deplay Time In Seconds" required> <span class="input-group-btn"> <a
                                    onClick="settime(1);" class="btn btn-primary">Get Time</a> <a
                                    onClick="addfield();" class="btn" style="background-color:#3A3A3C;"> + </a></span>
                        </div>
                        
                        </div>
                        
                    
                    <br>
                   
                    </div>
                    
                    <div class="col-md-12"><br><br>
                     <div id="ulani" style="display:none;">
                        <div  align="center" class="spinner-border" role="status" >
                        <span class="sr-only">Loading...</span>
                        </div> Processing Video...</div>
                  <input class="btn btn-primary btn-block" type="submit" name="watermarkvd" id="watermarkvd" value="Render Video">
                  </div>
                </form>
                </div>
                </br>
                <small>
                   
                </small>

            </div>

        </div>
    </div>
</div>
<script>
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

<script>
var vid = document.getElementById("vdo");
function settime(id){
     $('.'+id).val(vid.currentTime);
}
</script>
<script>
let fid = 1;
    function addfield(){
        fid++;       
      fld = '<div id="'+fid+'" class="input-group"><input class="'+fid+' form-control" type="text" name="delay[]"  placeholder="Deplay Time In Seconds" required> <span class="input-group-btn"> <a onClick="settime('+fid+');" class="btn btn-primary">Get Time</a><a onClick="rmvfiled('+fid+');" class="btn btn-danger"> - </a></span></div>';
    $("#fields").append(fld);
    }
    function rmvfiled(fid){
        $('#'+fid).remove();
    }
</script>

<?php
// Watermark Over Video Image
if (isset($_POST["watermarkvd"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $wmt  = $_POST['wm'];
    $wmt = str_replace('.png','',$wmt);
    $pos  = $_POST['pos'];
    $pose = explode(':',$pos);
    $posx = $pose[0];
   $posx = ($posx / 100);
   
    $posy = $pose[1];
    $posy = ($posy / 100);

   
    $width  = $_POST['width'];
   
    
    $delay  = $_POST['delay'];
   
    if(count($delay) == 1){
       $delay = $delay[0]; 
       
       $avid = '[1]setpts=PTS+'.$delay.'/TB,scale='.$width.':-1[ts],[0][ts]overlay=x=\''.$posx.'*W\':y=\''.$posy.'*H\':eof_action=pass[out]';
       
    }else{
        $lastElement = end($delay);
        $frist = reset($delay);
        foreach($delay as $evido){
            
        if($evido == $frist){
            $avid .= '[1]setpts=PTS+'.$evido.'/TB,scale='.$width.':-1[ts],[0][ts]overlay=x=\''.$posx.'*W\':y=\''.$posy.'*H\':eof_action=pass[out]';
        }else{
           $avid .= '[1]setpts=PTS+'.$evido.'/TB,scale='.$width.':-1[b],[out][b]overlay=x=\''.$posx.'*W\':y=\''.$posy.'*H\':eof_action=pass[out]'; 
        }
         
         if($evido== $lastElement) {
             
         }else{
            $avid .= ';'; 
         }
         
        }
        
    }
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_WM_VIDEO_'.time().'.mp4';

    
    $cmd = $ffmpeg.' -i '.$fileo.' -i '.$wmt.' -filter_complex "'.$avid.'" -map "[out]" -map 0:a -y '.$filew.' 2>&1';
   

  
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