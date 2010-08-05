<?php
/* Default config file used.
 * Note that when displaying phpSymon info for a specific host, this
 * file (config.php) is loaded first, followed by "host.HOSTNAME.php"
 * (expected to be in this same directory), if such a file exists.
 * (See the "host.EXAMPLE.php" file provided for examples of how to override
 * options.)
 */


/*********************************************************************
 * 1. PHP Error Reporting Options (uncomment to debug)
 *********************************************************************/
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);


/*********************************************************************
 * 2. phpSymon connection options
 *********************************************************************/
$config = array();

// This is the IPv4 address and port of the symux host which phpSymon will
// attempt to connect to and read symon data from.
$config['SymuxAddress']    = '192.168.1.1';
$config['SymuxPort']       = '2100';

// This is the hostname (IP address or fully-resolvable hostname) of the symon
// data that phpSymon should display.  Remember that multiple hosts can
// stream their symon data to a single symux host.
// If you would like to show the symon data of multiple hosts, use an array
// here.
$config['SymonHost']       = '192.168.1.1';

// This is the maximum number of read's to make from the symux host socket
// before giving up.  If there are N hosts streaming their symon data to the
// symux host, then each read operation will pull the data for exactly one
// host.  As such, this should be set to N.
// PLEASE NOTE: If N hosts stream their symon data to the symux host every M
//    seconds, then phpSymon may require up to (N * M) seconds before the
//    desired host's data is read!
$config['MaxTries']        = 1;

// This controls if phpSymon will automatically refresh the web page and thus
// the stats.  Set it to how often (in seconds) you would like to refresh.
// Set to 0 (or leave unset) to disable.
$config['AutoRefresh']    = 0;


/*********************************************************************
 * 3. Various display options
 *********************************************************************/

$config['ShowForm'] = true;
$config['ImageDir'] = 'images';
?>
