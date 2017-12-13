<?php

/*
 *  Copyright (C) 2001 Kai Blaschke <webmaster@thw-theorie.de>
 *
 *  The included "THW Thema" templates, logos and the Q&A catalog are protected
 *  by copyright laws, and must not be used without the written permission
 *  of the
 *
 *  Bundesanstalt Technisches Hilfswerk
 *  Provinzialstraße 93
 *  D-53127 Bonn
 *  Germany
 *  E-Mail: redaktion@thw.de
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */
 
/************************************************************
* Template class
*
* This class is capable of replacing variables with text,
* including other templates, and it can parse dynamic blocks
* which can be nested inside other blocks.
* 
* Predefined variables:
* 
* {templatePath} Contains the template path
* {templateLang} Contains the country code, if set
* 
* If you don't need them, remove them immediately after
* creating the class instance or setting a new template path.
* 
* $id: class Template v1.0 / Kai Blaschke $
* 
**************************************************************/


class Template {

//    ************************************************************
//    Member variables

    var $TPLFILES  = array();       // Contains all template filenames
    var $TPLDATA   = array();       // Contains all template data
    var $LOADED    = array();       // Already loaded templates are
                                    // stored as $LOADED[HANDLE]=>TRUE
    var $PARSEVARS = array();       // Array of variable/value pairs 
                                    // to be replaced in templates
    var $HANDLES   = array();       // Handles which contain parsed templates
    
    var $BLOCKS    = array();       // Array with dynamic block data
    var $H_BLOCKS  = array();       // Parsed block data
    
    // Filename: $TPLDIR/filename[.$LANG].tpl
    var $TPLDIR;                    // Path to template files
    var $LANG;                      // Country code (en, de, fr, ...)
    var $TPLEXT;                    // Filename extension (default is .tpl)
    
    
//    ************************************************************
//    Global settings

    var $RPLBRACES = TRUE;          // Safely replaces curly braces with HTML
                                    // entities in variable values if
                                    // set to TRUE.
    var $WIN32     = FALSE;         // Set to "TRUE" on Win32 systems, if
                                    // you encounter problems with paths.
    var $DIEONERR  = TRUE;          // If set to TRUE, die() is called in error
    
    
    
    
//    ************************************************************
//    Constructor

    function Template($tpldir, $lang = "", $tplext = "tpl")
    {
        $this->setPath($tpldir);
        $this->LANG   = strtolower($lang);
        $this->TPLEXT = $tplext;
        
        $this->addVars("templateLang", $this->LANG);
    }

//    ************************************************************
//    Sets or changes the template search path
    
    function setPath($path)
    {
        if ($this->WIN32) {
            if (ord(substr($path, -1)) != 92) $path .= chr(92);
        } else {
            if (ord(substr($path, -1)) != 47) $path .= chr(47);        
        }
        
        if (is_dir($path)) {
            $this->TPLDIR = $path;
            
            // Add a path variable for use in templates
            $this->addVars("templatePath", $path);
            
            return TRUE;
        } else {
            echo "[TEMPLATE ENGINE] The specified template path "
                ."'<b>".$path."</b>' is invalid!<br />"; 
                       
            $this->TPLDIR = "";

            if ($this->DIEONERR == TRUE) die();
            return FALSE;
        }
    }

//    ************************************************************
//    Get dynamic blocks recursively to enable nested blocks

    function getDynamicBlocks($tplFilename, $contents)
    {
        preg_match_all("/(\{\|([a-zA-Z0-9]+)\})(.*?)\\1/s",
            $contents, $blocks);
     
        if (empty($blocks[0])) return;
     
        // Go through all blocks and save them in $this->BLOCKS
        for ($I=0; $I<count($blocks[0]); $I++) {
            $blockparts = array();
            preg_match_all("/(\{\|" . $blocks[2][$I] . 
                "\*([a-zA-Z0-9]+)\})(.*?)\\1/s", 
                $blocks[3][$I], $blockparts);
       
            for ($J=0; $J<count($blockparts[0]); $J++) {
                // Get nested blocks
                $this->getDynamicBlocks($tplFilename, $blockparts[3][$J]);

                // Replace block data with placeholders
                $blockparts[3][$J] =
                    preg_replace("/(\{\|([a-zA-Z0-9]+)\})(.*?)\\1/s",
                    "\\1", $blockparts[3][$J]);
                
                // Save block data
                $this->BLOCKS[$tplFilename][$blocks[2][$I]][$blockparts[2][$J]]
                    = $blockparts[3][$J];
                   
            }
        }    
    }
    
//    ************************************************************
//    Loads a template, runs some checks and extracts dynamic blocks
    
