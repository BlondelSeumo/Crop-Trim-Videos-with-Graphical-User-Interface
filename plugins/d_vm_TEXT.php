 <div class="col-md-12" >
<div class="collapse" id="d_vm_TEXT">
  <div class="card card-body">
 <!-- Text Watermark  Form -->
        <div class="col-md-12" style="background-color: #e8e8e8;">
            <h2> Text Watermark It!</h2>
            
             <form method="post" action="" enctype="multipart/form-data">
                 <div class="col-md-4" >
                <div class="form-group">
                <label for="watertxt">Watermark Text</label>
                <input class="form-control" type="text" name="watertxt" id="watertxt" placeholder="Write Watermark Text" required>
                </div>
                 <div class="form-group">
                <label for="watertxt">Watermark Position</label>
                <select name="t_pos_select" class="form-control" onchange="document.getElementById('t_pos').value = this.value;">
                    <option value="7#7">Top Left</option>
                    <option value="w-tw-7#7">Top Right</option>
                    <option value="main_w/2#10">Center Top</option>
                    <option value="(W-w)/2#H-h-20">Center Bottom</option>
                     <option value="7#h-th-7">Bottom Left</option>
                    <option value="w-tw-7#h-th-7">Bottom Right</option>
                </select>
                <input class="form-control" type="text" name="t_pos" id="t_pos" value="7#7" placeholder="Custom Position" required>
                </div>
                </div>
                <div class="col-md-4" >
                <div class="row form-group">
                 <div class="col-md-6" > 
                <label for="fontfile">Font Style</label>
                <select name="fontfile" class="form-control">
                     <?php
                      $d = dir("fonts");
                         while (false !== ($entry = $d->read())) {
                        if ($entry === '.' || $entry === '..') continue;
                     echo "<option value='fonts/{$entry}'> {$entry} </option>";
                        }
                     $d->close();
                    ?>
                </select>
                </div>
               <div class="col-md-6" >
                 <label for="fontsize">Size</label>
                    <input class="form-control" type="number" name="fontsize" value="20" required>
                    
                </div>     
                <div class="col-md-6" >
                      <label for="fontcolor">Color</label>
                    <select class="form-control" name="fontcolor_sel" onchange="document.getElementById('fontcolor').value = this.value;">
                       
                        <option value="White"> White </option>
                        <option value="Red"> Red </option>
                        <option value="Blue"> Blue </option>
                        <option value="Yellow"> Yellow </option>
                        
                    </select>
                    
                </div>
                <div class="col-md-6" >
                 <label for="topacity">Opacity (0.1 to 1)</label>
                    <input class="form-control" type="text" name="topacity" value="0.8" required>
                </div>
                <br><br>
                <input type="text" name="fontcolor" id="fontcolor" class="form-control" value="White" placeholder="use color code without # i.e ffffff">
                
               </div>
               </div>
               <div class="col-md-4" >
                     <div class="col-md-12" >
                 <label>Add Border Around Text?</label>  <br />
					YES<input type="radio" name="border" value="yes">	NO<input type="radio" name="border" value="no"  checked>
					</div>
                <div class="col-md-6" >
                    
                      <label for="fontcolor">Border Color</label>
                    <select class="form-control" name="bordercolor">
                        <option value="Red"> Red </option>
                        <option value="Blue"> Blue </option>
                        <option value="Yellow"> Yellow </option>
                        <option value="White"> White </option>
                        
                    </select>
                </div>
                <div class="col-md-6" >
                 <label for="bopacity">Opacity (0.1 to 1)</label>
                    <input class="form-control" type="text" name="topacity" value="0.8" required>
                </div>  
                
                 
               </div>
                
               <br /><hr>
                <div class="col-md-12">
                    <h2> Scrolling Text Feature</h2>
                <div class="col-md-3" >
                 <label>Scrolling Text ?</label>  
					YES<input type="radio" name="scroll" value="yes"> <input type="radio" name="scroll" value="no"  checked>
					</div>
					 <div class="col-md-3" >
					     
				       <input type="text" name="bpad" class="form-control" placeholder="Padding From Bottom Number i.e 20">
					</div>
					  <div class="col-md-3" >
					<select name="looptype" class="form-control">
					<option value="0"> One Time When Video Start</option>
					<option value="1"> Loop Forever</option>
					<option value="2"> Loop Every 10 Sec</option>

					</select>
					</div>
					  <div class="col-md-3" >
					<select name="speed" class="form-control">
					<option value="0"> Normal</option>
					<option value="1"> 1x</option>
					<option value="2"> 2x</option>
					<option value="3"> 3x</option>

					</select>
					</div>
					</div>
					<br><br>
					 <div class="col-md-12" >
                <input class="form-control btn btn-primary" type="submit" name="watermarktxt" id="watermarktxt" value="Text Watermark It!" >
               </div>
            </form>
      
        </div>

  </div>
