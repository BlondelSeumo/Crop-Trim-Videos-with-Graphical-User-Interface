<?php
require_once("config.php"); 
function getCurl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function scaleFile($options,$name){
	if(!is_dir($options['ffmpeg_tmp_path'])) mkdir($options['ffmpeg_tmp_path'],0777,true);
	$scale = isset($options['scale'])?$options['scale']:320;

	//$ext = @end(explode('.',$name));
	$ext =".mp4";
	$ffmpeg_tmp_name =  $options['ffmpeg_tmp_path'] . '/' . time() . "." . $ext;
	$cmd = $options['ffmpeg_path'] . ' -y -i "' . $options['files_path'] . $name . '" -vf scale="'.$scale .':-1" '. $ffmpeg_tmp_name . ' 2>&1';
    if(DEBUG) echo $cmd . '<br/>';
	exec($cmd,$output,$ret);
    if(DEBUG) {
        foreach($output as $out){
            echo $out . '<br/>';
        }
    }
	if(file_exists($ffmpeg_tmp_name)){
		rename($ffmpeg_tmp_name,$options['files_path'] . $name);
		return true;
	}
	return false;
}


// Test if destination folder exists
function destFolderExists($destFolder)
{
    if(!file_exists($destFolder))
    {
        echo '<div class="alert alert-danger">
                <strong>Error : </strong> Destination folder doesn\'t exist or is not found here. 
            </div>';
    }
}

// Convert bytes to a more user-friendly value
function human_filesize($bytes, $decimals = 0)
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

#paginations 
class Paginator extends LimitIterator {
	protected $_it;
	protected $_currentPage;
	protected $_limit;
	protected $_count;
	protected $_totalPages;
	public function __construct(ArrayIterator $it, $page = 1, $limit = 10){
		$this->arr = $it;
		$this->_count = $it->count();
		$this->setCurrentPage($page);
		$this->setItemsPerPage($limit);
	}
	public function setItemsPerPage($count = 20){
		$this->_itemsPerPage = (int) $count;
		$this->_totalPages = ($this->_count > $this->_itemsPerPage) ? ceil($this->_count / $this->_itemsPerPage) : 1;
	}
	public function setCurrentPage($page = 1){$this->_currentPage = (int) $page;}
	public function getCurrentPage(){return $this->_currentPage;}
    public function getTotalPages(){return $this->_totalPages;}
	public function hasNextPage(){return $this->_currentPage < $this->_totalPages;}
	public function hasPreviousPage(){return $this->_currentPage > 1;}
	public function render($page = NULL, $limit = NULL){
		if (!empty($page)) {$this->setCurrentPage($page);}
		if (!empty($limit)) {$this->setItemsPerPage($limit);}
		if ($page > 0) $page -= 1;
		$offset = $page * $this->_itemsPerPage;
		$limiter = new LimitIterator($this->arr, $offset, $this->_itemsPerPage);
        return $limiter;
	}
}
?>
