<?php
require_once("config.php"); 
require_once("sessions.php");
if(!isset($_SESSION['logged']))
{
die();
}
if ($_GET['f'] == ''){
    echo 'Please Select A File <a href="list.php">Click Here</a>';
    die();
}
?>
<html>
    <head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            #draggable{
                width:fit-content;
                height:fit-content;
            }
        </style>
    </head>
<body>
    <div id="vids">
        <video id="vdo" autoplay="" loop="" style="margin-top: -8px; margin-left: -8px;">
        <source src="videos/<?php echo $_GET['f']; ?>" type="video/mp4">
        </video>
    </div>
    <div id="draggable">
        <img id="image" src="" name="image-swap"/>
    </div>
    <br>
    <div class="row text-center">
	<div class="col-md-12">	
            <button class="btn btn-primary" onclick="ply()">Play</button>
            <button class="btn btn-primary" onclick="pus()">Pause</button>
            <button class="btn btn-primary" onclick="show()">Show Controls</button>
            <button class="btn btn-primary" onclick="hide()">Hide Controls</button>
            <a href="list.php" class="btn btn-primary">Go To Files</a>
			<br>
	</div>
	<div class="col-md-12">
    <h3>Choose Plugin</h3>
    <?php if ($handle = opendir('plugins')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {
			$tabs= str_replace('.php','',$entry);
			echo '<button class="btn btn-primary" data-toggle="collapse"  data-collapse-group="myDivs" data-target="#'.$tabs.'" role="button" aria-expanded="false" aria-controls="'.$tabs.'">'.substr($tabs,5).'</button>';
			include('plugins/'.$entry.'');
           
        }
    }

    closedir($handle);
    } ?>
    </div></div>
        <br><br>
    </div>
 <script>
var myVideo = document.getElementById( 'vdo' );
                 function ply(){
                    myVideo.play();
                 }
                function pus(){
                myVideo.pause();
                }
                function show(){
                myVideo.setAttribute( 'controls', '' );
                }
                function hide(){
                myVideo.removeAttribute( 'controls', '' );
                }
            </script>
<script>
$('#draggable').click(function(){
$("#draggable img").resizable({aspectRatio:true});
    $("#draggable").draggable();
    
    $('#resize').draggable();
});
  
$(function() {
    $("#draggable").draggable();	
    $('#resize').draggable();	
   
 });

var $myGroup = $('#myGroup');
$myGroup.on('show.bs.collapse','.collapse', function() {
    $myGroup.find('.collapse.in').collapse('hide');
});



</script>


<script>
function getresize(){
    var wrapper = $("#resize").offset();
		var rpx = wrapper.left;
		var rpy = wrapper.top;
		var rwidth = $("#resize").width();
		var rheight = $("#resize").height();
		//alert(rpx+':'+rpy); 
		//alert(rwidth+':'+rheight); 
if (rpx < 0 || rpy < 0) {
alert ('Out Of Area: Left Side Is ' + rpx + ' Top Side Is ' + rpy);
}else {

		$('#dim').val(rwidth+':'+rheight+':'+rpx+':'+rpy);
}
}



$("[data-collapse-group='myDivs']").click(function () {
    var $this = $(this);
    $("[data-collapse-group='myDivs']:not([data-target='" + $this.data("target") + "'])").each(function () {
        $($(this).data("target")).removeClass("in").addClass('collapse');
    });
});
</script>


</body>
</html>