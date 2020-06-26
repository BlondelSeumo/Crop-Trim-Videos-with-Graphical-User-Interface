<?php include 'header.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
<?php
if(isset($_SESSION['logged']) && $_SESSION['logged'] == 1)
{
   
    if(isset($_GET['imageToDelete'])){
        $imageToDelete = $_GET['imageToDelete'];
        $img = $imageToDelete;
        $img = $folder.$img.'.jpeg';		
		if (unlink("$img")){		
		echo "deleted";
		}
        
    }
	elseif(isset($_GET['fileToDel']))
    {
        $fileToDel = $_GET['fileToDel'];

        if(file_exists($folder.$fileToDel))
        {
            if(unlink($folder.$fileToDel))
            {
                
                $img = "$fileToDel.jpeg";
                if(file_exists($folder.$img)) @unlink($folder.$img);
                echo '<div class="panel panel-success">';
                echo '<div class="panel-heading"><h3 class="panel-title">File to delete : '.$fileToDel.'</h3></div>';
                echo '<div class="panel-body">File: '.$fileToDel.' Deleted !</div>';
                echo '</div>';
                echo '<p><a href="'.$listPage.'">Go back</a></p>';
            }
            else{
                echo '<div class="panel panel-danger">';
                echo '<div class="panel-heading"><h3 class="panel-title">File to delete : '.$fileToDel.'</h3></div>';
                echo '<div class="panel-body">File: '.$fileToDel.' not deleted !</div>';
                echo '</div>';
                echo '<p><a href="'.$listPage.'">Go back</a></p>';
            }
        }
        else{
            echo '<div class="panel panel-danger">';
            echo '<div class="panel-heading"><h3 class="panel-title">File to delete : '.$fileToDel.'</h3></div>';
            echo '<div class="panel-body">File: '.$fileToDel.' cannot be found !</div>';
            echo '</div>';
            echo '<p><a href="'.$listPage.'">Go back</a></p>';
        }
    }
     elseif(isset($_GET['fileToCopy']))
    {
        $fileToCopy = $_GET['fileToCopy'];
        if(file_exists($folder.$fileToCopy))
        {
            $copy = str_replace('.','_copy.',$fileToCopy);
           $copyresult =  copy($folder.$fileToCopy,$folder.$copy);
           
           if($copyresult){
               echo '<div class="panel panel-success">';
                echo '<div class="panel-heading"><h3 class="panel-title">File to Copy : '.$fileToCopy.'</h3></div>';
                echo '<div class="panel-body">File: '.$fileToCopy.' Copied !</div>';
                echo '</div>';
                echo '<p><a href="'.$listPage.'">Go back</a></p>';
           }else{
               echo '<div class="panel panel-danger">';
            echo '<div class="panel-heading"><h3 class="panel-title">File to Copy : '.$fileToCopy.'</h3></div>';
            echo '<div class="panel-body">File: '.$fileToCopy.' cannot be Copied !</div>';
            echo '</div>';
            echo '<p><a href="'.$listPage.'">Go back</a></p>';
           }
        }
        
    
    }
    elseif(!file_exists($folder))
    {
            echo '<div class="alert alert-danger">
                    <strong>Error : </strong> Destination folder doesn\'t exist or is not found here.
                </div>';
    }
    else { ?>
                <h2 class="text-center">List of available videos</h2>
                </div>
            </div>
            <?php if(!empty($message)):?>
                <div class="alert alert-info" role="alert"><?php echo $message;?></div>
            <?php endif;?>
             <div class="row">
                <div class="col-md-12">
                </div>
             </div>
            <div class="row">
                <div class="col-md-12">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th style="col-md-2">Thumbnail</th>
                        <th style="col-md-3">Title</th>
                        <th style="col-md-1">Size</th>
                         <th style="col-md-1">Copy</th>
                        <th style="col-md-1">Delete</th>
                        <th style="col-md-1">Watermark</th>
                     
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
<?php
    $file_array = glob($folder."*.{mp4,3gp,avi,mkv,flv}", GLOB_BRACE);
    usort($file_array, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
    $paging = true;
    $Paginator = new Paginator(new ArrayIterator($file_array));
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    echo "PAGE:".$page . ' of ' . $Paginator->getTotalPages();
    $results = $Paginator->render($page);
    $rand = rand(1,999);
        foreach($results as $file)
        {
            $filename = str_replace($folder, "", $file); // Need to fix accent problem with something like this : utf8_encode
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if($ext == 'jpeg' OR $ext == 'php' or $ext == 'postid') continue;
   
            if(!file_exists($folder.$filename.'.jpeg')){
                //$filenamethumb = str_replace(" ","%20",$filename);
                $fullpath = '"'.$folder.$filename.'"';
                $cmd = "$ffmpeg -y -i $fullpath -vf scale='$thumbs_size' $fullpath.jpeg";
                   if(DEBUG) echo '<br>' . $cmd . '<br>';
                    exec($cmd, $output, $ret);
                   if(DEBUG) echo $ret . '<br>';
            }
                
            if($Paginator->getCurrentPage() > 1){
                $page_string = 'page='. $Paginator->getCurrentPage() . '&';
            }
            else $page_string = '';
            echo "<tr>"; //New line
            echo '<td><img src="'.$folder.$filename.'.jpeg?i='.$rand.'" style="max-height:80px" /><br><a href="'.$listPage.'?'.$page_string.'imageToDelete='.$filename.'" class="btn btn-primary btn-xs" style="text-decoration:none">delete</a></td>';
            echo "<td height=\"30px\"><a href=\"videos/$filename?a=$rand\" target=\"_blank\">$filename</a><br> <a href =\"rename.php?fname=$filename\" class=\"btn btn-primary btn-xs\"> Rename</a></td>"; //1st col
            echo "<td><a href=\"#\" class=\"btn btn-primary\" style=\"text-decoration:none\">".human_filesize(filesize($folder.$filename))."</a></td>"; //2nd col
            echo "<td><a href=\"".$listPage."?".$page_string."fileToCopy=$filename\" class=\"btn btn-warning\" style=\"text-decoration:none\">Duplicate</a></td>"; //3rd col
			echo "<td><a href=\"".$listPage."?".$page_string."fileToDel=$filename\" class=\"btn btn-danger\" style=\"text-decoration:none\">Delete</a></td>"; //3rd col
            echo "<td><a href=\"cw.php?f=$filename?vmark=$rand\" class=\"btn btn-success\" style=\"text-decoration:none\">VMark It!</a></td>"; //3rd col
            
            
            
            echo "</tr>"; //End line
            }
        }
} 
    else {
    echo '<div class="alert alert-danger"><strong>Access denied :</strong> You must sign in before !</div>';
} ?>
                    </tr>
                </tbody>
            </table>
            <br/>
            <?php if(!isset($_GET['fileToDel'])) echo "<a href=".$mainPage.">Back to download page</a> <br><br><a href=".$listPage.">Back to Videos List</a>"; ?>
                </div>
            </div>
        </div><!-- End container -->
        <br>


        <footer class="footer">
            <div class="container">
                <div class="row">
       <?php
if(isset($_SESSION['logged']) && $_SESSION['logged'] == 1)
{
    if($paging){
        if ($Paginator->hasPreviousPage()) {
            $prev = $Paginator->getCurrentPage() - 1;
            echo '<div class="col-md-6">';
            if($prev != 1){
                echo '<a style="margin-top:5px" class="btn btn-info" href="list.php?page=1">First</a>&nbsp;';
            }
            echo '<a style="margin-top:5px" class="btn btn-info" href="list.php?page='.$prev.'">PREV</a>&nbsp;';
            if($prev > 1){
                $arr = array();
                $x = 0;
                for($i=$prev;$i>0;$i--){
                    if($i==1)break;
                    $x++;
                    $arr[] = '<a style="margin-top:5px" class="btn btn-info" href="list.php?page='.$i.'">'.$i.'</a>&nbsp;';
                     if($x == 6)break;
                }
                $rev = array_reverse($arr);
                echo implode('',$rev);
                unset($rev);
            }
            echo "</div>";
        }
        else  echo '<div class="col-md-6"></div>';
        if ($Paginator->hasNextPage()) {
            $total = $Paginator->getTotalPages();
            $next = $Paginator->getCurrentPage() + 1;
            echo '<div class="col-md-6">';

            echo '<span class="pull-right" style="float: right"><a style="margin-top:5px" class="btn btn-info" href="list.php?page='.$total.'">LAST</a></span>&nbsp;';
            echo '<span class="pull-right" style="float: right"><a style="margin-top:5px" class="btn btn-info" href="list.php?page='.$next.'">NEXT</a></span>&nbsp;';
            $x = 0;
            $arr = array();
            for($i=$next;$i < $total;++$i){
                if($i == $total) break;
                $x++;
                $arr[] = '<span class="pull-right" style="float: right"><a style="margin-top:5px" class="btn btn-info" href="list.php?page='.$i.'">'.$i.'</a></span>&nbsp;';
                if($x == 6)break;
            }
            $rev = array_reverse($arr);
            echo implode('',$rev);
            echo '</div>';
        }
        else  echo '<div class="col-md-6"></div>';
    }
}
?>
                </div>     
            </div>
        </footer>

<?php include 'footer.php'; ?>