<?php
// namespace Eventviva;
// use \Exception;
/**
 * PHP class to resize and scale images
 */
class image
{
    const CROPTOP = 1;
    const CROPCENTRE = 2;
    const CROPCENTER = 2;
    const CROPBOTTOM = 3;
    const CROPLEFT = 4;
    const CROPRIGHT = 5;
    public $quality_jpg = 85;
    public $quality_png = 6;
    public $quality_truecolor = TRUE;
    public $interlace = 1;
    public $source_type;
    protected $image;
    protected $original_w;
    protected $original_h;
    protected $dest_x = 0;
    protected $dest_y = 0;
    protected $pos_x;
    protected $pos_y;
    protected $newWidth;
    protected $newHeight;
    protected $source_w;
    protected $source_h;


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

      public function setImage($fileName)
      {
        $file=getImagesize($fileName);
        $this->extension =$file['mime'];


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

    public function save($savePath, $imageQuality = "100", $permissions = null)
    {

        $dest_image = imagecreatetruecolor($this->newWidth, $this->newHeight);
        // $this->newImage = imagecreatetruecolor($this->newWidth, $this->newHeight);

        // imageinterlace($this->newImage, $this->interlace);
        imagecopyresampled(
            $dest_image,
            $this->image,
            $this->dest_x,
            $this->dest_y,
            $this->pos_x,
            $this->pos_y,
            $this->newWidth,
            $this->newHeight,
            $this->source_w,
            $this->source_h
        );
        switch ($this->extension) {
          case 'image/jpg':
	        case 'image/jpeg':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_JPG)
              {
	                imagejpeg($dest_image, $savePath, $imageQuality);
	            }
	        break;

	        case 'image/gif':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_GIF)
              {
	                imagegif($dest_image, $savePath);
	            }
          break;

	        case 'image/png':
	            $invertScaleQuality = 9 - round(($imageQuality/100) * 9);

	            // Check PHP supports this file type
	            if (imagetypes() & IMG_PNG)
              {
	                imagepng($dest_image, $savePath, $invertScaleQuality);
	            }
          break;
        }
        if ($permissions) {
            chmod($filename, $permissions);
        }

        imagedestroy($dest_image);
        echo "yes save";
    }


    public function freecrop($width, $height, $pos_x = false, $pos_y = false)
    {
        $this->pos_x = $pos_x;
        $this->pos_y = $pos_y;
        if($width > $this->getWidth() - $pos_x){
          $this->source_w = $this->getWidth() - $pos_x;
        } else {
          $this->source_w = $width;
        }
        if($height > $this->getHeight() - $pos_y){
          $this->source_h = $this->getHeight() - $pos_y;
        } else {
          $this->source_h = $height;
        }
        $this->newWidth = $width;
        $this->newHeight = $height;
        return $this;
    }
    /**
     * Gets source width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->original_w=imagesx($this->image);
    }
    /**
     * Gets source height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->original_h=imagesy($this->image);
    }


}
