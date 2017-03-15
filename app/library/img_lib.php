<?php
/**
 *
 */
class Img_lib
{
    private $config;
    private $image;
    private $original_w;
    private $original_h;
    private $original_type;
    private $imageResized;
    // public $test;
    function __construct($config=[])
    {
        // $this->config=$config;
        // $imageInfo=getimagesize($this->config['source_image']);
        //
        // if (!$imageInfo) {
        //    throw new Exception("File not founded");
        // }
        //
        // list(
        //   $this->original_w,
        //   $this->original_h,
        //   $this->original_type
        //   )=$this->original_type;
        $this->config=$config;
        $this->image=self::get_image_properties($this->config['source_image']);
        //   $this->test=(int)$this->config['width'];
        // return $this->test;
    }
    public function get_image_properties($file)
    {
        $extension = strtolower(strrchr($file, '.'));
        // check file Type
        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                $cr_img=imagecreatefromjpeg($file);
                break;
            case '.png':
                $cr_img=imagecreatefrompng($file);
                break;
            case '.gif':
                $cr_img=imagecreatefromgif($file);
                break;
            default:
                $cr_img=false;
                break;
        }
        return $cr_img;
    }
    public function getToWidth()
    {
        $this->original_w  = imagesx($this->image);
        return $this->original_w;
    }
    public function getToHeight()
    {
        $this->original_h = imagesy($this->image);
        return $this->original_h;
    }
    public function resize()
    {
        $optionArray = $this->getDimensions($this->config['width'], $this ->config['height']);
        $optimalWidth  = $optionArray[0];
        $optimalHeight = $optionArray[1];
        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->getToWidth(), $this->getToHeight());
        //  return $this->image;
    }
    public function getDimensions()
    {
        $value=[$this->config['width'], $this ->config['height']];
        if (! is_array($value)) {
            return;
        }
        $width=(int)$value[0];
        $height=(int)$value[1];
        if ($width == 0 && $height == 0)
        {
            return "error";
        }
        if ($width  == 0)
        {
            $width=ceil($this->getToWidth()*$height/$this->getToHeight());
        }
        elseif ($height == 0)
        {
            $height = ceil($width*$this->getToHeight()/$this->getToWidth());
        }
        return $value=[$width,$height];
    }
    public function crop()
    {
        # code...
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