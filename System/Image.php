<?php
namespace System;

/**
 * Image class.
 */
class Image
{    
    /**
     * _file
     * 
     * @var mixed
     * @access private
     */
    private $_file;

    /**
     * _name
     * 
     * @var mixed
     * @access private
     */
    private $_name;

    /**
     * _image
     * 
     * @var mixed
     * @access private
     */
    private $_image;

    /**
     * _width
     * 
     * @var mixed
     * @access private
     */
    private $_width;

    /**
     * _height
     * 
     * @var mixed
     * @access private
     */
    private $_height;

    /**
     * _type
     * 
     * @var mixed
     * @access private
     */
    private $_type;

    /**
     * _bits
     * 
     * @var mixed
     * @access private
     */
    private $_bits;

    /**
     * _ratio
     * 
     * @var mixed
     * @access private
     */
    private $_ratio;
    
    /**
     * qualite
     * 
     * (default value: 100)
     * 
     * @var int
     * @access public
     */
    public $qualityOfOutput = 100;

    /**
     * __construct function.
     * 
     * @access public
     * @param $file
     * @return void
     */
    public function __construct($file)
    {
        $this->_file = $file;
        $this->_name = basename($file);
                
        $infos = getimagesize($this->_file);
        
        $this->_width         = $infos[0];
        $this->_height         = $infos[1];
        $this->_type         = $infos['mime'];
        $this->_bits         = $infos['bits'];
        $this->_ratio         = $this->_width / $this->_height;
                
        switch ($this->_type) {
            case 'image/gif':
                $this->_image = imagecreatefromgif($this->_file);
                break;
            case 'image/jpeg':
                $this->_image = imagecreatefromjpeg($this->_file);
                break;
            case 'image/png':
                $this->_image = imagecreatefrompng($this->_file);
                break;
            default:
                die('Image non supportée...');            
        }
    }

    /**
     * _generateImage function.
     * 
     * @access private
     * @param $width
     * @param $height
     * @param $originalWidth
     * @param $originalHeight
     * @param $shiftX
     * @param $shiftY
     * @return void
     */
    private function _generateImage(
        $width,
        $height,
        $originalWidth,
        $originalHeight,
        $shiftX,
        $shiftY,
        $output = null
    ) {
	    if(is_null($output))
	    	$output = $this->_file;
	    	
        $extension = substr(strrchr($output, '.'), 1);
                
        $image = imagecreatetruecolor($width, $height);
        
        imagealphablending($image,false);
        imagesavealpha($image,true);
        imagecopyresampled(
            $image, $this->_image,
            0, 0,
            $shiftX, $shiftY,
            $width, $height,
            $originalWidth, $originalHeight
        );
                
        switch($extension) {
            case 'gif':
                imagegif($image, $output, $this->qualityOfOutput);
                break;
            case 'png':
                imagepng($image, $output, round( $this->qualityOfOutput * 9 / 100 ));
                break;
            case 'jpg':            
            case 'jpeg':
                imagejpeg($image, $output, $this->qualityOfOutput);
                break;
            default:
                die('Conversion impossible : "'.$output.'" ne comporte pas une extension valide...');
        }
        
        return new Image($output);
    }

    /**
     * trim function.
     * 
     * @access public
     * @param $width
     * @param $height
     * @param $shiftX (default: 0)
     * @param $shiftY (default: 0)
     * @return void
     */
    public function trim(
        $width,
        $height,
        $shiftX = 0,
        $shiftY = 0,
        $output = null
    ) {    
        return $this->_generateImage($width, $height, $width, $height, $shiftX, $shiftY, $output);
    }

    /**
     * resize function.
     * 
     * @access public
     * @param $width (default: null)
     * @param $height (default: null)
     * @return void
     */
    public function resize($width = null, $height = null, $output = null)
    {           
        if ($width AND is_null($height)) {
	        $height = $width / $this->_ratio;
        } elseif (is_null($width) AND $height) {
        	$width = $height * $this->_ratio;
        }
        
        return $this->_generateImage($width, $height, $this->_width, $this->_height, 0, 0, $output);
    }

    /**
     * createThumb function.
     * 
     * @access public
     * @param $width
     * @param $height
     * @return void
     */
    public function createThumb($width, $height, $output = null)
    {    
        $ratio = $width / $height;
                
        if ($this->_ratio > $ratio) {
            $thumb = $this->resize(null, $height, $output);
            $thumb->trim($width, $height, $thumb->width()/2 - $width/2, 0, $output);            
        } else {
            $thumb = $this->resize($width, null);
            $thumb->trim($width, $height, 0, $thumb->height()/2 - $height/2, $output);
        }
        
        return $thumb;
    }
    
    public function width()
    {
	    return $this->_width;
    }
    
    public function height()
    {
	    return $this->_height;
    }
}
