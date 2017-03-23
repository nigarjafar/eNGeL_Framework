                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php
/**
 *
 */
class Img_lib
{

  private $image;
  /**
	 * Original image width
	 *
	 * @var int
	 */
  private $original_w;

  /**
	 * Original image height
	 *
	 * @var int
	 */
  private $original_h;

  /**
	 * Image format
	 *
	 * @var string
	 */
  private $extension;


  private $newImage;


  /**
   * New image height
   *
   * @var int
   */
  private $newHeight;


  /**
   * New image width
   *
   * @var int
   */
  private $newWidth;





  /**
	 * Class constructor requires to send through the image filename
	 *
	 * @param string $fileName - Filename  of the image you want to resize
	 */

  function __construct($fileName)
  {
    if (file_exists($fileName))
    {
      self::setImage($fileName);
    }
    else
    {
			throw new Exception('Image ' . $fileName . ' can not be found, try another image.');
		}
  }


  /**
	 * Set the image variable by using image create
	 *
	 * @param string $filename - The image filename
	 */

  public function setImage($fileName)
  {
    $file=getImagesize($fileName);
    $this->extension = strtolower($file['mime']);


    switch ($this->extension)
    {
      case 'image/jpg':
      case 'image/jpeg':
        $this->image=imagecreatefromjpeg($fileName);
      break;

      case 'image/png':
        $this->image=imagecreatefrompng($fileName);
      break;

      case 'image/gif':
        $this->image=imagecreatefromgif($fileName);
      break;

      default:
        throw new Exception("File is not an image, please use another file type.", 1);
      break;
    }

  }


  /**
   * get current image width
   *
   * @return integer
   */

  public function getToWidth()
  {
     return  $this->original_w  = imagesx($this->image);
  }


  /**
   * get current image height
   *
   * @return integer
   */
  public function getToHeight()
  {
    return  $this->original_h = imagesy($this->image);
  }

  /**
   * Calculate the current aspect ratio
   *
   * @return float
   */
  public function getRatio()
  {
      return $this->width / $this->height;
  }

  /**
	 * Resize the image to these set dimensions
	 *
	 * @param  int $width        	- Max width of the image
	 * @param  int $height       	- Max height of the image
	 * @param  string $resizeOption - Scale option for the image
	 *
	 * @return Save new image
	 */


  public function resize($width,$height,$resizeOption="default")
  {
    switch(strtolower($resizeOption))
  {
    case 'exact':
      $this->newWidth = $width;
      $this->newHeight = $height;
    break;

    case 'maxwidth':
      $this->newWidth  = $width;
      $this->newHeight = $this->resizeHeightByWidth($width);
    break;

    case 'maxheight':
      $this->newWidth  = $this->resizeWidthByHeight($height);
      $this->newHeight = $height;
    break;

    default:
      if($this->getToWidth() > $width || $this->getToHeight() > $height)
      {
        if ( $this->getToWidth() > $this->getToHeight() )
        {
             $this->newHeight = $this->resizeHeightByWidth($width);
             $this->newWidth  = $width;
        }
        else if( $this->getToWidth() < $this->getToHeight() )
        {
          $this->newWidth  = $this->resizeWidthByHeight($height);
          $this->newHeight = $height;
        }
        else
        {
          $this->newWidth = $width;
          $this->newHeight = $height;
        }
      }
     else
      {
          $this->newWidth = $width;
          $this->newHeight = $height;
      }
    break;
  }

    $this->newImage = imagecreatetruecolor($this->newWidth, $this->newHeight);
    imagecopyresampled(
      $this->newImage,
      $this->image, 0, 0, 0, 0,
      $this->newWidth,
      $this->newHeight,
      $this->getToWidth(),
      $this->getToHeight()
    );
  }



  /**
	 * Get the resized height from the width keeping the aspect ratio
	 *
	 * @param  int $width - Max image width
	 *
	 * @return Height keeping aspect ratio
	 */

   private function resizeHeightByWidth($width)
   {
  		return floor(($this->getToWidth() / $this->getToHeight()) * (int)$width);
   }



   /**
	 * Get the resized width from the height keeping the aspect ratio
	 *
	 * @param  int $height - Max image height
	 *
	 * @return Width keeping aspect ratio
	 */

	private function resizeWidthByHeight($height)
	{
		return floor(($this->getToWidth / $this->getToHeight) * (int)$height);
	}

  // private function getDimensions($width,$height)
  // {
  //
  //   if ($width == 0 && $height == 0)
  //   {
  //     return "error";
  //   }
  //
  //   if ($width  == 0)
  //   {
  //     $width=ceil($this->getToWidth()*$height/$this->getToHeight());
  //   }
  //
  //   elseif ($height == 0)
	// 	{
	// 		$height = ceil($width*$this->getToHeight()/$this->getToWidth());
  //
	// 	}
  //
  //   return $value=[$width,$height];
  //
  // }


  /**
	 * Save the image as the image type the original image was
	 *
	 * @param  String[type] $savePath     - The path to store the new image
	 * @param  string $imageQuality 	  - The qulaity level of image to create
	 *
	 * @return Saves the image
	 */

  public function saveImage($savePath, $imageQuality="100", $download = false)
  {
    switch($this->extension)
	    {
	        case 'image/jpg':
	        case 'image/jpeg':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_JPG)
              {
	                imagejpeg($this->newImage, $savePath, $imageQuality);
	            }
	        break;

	        case 'image/gif':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_GIF)
              {
	                imagegif($this->newImage, $savePath);
	            }
          break;

	        case 'image/png':
	            $invertScaleQuality = 9 - round(($imageQuality/100) * 9);

	            // Check PHP supports this file type
	            if (imagetypes() & IMG_PNG)
              {
	                imagepng($this->newImage, $savePath, $invertScaleQuality);
	            }
          break;
      }
          imagedestroy($this->newImage);
  }



  public function crop()
  {

  }


  public function rotate()
  {
    # code...
  }

  public function watermark()
  {
    # code...
  }
}



 ?>
