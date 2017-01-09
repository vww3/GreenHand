<?php
namespace System\Helper;

/**
 * Form class.
 */
class Form
{
    /**
     * _iteration
     * 
     * (default value: 0)
     * 
     * @var int
     * @access private
     * @static
     */
    private static $_iteration = 0;
    
    /**
     * _name
     * 
     * @var mixed
     * @access private
     */
    private $_name;

    /**
     * _errors
     * 
     * (default value: [])
     * 
     * @var array
     * @access private
     */
    private $_errors = [];

    /**
     * _datas
     * 
     * (default value: [])
     * 
     * @var array
     * @access private
     */
    private $_datas = [];

    /**
     * __construct function.
     * 
     * @access public
     * @param $settings (default: [])
     * @return void
     */
    public function __construct($settings = [])
    {
        self::$_iteration++; 
               
        $this->_name = empty($settings['name']) ? 'form'.self::$_iteration : $settings['name'];
        
        if ($this->posted())
            $this->_datas = $_POST[$this->_name];
        elseif (!empty($settings['datas']))
            $this->_datas = (array)$settings['datas'];
        else
            $this->_datas = [];
    }

    /**
     * verify function.
     * 
     * Use a test in order to verify if there is an error in the form
     *
     * @access public
     * @param $test
     * @param $message
     * @return void
     */
    public function verify($test, $message)
    {                
        if ($test)
            $this->_errors[] = $message;
    }
    
    /**
     * noErrors function.
     * 
     * Say if the form doesn't have error
     *
     * @access public
     * @param $test
     * @param $message
     * @return bool
     */
    public function noErrors() {
	    return empty($this->_errors);
    }

    /**
     * errors function.
     * 
     * @access public
     * @return array
     */
    public function errors()
    {
        return $this->_errors;        
    }

    /**
     * reset function.
     * 
     * @access public
     * @return void
     */
    public function reset()
    {
        $this->_datas = [];
        $this->_errors = [];     
    }