    function loadTemplate($tplFilename)
    {
        // Template already loaded?
        if (isset($this->LOADED[$tplFilename])) return TRUE;
        
        // Has the path been set?
        if (empty($this->TPLDIR)) {
            echo "[TEMPLATE ENGINE] Template path not set or invalid!<br />";

            if ($this->DIEONERR == TRUE) die();
            return FALSE;
        }
        
        // Is a user-defined county code set?
        if (!empty($this->LANG)) {
            // Yes. Try to find template with the specified CC
            if (file_exists($this->TPLDIR.$this->TPLFILES[$tplFilename]."."
                .$this->LANG.".".$this->TPLEXT)) {
                $filename = $this->TPLDIR.$this->TPLFILES[$tplFilename].".".
                    $this->LANG.".".$this->TPLEXT;
            } else {
                // Otherwise, use template filename without CC
                if (file_exists($this->TPLDIR.$this->TPLFILES[$tplFilename]."."
                    .$this->TPLEXT)) {
                    $filename = $this->TPLDIR.$this->TPLFILES[$tplFilename]."."
                        .$this->TPLEXT;
                } else {
                    echo "[TEMPLATE ENGINE] Can't find template "
                        ."'".$tplFilename."'!<br />";

                    if ($this->DIEONERR == TRUE) die();
                    return FALSE;
                }
            }
        } else {
            // No. Use template filename without CC
            if (file_exists($this->TPLDIR.$this->TPLFILES[$tplFilename]."."
                .$this->TPLEXT)) {
                $filename = $this->TPLDIR.$this->TPLFILES[$tplFilename]."."
                    .$this->TPLEXT;    
            } else {
                echo "[TEMPLATE ENGINE] Can't find template "
                    ."'".$tplFilename."'!<br />";

                if ($this->DIEONERR == TRUE) die();
                return FALSE;
            }
        }
        
        // Load template file
        $contents = implode("", (@file($filename)));
    
        if (!$contents || empty($contents)) {
            echo "[TEMPLATE ENGINE] Can't load template '"
                .$tplFilename."'!<br />";

            if ($this->DIEONERR == TRUE) die();
            return FALSE;
        }
        
        // Parse dynamic blocks recursively
        $this->getDynamicBlocks($tplFilename, $contents);
        
        // Replace all block data with placeholders
        $contents = preg_replace("/(\{\|([a-zA-Z0-9]+)\})(.*?)\\1/s", "\\1",
            $contents);
                
        $this->TPLDATA[$tplFilename] = $contents;               
        $this->LOADED[$tplFilename] = 1;
        
        return TRUE;

    }

//    ************************************************************
//    Parses a template and loads it if neccessary.
//    The result is assigned or concatenated to the specified handle.

