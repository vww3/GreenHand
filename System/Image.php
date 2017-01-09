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
     * outputFile
     * 
     * @var mixed
     * @access public
     */
    public $outputFile;

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
     * @param string $file
     * @return void
     */
    public function __construct(string $file)
    {
        $this->_file = $file;
        $this->_name = basename($file);
                
        $infos = getimagesize($this->_file);
        
        $this->_width         = $infos[0];
        $this->_height         = $infos[1];
        $this->_type         = $infos['mime'];
        $this->_bits         = $infos['bits'];
        $this->_ratio         = $this->_width / $this->_height;
        $this->outputFile     = $this->_file;
                
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
     * @param int $width
     * @param int $height
     * @param int $originalWidth
     * @param int $originalHeight
     * @param int $shiftX
     * @param int $shiftY
     * @return void
     */
    private function _generateImage(
        int $width,
        int $height,
        int $originalWidth,
        int $originalHeight,
        int $shiftX,
        int $shiftY
    ) {
        $extension = substr(strrchr($this->outputFile, '.'), 1);
                
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
                imagegif($image, $this->outputFile, $this->qualityOfOutput);
                break;
            case 'png':
                imagepng($image, $this->outputFile, round( $this->qualityOfOutput * 9 / 100 ));
                break;
            case 'jpg':            
            case 'jpeg':
                imagejpeg($image, $this->outputFile, $this->qualityOfOutput);
                break;
            default:
                die('Conversion impossible : "'.$this->outputFile.'" ne comporte pas une extension valide...');
        }
        
        return new Image($this->outputFile);
    }

    /**
     * trim function.
     * 
     * @access public
     * @param int $width
     * @param int $height
     * @param int $shiftX (default: 0)
     * @param int $shiftY (default: 0)
     * @return void
     */
    public function trim(
        int $width,
        int $height,
        int $shiftX = 0,
        int $shiftY = 0
    ) {    
        return $this->_generateImage($width, $height, $width, $height, $shiftX, $shiftY);
    }

    /**
     * resize function.
     * 
     * @access public
     * @param int $width (default: 0)
     * @param int $height (default: 0)
     * @return void
     */
    public function resize($width = 0, $height = 0)
    {    
        $width = $this->_width;
        $height = $this->_height;
        
        if ($width AND $height == 0)
            $height = $width / $this->_ratio;
        elseif ($width == 0 AND $height)
            $width = $height * $this->_ratio;
        
        return $this->_generateImage($width, $height, $this->_width, $this->_height, 0, 0);
    }

    /**
     * createThumb function.
     * 
     * @access public
     * @param int $width
     * @param int $height
     * @return void
     */
    public function createThumb(int $width, int $height)
    {    
        $ratio = $width / $height;
                
        if ($this->_ratio > $ratio) {
            $thumb = $this->resize(null, $height);
            $thumb->trim($width, $height, $thumb->width/2 - $width/2, 0);            
        } else {
            $thumb = $this->resize($width, null);
            $thumb->trim($width, $height, 0, $thumb->height/2 - $height/2);
        }
        
        return $thumb;
    }
}