    /**
     * posted function.
     * 
     * @access public
     * @return bool
     */
    public function posted()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST[$this->_name]);        
    }

    /**
     * datas function.
     * 
     * @access public
     * @return array
     */
    public function datas()
    {
	    $keys = func_get_args();
	    
	    if(empty($keys))
	    	return $this->_datas;
	    elseif (sizeof($keys) == 1)
	    	return $this->_datas[$keys[0]];
	    else {
			$datas = [];
			
			foreach($keys as $key)
				$datas[$key] = $this->_datas[$key];
			
			return $datas; 
	    }
    }
    
    /**
     * _id attribute generator function.
     * 
     * @access private
     * @param $name
     * @return string
     */
    private function _id($name)
    {
        return $this->_name.'-'.str_replace(['[', ']', ' '], '', $name);        
    }
    
    /**
     * _attributes inline generator function.
     * 
     * @access private
     * @param $liste
     * @return string
     */
    private function _attributes($liste)
    {
	    $attributes = [];
	                 
        foreach ($liste as $attribute => $value) {
            
            if($attribute == null)
            	$attribute = $value;
            
            if ($attribute == 'name')             
                if (substr($value, -2) == '[]')
                	$attributes[] = 'name="'.$this->_name.'['.substr($value, 0, -2).'][]"';
                else
                    $attributes[] = 'name="'.$this->_name.'['.$value.']"';
            else
                $attributes[] = $attribute.'="'.$value.'"';
                    
        }
        return implode(' ', $attributes);
    }

    /**
     * label function.
     * 
     * @access public
     * @param $id
     * @param $value
     * @return string
     */
    public function label($id, $value = '')
    {
        if ($value != '')
            return '<label for="'.$id.'">'.$value.'</label>';
    }
    
    /**
     * field function.
     * 
     * @access public
     * @param $type
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function field($type, $name, $options = [])
    {
        $id = $this->_id($name);
        
        if ($name != null) {
            if (!isset($options['id']))
                $options['id'] = $id;
            if (!isset($options['name']))
                $options['name'] = $name;
        }        
            
        if (!isset($options['value']) AND isset($this->_datas[$name]))
            $options['value'] = $this->_datas[$name];
        
        ob_start();
        
        if (isset($options['label'])) {
	        echo $this->label($id, $options['label']);
            unset($options['label']);
        }
        
        echo "<input type='$type' {$this->_attributes($options)}>";
        
        return ob_get_clean();
    }

    /**
     * text function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function text($name, $options = [])
    {
        return $this->field('text', $name, $options);        
    }

    /**
     * password function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function password($name, $options = [])
    {
        return $this->field('password', $name, $options);        
    }

    /**
     * number function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function number($name, $options = [])
    {
        return $this->field('number', $name, $options);        
    }

    /**
     * time function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function time($name, $options = [])
    {
        return $this->field('time', $name, $options);        
    }

    /**
     * email function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function email($name, $options = [])
    {
        return $this->field('email', $name, $options);        
    }

    /**
     * file function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function file($name, $options = [])
    {
        return $this->field('file', $name, $options);        
    }

    /**
     * sender function.
     * 
     * @access public
     * @param $value (default: 'Envoyer')
     * @param $name (default: null)
     * @param $options (default: [])
     * @return string
     */
    public function sender($value = 'Envoyer', $name = '', $options = [])
    {
        $options['value'] = $value;
        
        return $this->field('submit', $name, $options);        
    }

    /**
     * eraser function.
     * 
     * @access public
     * @param $value (default: 'Effacer')
     * @param $name (default: null)
     * @param $options (default: [])
     * @return string
     */
    public function eraser($value = 'Effacer', $name = '', $options = [])
    {
        $options['value'] = $value;
        
        return $this->field('reset', $name, $options);
    }

    /**
     * textarea function.
     * 
     * @access public
     * @param $name
     * @param $options (default: [])
     * @return string
     */
    public function textarea($name, $options = [])
    {
        $id = $this->_id($name);
        $value = isset($this->_datas[$name]) ? $this->_datas[$name] : "";
        
        if (!isset($options['id']))
            $options['id'] = $id;
        if (!isset($options['name']))
            $options['name'] = $name;
        
        ob_start();    
        
        if (isset($options['label'])) {
	        echo $this->label($id, $options['label']);
	        unset($options['label']);
        }
                                                                            
        echo "<textarea {$this->_attributes($options)}>$value</textarea>";
        
        return ob_get_clean();
    }

    /**
     * selection function.
     * 
     * @access public
     * @param $name
     * @param $options
     * @param $options (default: [])
     * @return string
     */
    public function selection($name, $values, $options = [])
    {
        $id = $this->_id($name);
        
        if (!isset($options['id']))
            $options['id'] = $id;
        if (!isset($options['name']))
            $options['name'] = $name;
        
        ob_start();
        
        if (isset($options['label'])) {
	        echo $this->label($id, $options['label']);
	        unset($options['label']);
        }
        
        echo "<select {$this->_attributes($options)}>";
        
        foreach ($values as $value => $option) {
            echo "<option value='$value'";
            
            if (isset($this->_datas[$name]) AND $this->_datas[$name] == $value)
                echo " selected='selected'";
            
            echo ">$option</option>";            
        }
        
        echo '</select>';

        return ob_get_clean();    
    }

    /**
     * checkbox function.
     * 
     * @access public
     * @param $name
     * @param $label
     * @param $value (default: '')
     * @param $options (default: [])
     * @return string
     */
    public function checkbox($name, $label, $value = '', $options = [])
    {
        $id = $this->_id($name.'_'.$value);
        
        if (!isset($options['id']))
            $options['id'] = $id;
        if (!isset($options['name']))
            $options['name'] = $name;
        if ($value != '')
            $options['value'] = $value;
        if (isset($this->_datas[$name]) AND $this->_datas[$name])
            $options['checked'] = 'checked';
                  
        ob_start();
        
        echo $this->label($id, $label);
        echo "<input type='checkbox' {$this->_attributes($options)}>";
        
        return ob_get_clean(); 
    }

    /**
     * radio function.
     * 
     * @access public
     * @param $name
     * @param $label
     * @param $value (default: '')
     * @param $options (default: [])
     * @return void
     */
    public function radio($name, $label, $value = '', $options = [])
    {
        if ($value == '')
        	$value = $label;
        
        $id = $this->_id($name.'_'.$value);
        
        if (!isset($options['id']))
            $options['id'] = $id;
        if (!isset($options['name']))
            $options['name'] = $name;
        if (!isset($options['value']))
            $options['value'] = $value;
        if (isset($this->_datas[$name]) AND $this->_datas[$name] == $value)
            $options['checked'] = 'checked';
        
        ob_start();
        
        echo $this->label($id, $label);
        echo "<input type='radio' {$this->_attributes($options)}>";
        
        return ob_get_clean(); 
    }

    /**
     * downloadable function.
     * 
     * @access public
     * @param $key
     * @return bool
     */
    public function downloadable($key)
    {
        if (empty($_FILES))
            return false;
            
        $error = $_FILES[$this->_name]['error'][$key];
        
        return is_array($error) ? in_array(0, $error) : $error == 0;
    }

    /**
     * fileName function.
     * 
     * @access public
     * @param $key
     * @return string
     */
    public function fileName($key)
    {
        return $_FILES[$this->_name]['name'][$key];        
    }

    /**
     * fileSize function.
     * 
     * @access public
     * @param $key
     * @return int
     */
    public function fileSize($key)
    {
        return $_FILES[$this->_name]['size'][$key];        
    }

    /**
     * fileType function.
     * 
     * @access public
     * @param $key
     * @return string
     */
    public function fileType($key)
    {
        return $_FILES[$this->_name]['type'][$key];        
    }

    /**
     * download function.
     * 
     * @access public
     * @param $key
     * @param $destination
     * @param $name (default: '')
     * @return void
     */
    public function download($key, $destination, $name = '')
    {        
        if ($name == '')
            $name = $this->fileName($key);
        
        $temporaryFile = $_FILES[$this->_name]['tmp_name'][$key];
        
        if (is_array($temporaryFile))
            foreach ($temporaryFile as $num => $file)
                move_uploaded_file($temporaryFile[$num], ROOT.$destination.$name[$num]);
        else
            move_uploaded_file($temporaryFile, ROOT.$destination.$name);
    }
}
