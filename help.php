<?php require_once("config/config.php"); ?>
<html>
<head>
   <title>phpSymon Help</title>
   <link rel="stylesheet" type="text/css" href="<?php echo $config['css']; ?>"/>
</head>
<body>
Options are:
<ul>
   <li><b>Symux Address.</b>  This is the address you want to read
         <tt>symon</tt> stats FROM.
         <i>(Default is "<?php echo $config['symuxAddress']; ?>".)</i>
   <li><b>Symux Port.</b>  This is the port at the <b>address</b> you want to
         read <tt>symon</tt> stats from.
         <i>(Default is "<?php echo $config['symuxPort']; ?>".)</i>
   <li><b>Symon Host.</b> Many hosts running <tt>symon</tt> can stream their
         stats to a given <tt>symux</tt> <b>address</b>/<b>port</b>.  This is a
         comma-seperated list of hosts you want to read stats from.
         <i>(Default is "<?php echo $config['symonHosts']; ?>".)</i>
   <li><b>Max Tries.</b> If many hosts are streaming their <tt>symon</tt> stats
         to the <b>address</b>/<b>port</b> you are connecting to, this option
         specifies how many datums to read before giving up.  So, if <tt>n</tt>
         hosts stream their symon stats to the same <b>address</b>/<b>port</b>,
         this should be <tt>n</tt>.
         <i>(Default is <?php echo $config['maxTries']; ?>.)</i>
         <br/>
         <font color="red">WARNING:</font> If the host you are wanting to view
         only updates its <tt>symon</tt> stats every <tt>m</tt> seconds, then
         you could wait up to <tt>m * n</tt> seconds!  Be careful with this!
   <li><b>Refresh.</b> How often (in seconds) you want the screen to
         auto-refresh.  0 = never.
         <i>(Default is <?php echo $config['auto-refresh']; ?>.)</i>
</ul>

<br />

If you have additional questions, comments, or are experiencing a problem,
visit the phpSymon website
<a href="http://www.ryanflannery.net/works/phpsymon/">here</a>
for a list of frequently asked questions.

<br /><br />

<hr />
phpSymon v2.0. Copyright &copy; 2008
<a href="mailto:ryan.flannery@gmail.com">Ryan Flannery</a>.
</body>
</html>
