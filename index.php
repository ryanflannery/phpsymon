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

/*
 * Retrieve the time this script starts.  This is used to display some
 * phpSymon run-time info...which is only done to help those who constantly
 * ask "Why does this script sometimes take up to 5 SECONDS to load???"
 */
$times = array();
$times['start'] = microtime(true);

/* Include the phpSymon configuration file */
require_once('config/config.php');

/* include the symon lib and some miscellaneous functions */
require_once('lib/Symon.php');
require_once('lib/utils.php');

/* include the templates */
require_once "templates/cpu.php";
require_once "templates/df.php";
require_once "templates/if.php";
require_once "templates/io.php";
require_once "templates/mbuf.php";
require_once "templates/mem.php";
require_once "templates/pf.php";
require_once "templates/proc.php";
require_once "templates/sensor.php";
require_once "templates/phpsymon_form.php";


/**********************************************************************
 * Determine the connection information (what symux host to connect to)
 * as well as what host stats to grab.
 *********************************************************************/
$address  = getparam($_GET, 'address',    $config['SymuxAddress']);
$port     = getparam($_GET, 'port',       $config['SymuxPort']);
$host     = getparam($_GET, 'host',       $config['SymonHost']);
$maxTries = getparam($_GET, 'maxTries',   $config['MaxTries']);
$refresh  = getparam($_GET, 'refresh',    $config['AutoRefresh']);


/**********************************************************************
 * Retrieve symon stats
 *********************************************************************/

$symon = new Symon($address, $port);

$times['beforeGetSymon'] = microtime(true);
$symon->get($host, $maxTries);
$times['afterGetSymon'] = microtime(true);

/* construct a php assoc-array of the symon data (easier to parse) */
$symonData = $symon->parse();


/**********************************************************************
 * Start displaying the page.
 * Only the overall structure/layout of the page is listed below.
 * All of the details are in the template files under the templates/
 * sub-directory.
 *********************************************************************/
?>
<html>
<head>
   <title>phpSymon for <?php echo $host; ?></title>
   <link rel="stylesheet" type="text/css" href="css/styles.css" />
   <?php
      // add a meta-auto-refresh if requested
      if (is_numeric($refresh) && $refresh != 0)
         echo "   <meta http-equiv='refresh' content='$refresh' />\n";
   ?>
</head>
<body>
<center>

<?php
   // show the form, if configured to do so
   if (is_bool($config['ShowForm']) && $config['ShowForm'])
      display_phpSymon_form();
?>

<table>
<tr>
   <td width="400px">
      <?php display_cpus($symonData['cpu']); ?>
   </td>
   <td width="400px">
      <?php display_mem($symonData['mem']); ?>
   </td>
</tr>
<tr>
   <td>
      <?php display_pf($symonData['pf']); ?>
   </td>
   <td>
      <?php display_mbuf($symonData['mbuf']); ?>
   </td>
</tr>
<tr>
   <td>
      <?php display_ifs($symonData['if']); ?>
   </td>
   <td>
      <?php display_ios($symonData['io']); ?>
   </td>
</tr>
<tr>
   <td colspan="2">
      <?php display_dfs($symonData['df']); ?>
   </td>
</tr>
<tr>
   <td colspan="2">
      <?php display_procs($symonData['proc']); ?>
   </td>
</tr>
<tr>
   <td>
      <?php display_sensors($symonData['sensor']); ?>
   </td>
   <td></td>
</tr>
</table>


<br /><br />

<!-- FOOTER -->
<hr />

<div id="phpSymonFooter">
   phpSymon v2.0 Copyright &copy; 2008
   <a href="mailto:ryan.flannery@gmail.com">Ryan Flannery</a>.
   Check the
   <a href="http://www.ryanflannery.net/works/phpsymon/">phpsymon</a>
   website for updates.<br />
   Questions, comments, bugs... contact the above.
</div>

</center>
</body>
</html>
