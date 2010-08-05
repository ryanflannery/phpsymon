<?php

function display_phpSymon_form()
{  global $address, $port, $host, $maxTries, $refresh;
   ?>
<form method="get">
   Symux Address:
   <input name="address"  value="<?php echo $address; ?>"
          type="text" size="10" />
   Symux Port:
   <input name="port"     value="<?php echo $port; ?>"
          type="text" size="5" />
   Host:
   <input name="host"     value="<?php echo $host; ?>"
          type="text" size="10" />
   Max. Tries:
   <input name="maxTries" value="<?php echo $maxTries; ?>"
          type="text" size="3" />
   Auto-Refresh:
   <input name="refresh"  value="<?php echo $refresh; ?>"
          type="text" size="3" />
   <input type="submit" value="Go" />
</form>
<hr />
   <?php
}

?>
