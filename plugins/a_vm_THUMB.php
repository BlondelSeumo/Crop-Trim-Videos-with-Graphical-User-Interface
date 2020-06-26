<div class="col-md-12" >
<div class="collapse" id="a_vm_THUMB">
  <div class="card card-body">
	<!-- Trim Video Form -->
        <div class="row" style="background-color: #e8e8e8;">
        <h2>Generate Thumbnail</h2>
        
           <div class="col-md-6">
            <b>Generate Thumbs : Pause It And Click Generate Thumbnail!</b>
           
             <form method="post" action="" enctype="multipart/form-data">
                  <div class="input-group">
             <input class="form-control" type="text" name="ttime" id="ttile"><span class="input-group-btn"><input class="btn btn-primary" type="submit" name="thumb" id="thumb" value="Generate Perfect Thumb"></span>
             </div>
             </form>
             Remaining Time: <span id="remTime"></span> / <span id="totalTime"></span>
             </div>

        </div>

  </div>
</div>
</div>
<script>
    //get video time for thumbnail
function fromSeconds(seconds, showHours) {
    if(showHours) {
        var hours = Math.floor(seconds / 3600),
            seconds = seconds - hours * 3600;
    }
    var minutes = ("0" + Math.floor(seconds/60)).slice(-2);
    var seconds = ("0" + parseInt(seconds%60,10)).slice(-2);

    if(showHours) {
        var timestring = hours + ":" + minutes + ":" + seconds;
    } else {
        var timestring = minutes + ":" + seconds;
    }
    return timestring;
}
var video = $('#vdo');
video.bind("timeupdate", function () {
    var stime = video[0].currentTime;
    stime = stime.toString();
    stime = stime.split(".").pop();
    stime = stime.substr(0,3);
    $('#scc').html(stime);
    $('#oss').html(video[0].currentTime);
    $('#ttile').val(fromSeconds(video[0].currentTime)+'.'+stime);
  
    $('#remTime').html(fromSeconds(video[0].duration - video[0].currentTime));
    $('#remTime2').html(fromSeconds(video[0].duration - video[0].currentTime));
    $('#totalTime').html(fromSeconds(video[0].duration));
    $('#totalTime2').html(fromSeconds(video[0].duration));
});
</script>
<?php
// Thumbnail Generator
if (isset($_POST["thumb"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $wmt  = $_POST['ttime'];
    echo "thumbs : $wmt";
    
    $fileo = $folder . $file;
    exec("$ffmpeg -y -i $fileo -ss $wmt -vf scale=$thumbs_size '$fileo.jpeg'");
   
    echo "<script> window.location = 'list.php'; </script>";
}
?>
 