    function parse($handle = "",
                   $file = "", 
                   $append = FALSE, 
                   $delunused = FALSE)
    {
        // Check if all prerequisites are met
        if (empty($handle) || empty($file))
            return FALSE;
            
        if (!isset($this->TPLFILES[$file]))
            return FALSE;
            
        if (!isset($this->LOADED[$file])&&!$this->loadTemplate($file))
            return FALSE;
        
        $templateCopy = $this->TPLDATA[$file];
        
        // Reset array pointers
        reset($this->HANDLES);
        reset($this->PARSEVARS);
        
        // Replace blocks
        if (isset($this->H_BLOCKS[$file])) {
            reset($this->H_BLOCKS[$file]);

            while (list($varname, $value) = each($this->H_BLOCKS[$file]))
                $templateCopy = preg_replace("/\{\|".$varname."\}/i", 
                    $value, $templateCopy);
        }
        
        // Replace variables
        while (list($varname, $value) = each($this->PARSEVARS))
            $templateCopy = preg_replace("/\{".$varname."\}/i",
                $value, $templateCopy);
        
        // Replace {~name} placeholders with already parsed handle of
        // the same name
        while (list($varname, $value) = each($this->HANDLES))
            $templateCopy = preg_replace("/\{\~".$varname."\}/i",
                $value, $templateCopy);
    
        // Delete unused variables and placeholders
        if ($delunused)
            $templateCopy = preg_replace("/\{[~|\|]?(\w*?)\}/", "",
                $templateCopy);
            
        // Assign to handle
        if ($append && isset($this->HANDLES[$handle])) {
            $this->HANDLES[$handle] .= $templateCopy;
        } else {
            $this->HANDLES[$handle] = $templateCopy;
        }
        
        return TRUE;
    }
    
//    ************************************************************
//    Parses multiple templates.
//    $list is an associative array of the type "handle"=>"template".
//    Note that concatenation is not possible. Use the parse() method instead.

    function multiParse($list)
    {
        if (!is_array($list)) return FALSE;
        
        while (list($handle, $file) = each($list))
            if (!$this->parse($handle, $file)) return FALSE;

        return TRUE;
    }

//    ************************************************************
//    Parses a template and prints the result.

    function printParse($handle = "", $file = "", $append = FALSE)
    {
        if ($this->parse($handle, $file, $append)) {
            $this->printHandle($handle);
            return TRUE;
        }
        
        return FALSE;
    }

//    ************************************************************
//    Parses a block and replaces or appends the result to the block handle.
//
//    Note: First argument is the template file name containing the blocks,
//    not a handle name!
//
//    Note: This function has no effect on any template handle.
//    Parsed block data is inserted into the template handle in the
//    parse() method.

    function parseBlock($file = "",
                        $block = "", 
                        $blockpart = "", 
                        $append = FALSE, 
                        $delunused = FALSE)
    {
        if (empty($file) || empty($block) || empty($blockpart))
            return FALSE;                

        if (!isset($this->TPLFILES[$file]))
            return FALSE;

        if (!isset($this->LOADED[$file])&&!$this->loadTemplate($file))
            return FALSE;

        $blockCopy = $this->BLOCKS[$file][$block][$blockpart];
        
        // Reset array pointers
        reset($this->H_BLOCKS);
        reset($this->PARSEVARS);

        // Replace blocks
        if (isset($this->H_BLOCKS[$file])) {
            reset($this->H_BLOCKS[$file]);

            while (list($varname, $value) = each($this->H_BLOCKS[$file]))
                $blockCopy = preg_replace("/\{\|".$varname."\}/i", 
                    $value, $blockCopy);
        }
        
        // Replace variables
        while (list($varname, $value) = each($this->PARSEVARS))
            $blockCopy = preg_replace("/\{".$varname."\}/i",
                $value, $blockCopy);
        
        // Replace {~name} placeholders with already parsed handle of
        // the same name
        while (list($varname, $value) = each($this->HANDLES))
            $blockCopy = preg_replace("/\{\~".$varname."\}/i",
                $value, $blockCopy);
        
        // Delete unused variables and placeholders
        if ($delunused)
            $blockCopy = preg_replace("/\{[~|]?(\w*?)\}/", "", $blockCopy);

        // Assign to handle
        if ($append && isset($this->H_BLOCKS[$file][$block])) {
            $this->H_BLOCKS[$file][$block] .= $blockCopy;
        } else {
            $this->H_BLOCKS[$file][$block] = $blockCopy;
        }                

        return TRUE;
    }

//    ************************************************************
//    Deletes all block handles

    function clearBlockHandles()
    {
        if (!empty($this->H_BLOCKS)) {
            reset($this->H_BLOCKS);
            while (list($ref, $val) = each($this->H_BLOCKS)) 
                unset($this->H_BLOCKS[$ref]);
        }
    }
    
//    ************************************************************
//    Deletes the specified block handle

