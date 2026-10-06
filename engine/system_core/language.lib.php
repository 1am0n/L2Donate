<?php 
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class language {

    var $_currentLocale = "lt";

    var $languageFolder = "language";

    var $language_buffer = array();

    function getInstance() {
        static $_instance = null;
        if (!$_instance) {
            $_instance = new Language();
        }
        return $_instance;
    }

    function loadFromFile($file, $file_name = null, $append = true)
    {
        $language_class = Language::getInstance();
        $last_key = "";

        if (!$append) {
            $language_class->language_buffer = array();
        }

        if ($file_name == null) {
            $file_name = DON_ROOT . "" . $language_class->languageFolder . "/" . $language_class->_currentLocale . "/". $file .".lng";
            if (file_exists($file_name)) {
                $file_handler = fopen($file_name, "r");
                while (!feof($file_handler)) {
                    $line = fgets($file_handler, 2048);
                    if ((trim($line) == "") || ($line[0] == "#")) {
                        continue;
                    }

                    if (preg_match("/msgid \"(.+)\"/i", $line, $result)) {
                        $language_class->language_buffer[$result[1]] = "";
                        $last_key = $result[1];
                    } elseif (preg_match("/msgstr \"(.*)\"/i", $line, $result)) {
                        if (empty($last_key)) {
                            continue;
                        }
                        $language_class->language_buffer[$last_key] = $result[1];
                    } elseif (preg_match("/\"(.*)\"/i", $line, $result)) {
                        if (empty($last_key)) {
                            continue;
                        }
                        $language_class->language_buffer[$last_key] .= $result[1];
                    }
                }
                fclose($file_handler);
            }
        }
    }

    function setLanguage($language)
    {
        $language_class = Language::getInstance();
        $language_class->_currentLocale = $language;
    }

    function getLanguage()
    {
        $language_class = Language::getInstance();
        return $language_class->_currentLocale;
    }
    
    function setLanguageFolder($folder)
    {
        $language_class = Language::getInstance();
        $language_class->languageFolder = $folder;
    }    

    function getValue($msgid)
    {
        $language_class = Language::getInstance();
        if (isset($language_class->language_buffer[$msgid])) {
            return $language_class->language_buffer[$msgid];
        } else {
            return $msgid;
        }
    }

    function setValuesFromArray($array)
    {
        $language_class = Language::getInstance();
        $language_class->language_buffer = array_merge($array, $language_class->language_buffer);
    }

}

if (!function_exists("__")) {

    function __($msgid, $auto_print = false)
    {
        if ($auto_print) {
            echo language::getValue($msgid);
        } else {
            return language::getValue($msgid);
        }
    }

}

?>