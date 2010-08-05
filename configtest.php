<?php
/*
 * Run this script to see if the basic configuration works and connection
 * to symux host work.
 */

require_once('config/config.php');
require_once('lib/Symon.php');

// create the symon object with the symux host information in the config
$symon = new Symon($config['SymuxAddress'], $config['SymuxPort']);

// determine the host to retrieve the stats for
if (is_array($config['SymonHost']))
   $host = $config['SymonHost'][0];
else
   $host = $config['SymonHost'];

// get the stats
$symon->get($host);

echo "<pre>Symon stats for host '$host'\n";
print_r($symon->parse());
echo "</pre>";

?>
If you see any info above, it worked.  :)
<br />
Otherwise, it did not work.  :(