    function delBlockHandle($file, $block)
    {
        if (!empty($file) && !empty($block))
            if (isset($this->H_BLOCKS[$file][$block]))
                unset($this->H_BLOCKS[$file][$block]);
    }

//    ************************************************************
//    Adds one or more templates
//    You can pass one associative array with $handle=>$filename pairs,
//    or two strings ($handle, $filename) to this function.

    function addTemplates($tplList, $tplFilename = "")
    {
        if (is_array($tplList)) {
            reset($tplList);
            while (list($handle, $filename) = each($tplList)) {
                // Add handle to list
                $this->TPLFILES[$handle] = $filename;
                // Delete loaded flag if set
                unset($this->LOADED[$handle]);
            }
        } else {
            $this->TPLFILES[$tplList] = $tplFilename;
            unset($this->LOADED[$tplList]);
        }
    }

//    ************************************************************
//    Deletes all template handles

    function clearHandles()
    {
        if (!empty($this->HANDLES)) {
            reset($this->HANDLES);
            while (list($ref, $val) = each($this->HANDLES)) 
                unset($this->HANDLES[$ref]);
        }
    }
    
//    ************************************************************
//    Deletes the specified template handle

    function delHandle($handleName = "")
    {
        if (!empty($handleName)) 
            if (isset($this->HANDLES[$handleName])) 
                unset($this->HANDLES[$handleName]);
    }

//    ************************************************************
//    Returns the contents of the specified template handle

    function getHandle($handleName = "")
    {
        if (empty($handleName))
            return FALSE;
            
        if (isset($this->HANDLES[$handleName]))
            return $this->HANDLES[$handleName];

        return FALSE;
    }

//    ************************************************************
//    Prints a parsed template handle

    function printHandle($handleName = "")
    {
        if (empty($handleName)) return FALSE;
        
        // Remove all remaining placeholders
        $this->HANDLES[$handleName] = preg_replace("/\{[~|\|]?(\w*?)\}/",
            "", $this->HANDLES[$handleName]);    
        
        if (isset($this->HANDLES[$handleName])) {
            echo $this->HANDLES[$handleName];
            return TRUE;
        }
        
        return FALSE;
    }

//    ************************************************************
//    Deletes all variables set with the addVars() method

    function clearVars()
    {
        if (!empty($this->PARSEVARS)) {
            reset($this->PARSEVARS);
            while (list($ref, $val) = each ($this->PARSEVARS))
                unset($this->PARSEVARS[$ref]);
        }
    }

//    ************************************************************
//    Adds one or more variables.
//    You can pass one associative array with $varname=>$value pairs
//    or two strings ($varname, $value) to this function.
    
    function addVars($varList, $varValue = "")
    {
        if (is_array($varList)) {
            reset($varList);
            while (list($varname, $value) = each($varList)) {
                // Replace curly braces
                if ($this->RPLBRACES == TRUE) {
                    $value = preg_replace(Array("/(\{)/", "/(\})/"), 
                                          Array("&#123;", "&#125;"), 
                                          $value);
                }
                
                // Add/replace variable
                if (!preg_match("/[^0-9a-z\-\_]/i", $varname)) 
                    $this->PARSEVARS[$varname] = $value;
            }
        } else {
            // Replace curly braces
            if ($this->RPLBRACES == TRUE) {
                $varValue = preg_replace(Array("/(\{)/", "/(\})/"), 
                                         Array("&#123;", "&#125;"), 
                                         $varValue);
            }
            
            // Add/replace variable
            if (!preg_match("/[^0-9a-z\-\_]/i", $varList))
                $this->PARSEVARS[$varList] = $varValue;
        }   
    }
    
//    ************************************************************
//    Returns a value set by the addVars() method
    
    function getVar($varName = "")
    {
        if (empty($varName)) return FALSE;
        if (isset($this->PARSEVARS[$varName]))
                return $this->PARSEVARS[$varName];
        return FALSE;    
    }

//    ************************************************************

} // End of class 'Template'

?>