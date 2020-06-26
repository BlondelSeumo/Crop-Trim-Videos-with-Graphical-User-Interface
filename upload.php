<?php

// Upload and Rename File
require_once("config.php"); 
if (isset($_POST['submit']))
{
	$filename = $_FILES["file"]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
	$allowed_file_types = array('.mp4','.3gp');	
	 
	$newnamex = $_POST["newname"];
	$newnamex = str_replace(' ','-',$newnamex);
	$newfilename = $newnamex. $file_ext;
	if (!$newnamex){
	    $newnamex = $filename;
	    $newfilename = str_replace(' ','-',$newnamex);
	}
	if (in_array($file_ext,$allowed_file_types) && ($filesize < $maxfilezie))
	{	
	
		
		
		move_uploaded_file($_FILES["file"]["tmp_name"], $folder . $newfilename);
		header('Location: list.php');
	
	}
	elseif (empty($file_basename))
	{	
		// file selection error
		echo "Please select a file to upload.";
	} 
	elseif ($filesize > $maxfilezie)
	{	
		// file size error
		echo "The file you are trying to upload is too large.";
	}
	else
	{
		// file type error
		echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
		unlink($_FILES["file"]["tmp_name"]);
	}
}

?>