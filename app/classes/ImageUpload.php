<?php 

/**
***** IMAGE CLASS  **************
***created by Daniel Carvajal****
*	$img = new ImageUpload($file,$maxWidth, $minHeight);
*	$img->setDestinationFolder('destination/');
* the class has 2 methods to save images
* the first save image in original client size
*	$img->saveImage();
*the second save reduced image size wich argument is the reduced scale
*	$img->saveImageReducedSize(5);
*/


class ImageUpload extends Image
{
	private $file;
	private $originalWidth;
	private $originalHeight;
	private $maxWidth;
	private $maxHeight;
	private $imageForm;
	private $imgRealPath;
	private $clientOriginalName;
	private $tempImg;
	private $destinationFolder;

	private $standardImgName;

	public $finalImgName;

	public function __construct($file, $maxWidth = null, $maxHeight = null)
	{
		$this->file = $file;
		$this->maxWidth = $maxWidth;
		$this->maxHeight = $maxHeight;
		$this->imgRealPath = $this->file->getRealPath();
		$this->clientOriginalName = $this->file->getClientOriginalName();
		$this->setOriginalSizes();
		$this->tempImg = self::make($this->imgRealPath);

		$this->setStandardImgName();
	}

	public function setStandardImgName()
	{
		$this->standardImgName = strtolower(str_random(15));
	}

	public function getImageExtension()
	{
		return strtolower(pathinfo($this->clientOriginalName, PATHINFO_EXTENSION));
	}

	public function setDestinationFolder($destinationFolder)
	{
		$this->destinationFolder = public_path($destinationFolder);
	}

	public function setOriginalSizes()
	{
		$this->originalWidth = self::make($this->file)->width();
		$this->originalHeight = self::make($this->file)->height();
	}

	public function getImageForm()
	{
		if($this->originalWidth > $this->originalHeight)
			$this->imageForm = 'horizontal';
		elseif($this->originalWidth < $this->originalHeight)
			$this->imageForm = 'vertical';
		else
			$this->imageForm = 'squared';

		return $this->imageForm;
	}

	public function changeRepeatedImgName()
	{
		$extension = $this->getImageExtension();
		$img_name = $this->standardImgName;

		$img_complete_name = $img_name.'.'.$extension;

		$count = 0;
		while(file_exists($this->destinationFolder.$img_complete_name))
		{
			$count++;
			$img_complete_name = $img_name.'-r'.$count.'.'.$extension;
		}
		
		$this->finalImgName = $img_complete_name;
		return $img_complete_name;
	}


	public function saveImage()
	{
		$img = self::make($this->imgRealPath);
		$img->save($this->destinationFolder.$this->changeRepeatedImgName());
	}

	public function saveImageReducedSize($scale)
	{
		$img = self::make($this->imgRealPath);
		$this->resizeImage($img, $scale);
		$img->save($this->destinationFolder.$this->changeRepeatedImgName());
	}

	public function resizeImage($img, $scale)
	{
		if(($this->maxWidth != null) || ($this->maxHeight != null)){
			if( ($this->originalWidth > $this->maxWidth) || ($this->originalHeight > $this->maxHeight)){
				$img->resize($this->originalWidth/$scale, $this->originalHeight/$scale);
			}
		}	
	}

}

?>