</div>
 </div>
 
<?php
// Watermark Over Video Text
if (isset($_POST["watermarktxt"])) {
    $file = $_GET['f'];
    $file = substr($file, 0, strpos($file, "?"));
    $wmtxt  = $_POST['watertxt'];
   
    $fontcolor  = $_POST['fontcolor'];
    $fontopa  = $_POST['topacity'];
    
     $fsize = $_POST['fontsize'];
    $fontf = $_POST['fontfile'];
    $spad = $_POST['bpad'];
    
    $postxt  = $_POST['t_pos'];
    $p_txt = explode('#',$postxt);
    
    $fileo = $folder . $file;
    $filew = $folder . $file.'_WM_TEXT_'.time().'.mp4';
    echo $_POST['fontfile'];
    $ffmpeg_options['drawtext']['fontsize'] = $_POST['fontsize']; //font size
    $ffmpeg_options['drawtext']['fontfile'] = $_POST['fontfile']; // full path to font file
    $ffmpeg_options['drawtext']['text'] = $wmtxt;//text
    $ffmpeg_options['drawtext']['x'] = $p_txt[0];//position
    $ffmpeg_options['drawtext']['y'] = $p_txt[1];//position
    $ffmpeg_options['drawtext']['fontcolor'] = $fontcolor.'@'.$fontopa;//color and opacity
    if($_POST['border'] == 'yes'){
    $ffmpeg_options['drawtext']['borderw'] = 1;
    $ffmpeg_options['drawtext']['bordercolor'] = $_POST['bordercolor'].'@'.$_POST['topacity'];
    }


$draw = '';
foreach($ffmpeg_options['drawtext'] as $k=>$v){
		$draw .= $k . '=' . $v . ':';
	}


if ($_POST['scroll'] == 'yes'){
    echo"<h1> Adding Scrolling Watermark ...</h1>";
 
 
   if($_POST['looptype'] == 0){
       if($_POST['speed'] == 0){ $speed = 5; }elseif($_POST['speed'] == 1){ $speed = 4; }elseif($_POST['speed'] == 2){ $speed = 3; }elseif($_POST['speed'] == 3){ $speed = 1.5; }
	
		$cmd = "$ffmpeg -y -i $fileo -vf \"drawtext=text='$wmtxt':fontfile=$fontf:y=h-line_h-$spad:x=(w-(t-0)*w/$speed):fontcolor=$fontcolor@$fontopa:fontsize=$fsize:shadowx=2:shadowy=2\"  $filew";
	}elseif($_POST['looptype'] == 1){ 
	    if($_POST['speed'] == 0){ $speed = 2; }elseif($_POST['speed'] == 1){ $speed = 5; }elseif($_POST['speed'] == 2){ $speed = 15; }elseif($_POST['speed'] == 3){ $speed = 20; }
	
		$cmd = "$ffmpeg -y -i $fileo -vf \"drawtext=text='$wmtxt':expansion=normal:fontfile=$fontf:y=h-line_h-$spad:x=(mod($speed*n\,w+tw)-tw):fontcolor=$fontcolor@$fontopa:fontsize=$fsize:shadowx=2:shadowy=2\"  $filew";
	}elseif($_POST['looptype'] == 2){ 
	    if($_POST['speed'] == 0){ $speed = 5; }elseif($_POST['speed'] == 1){ $speed = 4; }elseif($_POST['speed'] == 2){ $speed = 3; }elseif($_POST['speed'] == 3){ $speed = 1.5; }
		$cmd = "$ffmpeg -y -i $fileo -vf \"drawtext=text='$wmtxt':fontfile=$fontf:y=h-line_h-$spad:x=w/$speed*mod(t\,10):enable=gt(mod(t\,20)\,10):fontcolor=$fontcolor@$fontopa:fontsize=$fsize:shadowx=2:shadowy=2\"  $filew";
	}else {
		echo 'Invalide Loop Type';
		die();
	}
	
	}else {
	echo"<h1> Adding Sticky Watermark ...</h1>";
    $cmd = $ffmpeg. ' -y -i "' . $fileo . '" -c:a copy -vf drawtext="'.$draw.'" '. $filew . ' 2>&1';
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
 