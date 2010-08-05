<?php
/*
 * Copyright (c) 2008 Ryan Flannery
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT HOLDERS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 */


// getParam( [ $_GET | $_POST | $array ] , "name", "defaultvalue" )
// This function is used to extract values from GET and POST arrays, but can be
// used to extract information from any array.
function getparam($array, $name, $default)
{  if (!isset($array["$name"]) || $array["$name"] == "")
      return $default;
   else
      return $array["$name"];
}

function statusbar($percents)
{
   global $config;
   $str = "<nobr>";

   foreach ($percents as $p => $color)
   {  if ($p == 0) continue;
      $str .= "<img height='10px' width='" . $p . "%' "
           .  "src='" . $config['ImageDir'] . "/" . $color . ".gif' />";
   }

   $str .= "</nobr>";
   return $str;
}

function colorsquare($color)
{  global $config;
   ?>
   <img height="10px" width="10px" style="border: 1px solid black;"
        src="<?php echo $config['ImageDir']; ?>/<?php echo $color; ?>.gif">
   <?php
}

function fmtnum($num, $format = "%3.1f")
{
   if ($num < 1000)
      return sprintf($format, $num); // TODO too simple - need 0 precision most
                                     // of the time
   else
      $num /= 1000;

   // thousand
   if ($num < 1000)
      return sprintf($format, $num) . '<small>k</small>';
   else
      $num /= 1000;

   // million
   if ($num < 1000)
      return sprintf($format, $num) . '<small>M</small>';
   else
      $num /= 1000;

   // billion
   if ($num < 1000)
      return sprintf($format, $num) . '<small>G</small>';
   else
      $num /= 1000;

   // trillion
   if ($num < 1000)
      return sprintf($format, $num) . '<small>T</small>';
   else
      $num /= 1000;

   // quadrillion
   if ($num < 1000)
      return sprintf($format, $num) . '<small>P</small>';
   else
      $num /= 1000;

   // assume quintillion
   return sprintf($format, $num) . '<small>E</small>';
}

function fmtmem($bytes, $format = "%3.1f")
{
   if ($bytes < 1024)
      return $bytes . '<small>B</small>';
   else
      $bytes /= 1024;

   if ($bytes < 1024)
      return sprintf($format, $bytes) . '<small>K</small>';
   else
      $bytes /= 1024;

   if ($bytes < 1024)
      return sprintf($format, $bytes) . '<small>M</small>';
   else
      $bytes /= 1024;

   if ($bytes < 1024)
      return sprintf($format, $bytes) . '<small>G</small>';
   else
      $bytes /= 1024;

   if ($bytes < 1024)
      return sprintf($format, $bytes) . '<small>T</small>';
   else
      $bytes /= 1024;

   if ($bytes < 1024)
      return sprintf($format, $bytes) . '<small>P</small>';
   else
      $bytes /= 1024;

   // assume tera-bytes
   return sprintf($format, $bytes) . '<small>E</small>';
}


function errorGeneric($msg, $file, $line)
{  echo "<html><head><title>phpSymon Error</title></head>\n";
   echo "<body><h1>phpSymon Error</h1>\n";
   echo $msg;
   echo "\n<br/><br/><br/>File: $file<br/>\nLine: $line<br/>\n";
   echo "Please contact <a href='mailto:ryan.flannery@gmail.com'>";
   echo "ryan.flannery@gmail.com</a> to report this.";
   exit();
}
?>
