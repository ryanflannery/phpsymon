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


/**
 * This file provides the routines necessary to retrieve symon stats from
 * a given host, in an easy-to-parse format (a large associative array).
 * To see what the format of the array looks like, check out the file
 * 'testsymon.php' included in this package (should be in this directory)
 * and point it to a symux installation you can access.
 */


// Include the format for each symon datum, as specified in symux(8)
require_once 'SymuxFormats.php';

class Symon
{

   /*
    * The following are the symux address/port where the Symon object will
    * obtain any status from.
    */
   private $symuxAddress;
   private $symuxPort;


   /*
    * This is the raw-symon data as retrieved from the symux host
    */
   public $symonData;


   /*
    * Symon class constructor.  Takes arguments to fill the above two private
    * members.
    */
   function Symon($symuxAddress, $symuxPort)
   {  $this->symuxAddress = $symuxAddress;
      $this->symuxPort = $symuxPort;
   }


   /*
    * The following method retrieves the symon stats for a given host, by
    * connecting to the symux instances specified in symuxAddress and
    * symuxPort.  After connecting, the method will read data until the symon
    * information for the specified host is provided.
    * The optional paramter, maxTries (which defaults to 3) specifies the
    * number of times to read data from symux before giving up, if symon
    * data for the provided host is never found.
    */
   public function get($host, $maxTries = 3)
   {
      /* Create a TCP/IP socket to communicate with symon */
      $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
      if ($socket < 0)
      {  echo "socket_create() failed. reason: " .
            socket_strerror($socket) . "\n";
         exit();
      }

      /* Connect to the symux host/port */
      $result = socket_connect($socket, $this->symuxAddress, $this->symuxPort);
      if ($result < 0)
      {  echo "socket_connect() failed. reason: ($result) " .
            socket_strerror($result) . "\n";
         exit();
      }

      /*
       * Read any symon outupt, and keep reading until either we read stats
       * for the host specified above OR we exceed the maximum number of
       * tries.
       * NOTE: If symon updates every n seconds, this could take up to n
       * seconds.  The default symon update period is 5 seconds.
       */
      $count = 0;
      while ($symonData = socket_read($socket, 4096))
      {  /* Have we found data for the host we want? */
         if (strtok($symonData, ";") == $host)
            break;

         if ($count++ >= $maxTries)
            $this->errorNoStats($host, $maxTries, __FILE__, __LINE__);
      }

      socket_close($socket);

      $this->symonData = &$symonData;
   }


   /*
    * The following is the function responsible for taking raw data read from
    * a symon stream (retrieved above) and turning into a massive associative
    * array that is easy to parse/dig-through for phpSymon.
    */
   public function parse()
   {  global $symuxFormat;

      /* Split the raw data into an array of datums, and extract the host */
      $rawDatums = explode(';', $this->symonData);
      $symon = array('host' => array_shift($rawDatums));

      /*
       * For each datum, parse into easier-to-read associate arrays, as
       * specified in the symuxFormat array.
       */
      foreach ($rawDatums as $datum)
      {

         /* empty datum? */
         if (trim($datum) == '') continue;

         /*
          * Split the datum into an array of data, and pull off the type of
          * data (e.g. 'if', 'io', 'cpu', 'mem', etc.)
          */
         $data = explode(':', $datum);
         $type = array_shift($data);

         if (array_key_exists($type, $symuxFormat))
         {  if (count($data) == count($symuxFormat[$type]))
            {  /* Zip the format array and the data array */
               $result = array_combine($symuxFormat[$type], $data);

               /*
                * Include the new associate array in the 'main' array to be
                * returned below
                */
               if (!isset($symon[$type]))
                  $symon[$type] = array();

               $symon[$type][] = $result;
            }
            else
               $this->errorBadFormat($data, $symuxFormat[$type],
                  __FILE__, __LINE__);
         } else
            $this->errorInvalidType($type, __FILE__, __LINE__);
      }

      /*
       * Finally, sort any datum types w/ multiple instances according to
       * their names.  e.g. for interfaces (if), sort them according to their
       * interface names (lo0, sis0, sis1, etc.).
       */
      foreach ($symon as $key => $value)
         if (is_array($value))
            usort($symon[$key], array("Symon", "compareByName"));

      return $symon;
   }


   /*
    * A simple comparison function used above.  It string-compares the 'name'
    * in each of the provided associative arrays.
    */
   private static function compareByName(&$a, &$b)
   { return strcmp($a['name'], $b['name']); }


   /*
    * Display an error message and exit.  This message is used when phpSymon
    * is unable to obtain stats for the given host at the provided address,
    * within maxTries reads.
    */
   private static function errorNoStats($host, $maxTries, $file, $line)
   {  echo "<html><head><itlte>phpSymon Error</title></head>\n";
      echo "<body><h1>phpSymon Error</h1>\n";
      echo "Unable to obtain symon information for host '$host' after\n";
      echo "reading $maxTries entries.  If you are sure you typed the\n";
      echo "host correctly, you can increase the maximum number of symon\n";
      echo "messages to sift through before giving up.<br />\n";
      echo "<br/><br/><br/>File: $file<br/>\nLine: $line<br/>\n";
      echo "Please contact <a href='mailto:ryan.flannery@gmail.com'>";
      echo "ryan.flannery@gmail.com</a> to report this.";
      exit();
   }


   /*
    * Display an error message and exit.  This message is used when a read
    * datum from a symon stream does not match the expected format.
    */
   private static function errorBadFormat($data, $format, $file, $line)
   {  echo "<html><head><title>phpSymon Error</title></head>\n";
      echo "<body><h1>phpSymon Error</h1>\n";
      echo "There is a discrepency between a datum that was read and \n";
      echo "the expected format for it.<br/>\n";
      echo "The datum is:<br/>\n";
      echo "<pre>"; print_r($data); echo "</pre><br/>\n";
      echo "The expected format is:<br/>\n";
      echo "<pre>"; print_r($format); echo "</pre><br/>\n";
      echo "<br/><br/><br/>File: $file<br/>\nLine: $line<br/>\n";
      echo "Please contact <a href='mailto:ryan.flannery@gmail.com'>";
      echo "ryan.flannery@gmail.com</a> to report this.";
      exit();
   }


   /*
    * Display an error message and exit.  This message is used when a read
    * datum is of unknown type.
    */
   private static function errorInvalidType($type, $file, $line)
   {  echo "<html><head><title>phpSymon Error</title></head>\n";
      echo "<body><h1>phpSymon Error</h1>\n";
      echo "An invalid type of datum has been read.  The type provided is:";
      echo "'$type'.<br/>\n";
      echo "phpSymon is currently unaware of this type of datum.<br/>\n";
      echo "<br/><br/><br/>File: $file<br/>\nLine: $line<br/>\n";
      echo "Please contact <a href='mailto:ryan.flannery@gmail.com'>";
      echo "ryan.flannery@gmail.com</a> to report this.";
      exit();
   }

}
?>
