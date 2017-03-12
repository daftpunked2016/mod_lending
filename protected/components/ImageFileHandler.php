<?php
class ImageFileHandler
{
	//UPLOAD TYPES
	const DOCUMENT_FILES = 'D';

	private static $allowed_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp');

	private static $file_size_limit = 5000000; //5MB
	/**
	* @var array ($_FILES) / string (base64 data)
	*
	*stores Image file properties that will be uploaded
	*/
	public $img_file;

	/**
	* @var string 
	*
	*stores the new filename of the file that will be generated
	*/
	public $new_filename;

	/**
	* @var string
	*
	* file name of the image
	*/
	private $filename;

	/**
	* @var string
	*
	* file extension of the file
	*
	* Allowed file type ext (.jpeg/.jpg, .png, .bmp)
	*/
	public $file_ext;

	/**
	* contains the target path for the file
	*/
	private $target_path;

	/**
	* @var string
	* for file relation and type
	*/
	private $type;

	/**
	* @var int
	*/
	public $_id;

	/**
	* @var int
	*/
	public $account_id;

	/**
	* @var array
	*
	* stores the transaction errors when saving the file
	*/
	public $_errors;

	/**
	* @var timestamp
	*/
	private $date;

	/**
	* @var string
	*
	* contains decoded base64 image file
	*
	*/
	private $decoded_img;

	/**
	* @var Fileupload
	*
	*/
	public $fileupload;

	/**
	* @var Filerelation
	*
	*/
	public $filerelation;

	/**
	* contains hashed random key
	*/
	private $key;


	public function __construct($img_file, $type, $account_id)
	{	
		$this->img_file = $img_file;
		$this->type = $type;
		$this->account_id = $account_id;
		$this->date = time();
		$this->setPropertyValue();
		$this->setModelData();
	}

	private function setPropertyValue()
	{	
		if(is_array($this->img_file)) {
			$this->filename = $this->img_file['name'];
			$this->file_ext = pathinfo($this->filename, PATHINFO_EXTENSION);
		} else {
			$encoded = $this->img_file;
		    //explode at ',' - the last part should be the encoded image now
		    $exp = explode(',', $encoded);
		    //we just get the last element with array_pop
		    $base64 = array_pop($exp);
		    //decode the image and finally save it
		    $this->decoded_img = base64_decode($base64);
		    //get extension
		    $exp = explode(';', $encoded);
		    $exp = explode(':', $exp[0]);
		    $exp = explode('/' , array_pop($exp));
		    
		    $this->file_ext = array_pop($exp);
		    $this->filename = time().'.'.$this->file_ext;
		}
		
		$this->key = $this->generateHKey();
		$this->new_filename = $this->generateNewFN();
		$this->target_path = $this->generatePath();
	}

	private function generateHkey()
	{
		$key = mt_rand(100000,999999); 
		return md5($key);
	}

	private function generateNewFN()
	{
		return 'LD'.$this->date.'-'.$this->key.md5($this->account_id).$this->type.md5($this->filename).'.'.$this->file_ext;
	}

	/**
	* @param criteria_id var int
	**/
	private function generatePath()
	{
		$path = 'uploads/';

		switch($this->type)
		{
			case self::DOCUMENT_FILES: //
				$path.="regfiles/";
				break;
			default:
				$path.="regfiles/";
		}

		$path.= $this->account_id.'/';
		$this->checkPath($path);

		return $path;
	}

	// Create new directory structure if file path doesn't exist
	private function checkPath($path)
	{	
		if(!is_dir($path))
			mkdir($path);
	}

	private function setModelData()
	{
		$fileupload = new Fileuploads;

		//set AwardFileupload prop.
		$fileupload->account_id = $this->account_id;
		$fileupload->file_extension = $this->file_ext;
		$fileupload->filename = $this->new_filename;
		$fileupload->original_filename = md5($this->filename);
		$fileupload->type = $this->type;
		$this->fileupload = $fileupload;
	}

	public function saveUpload($transaction = null)
	{
		$fileupload = $this->fileupload;
		//upload and save file data

		try {
			if($this->moveFileToServer() != false) { //UPLOAD FILE TO SERVER
				if($fileupload->save()) {
					$this->_id = $fileupload->id;
					
					if($transaction != null)
						$transaction->commit();

					return true;
				} else {
					$this->_errors = $fileupload->getErrors();
				}
			} else {
				$this->_errors = array('error'=>'File cannot be moved!');
			}
		} catch (Exception $e) {
			$this->_errors = $e; 
		}

		if($transaction != null)
				$transaction->rollback();

		return false;
	}

	private function moveFileToServer()
	{
		if(is_array($this->img_file))
			$upload = move_uploaded_file($this->img_file['tmp_name'], $this->target_path.$this->new_filename);
		else
			$upload = file_put_contents($this->target_path.$this->new_filename, $this->decoded_img);

		return $upload;
	}

	public function getFileSize()
	{
		if(is_array($this->img_file))
			return $this->img_file['size'];
		else
			return strlen($this->decoded_img);
	}

	private function validateFile()
	{
		if (in_array(strtolower($this->file_ext), $this::$allowed_ext)) {
			if($this->getFileSize() <= $this::$file_size_limit) {
				return true;
			} else {
				$this->_errors = "File size exceeds the maximum file size limit.";
			}
		} else {
			$this->_errors = "File format not allowed/supported for file upload.";
		}

		return false;
	}

	public function addAllowedExt($ext)
	{
		array_push($this::$allowed_ext, $ext);
	}
}