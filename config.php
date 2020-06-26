<?php 

/*** Config file ***/
error_reporting(0);
//Rename it only if you change index.php to downloader.php for example
$mainPage = "index.php";

// -> with "/" <- at the end. Directory where you videos are downloaded
$folder = "videos/"; 

//keep original videos? Set TRUE, Replace On Exsisting Video Set FALSE
$keeporiginal = TRUE;

//Set Max Upload File Size For Browse Files
$maxfilezie = '200000000';  //200000000 is about 200 MB

//Rename it only if you change list.php to myvideos.php for example
$listPage = "list.php";

//Thumbnail Size Settings ("-1:-1" Is Original resolution) (Example Set Max Widh To 280 Pixel ? try "280:-1") (150x150px Use "150:150")
$thumbs_size = "280:-1";

// Enable password to access the panel
// 1 -> enable 0 -> disable
$security = 1; 

// PHP::md5(); You can use https://www.md5hashgenerator.com/ to generate an other one
$secretPassword = "fe01ce2a7fbac8fafaed7c982a04e229";

//FFMPEG SETTINGS

$ffmpeg = "bin/ffmpeg"; // "bin/ffmpeg" will use static build comes with this script
// if you want to ffmpeg installed on your server please Define FFMPEG Path Normally its ffmpeg or /usr/local/bin/ffmpeg or /usr/bin/ffmpeg


//Video Quality (Enabling this option will take more resuource RAM and TIME)
//$quality = '-codec:v libx264 -crf 18 -preset slow -pix_fmt yuv420p -c:a aac -strict -2';
$quality = '-preset veryslow';
//$quality = ''; //To Disable uncomment this, if you not wanted hight quality and longer process time.


//Turn On Off Debuge true,false
define('DEBUG',false);
?>