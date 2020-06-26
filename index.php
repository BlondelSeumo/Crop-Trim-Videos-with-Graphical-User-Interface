<?php include 'header.php'; ?>
        <div class="container">
         <h1>VMARK Uploader</h1>
<?php
    if(isset($_GET['url']) && !empty($_GET['url']) && $_SESSION['logged'] == 1)
    {
        $url = $_GET['url'];
        $name = $_GET['filename'];
        $name = str_replace(' ','-',$name);
	
        if($name){
        $filename = $name;
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $filename = $folder.$filename.'.'.$ext;
        }
        else {
        $file = pathinfo($url);
        $file = $file['filename'];
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $filename = $file.'.'.$ext;
        $filename = $folder.$filename;
        }
       
      
       //$transload = copy($url,$filename);
       
        $ch = curl_init($url);
        $fp = fopen($filename, 'wb');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RANGE,"0-250000000");
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
       
       if(file_exists($filename)) {
            echo "Transload Complete $filename <a href='list.php'>View File </a>";
       }else {
           echo "Error : File Not Transloaded , Please Check Supported File Type , Disk, Permissions";
       }
       
       
       
    }
    elseif(isset($_SESSION['logged']) && $_SESSION['logged'] == 1)
    { ?>
             <div class="row">
                <div class="col-lg-6">
                    <form class="form-horizontal" action="<?php echo $mainPage; ?>">
                <fieldset>
                  <div class="form-group">
                    <label for="url">Upload Via Remote URL</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Paste Direct Video Links Here" required>
                  </div>
                  <div class="form-group">
                    <label for="filename">Filename</label>
                    <input type="text" class="form-control" id="filename" name="filename" placeholder="Custom File Name If Any" spellcheck="true">
                  </div>
                   
                  <button type="submit" class="btn btn-default">Transload</button>
                  </fieldset>
            </form>
                </div>
                 <div class="col-lg-6">
                      <fieldset>
                     <form action="upload.php" enctype="multipart/form-data" method="post">
                          <div class="form-group">
                        <label for="filename">Upload From Device</label>
                        <input type="text" class="form-control" id="newname" name="newname" placeholder="Custom File Name If Any" spellcheck="true">
                        </div>
                         <div class="form-group">
                             <label for="filename">Select File</label>
                        <input id="file" class="form-control" name="file" type="file" /><br>
                        </div>
                        <input name="submit" type="submit" value="Upload" class="btn btn-default" />
                        
                         </fieldset>
                    </form>
                 </div>
                </div>
            <br>

 

            <?php destFolderExists($folder);?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3 class="panel-title">Your Server Info</h3></div>
                        <div class="panel-body">
                            <p>Free space : <?php if(file_exists($folder)){ echo human_filesize(disk_free_space($folder),1)."o";} else {echo "Folder not found";} ?></b></p>
                            <p>Download folder : <?php echo $folder ;?></p>
                             <p>Supported File Type : .mp4 .mkv .flv</p>
                             <p><?php
                        echo 'Max Upload Size Sets In config.php Is :';
                        echo human_filesize($maxfilezie);
                        echo '<br>Your Server upload_max_filesize Is : ';
                        echo ini_get('upload_max_filesize'); 
                        echo '<br>Your Server post_max_size Is : ';
                        echo ini_get('post_max_size'); 
                        echo '<br> Your Server max_input_time Is : ';
                        echo ini_get('max_input_time'); 
                        echo '<br><br> FFMPEG IS INSTALLED ? :';
                 
                        $ffmpegget = trim(shell_exec('which '.$ffmpeg.'')); // or better yet:
                        $ffmpegget = trim(shell_exec('type -P '.$ffmpeg.''));

                            if (empty($ffmpegget))
                                {
                                    echo 'NO';
                                    echo'<div class="panel panel-danger"> FFMPEG IS NOT INSTALLED OR CONFIGURED PROPERLY';
                                 //die('ffmpeg not available');
                                } else {
                                 echo "YES Insalled <br> Path is $ffmpegget";
                                }

                        ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3 class="panel-title">Help</h3></div>
                        <div class="panel-body">
                            <p><b>How does it work ?</b></p>
                            <p>Simply paste your video link or Upload Video From Computer, After you can Watermark, Crop , Trim Your Videos.</p>
                            <p><b>How To Watermark,Crop,Trim ?</b></p>
                            <p>Check The <a href="doc.html" target="_blank">Documentation here</a></p>
                            <p><b>Need More Help / Customization?</b></p>
                            <p>If you want to do something more with this script, Our team is happy to help you. Contact us At v4webtech@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
<?php
    }
    else{ ?>
        <form class="form-horizontal" action="<?php echo $mainPage; ?>" method="POST" >
            <fieldset>
                <legend>You need to login first</legend>
                <div class="form-group">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <input class="form-control" id="passwd" name="passwd" placeholder="Password" type="password">
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            </fieldset>
        </form>
<?php
        }
    if(isset($_SESSION['logged']) && $_SESSION['logged'] == 1) echo '<p><a href="index.php?logout=1">Logout</a></p>';
?>
        </div><!-- End container -->
        <footer>
        </footer>
<?php include 'footer.php'; ?>