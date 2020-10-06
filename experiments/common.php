<?php

    define("FILE_PUT_CONTENTS_ATOMIC_TEMP", dirname(__FILE__)."/cache");
    define("FILE_PUT_CONTENTS_ATOMIC_MODE", 0777);    

    function file_put_contents_atomic($filename, $content) {  
      $temp = tempnam(FILE_PUT_CONTENTS_ATOMIC_TEMP, 'temp');
      if (!($f = @fopen($temp, 'wb'))) {
        $temp = FILE_PUT_CONTENTS_ATOMIC_TEMP
                . DIRECTORY_SEPARATOR
                . uniqid('temp');
        if (!($f = @fopen($temp, 'wb'))) {
            trigger_error("file_put_contents_atomic() : error writing temporary file '$temp'", E_USER_WARNING);
            return false;
        }
      }  
      @fwrite($f, $content);
      @fclose($f);
      if (!@rename($temp, $filename)) {
           @unlink($filename);
           @rename($temp, $filename);
      }  
      @chmod($filename, FILE_PUT_CONTENTS_ATOMIC_MODE);   
      return true;   
    }

?>
