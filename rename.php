<?php 
require_once("sessions.php");

$fname = $_GET['fname'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$newname = $_POST['newfname'];
$newname = str_replace(" ","-",$newname);
$newname = "$newname";

rename("videos/$fname", "videos/$newname");
header('Location: list.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Youtube-dl WebUI - List of videos</title>
        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" media="screen">-->
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.min.css">
        <style>
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
    background-color: #2C3E50;
}
body > .container {
  padding: 80px 15px 0;
}
        </style>
    </head>
    <body >
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Youtube-dl WebUI</a>
            </div>
            <div class="navbar-collapse  collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Download</a></li>
                    <li class="active"><a href="list.php">List of videos</a></li>
                    
                </ul>
            </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
               <form method="post" action="">
<input type="text" name="newfname" value="<?php echo $fname; ?>" class="form-control">
<input type="submit" name="Rename" class="btn btn-primary">
</form>

<br>
<div class="panel panel-info">
                        <div class="panel-heading"><h3 class="panel-title">Info</h3></div>
                        <div class="panel-body">
                            <p>File Name Must End With Extensions Like Filename.mp4</p>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div><!-- End container -->
        <br>


        <footer class="footer">
            <div class="container">
                <div class="row">
       <div class="col-md-6"></div><div class="col-md-6"></div>                </div>     
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
 
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
    </body>
</html>