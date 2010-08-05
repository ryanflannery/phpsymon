<?php

function display_sensors(&$sensors)
{
   if (!isset($sensors))
   {  echo "No SENSOR information available";
      return;
   }
   ?>
   <h2>Sensor(s)</h2>
   <table class='datum_section'>
   <tr>
      <th>Name</th>
      <th>Value</th>
   </tr>

   <?php foreach($sensors as $sensor) display_single_sensor($sensor); ?>

   </table>
   <?php
}

function display_single_sensor(&$sensor)
{  ?>
   <tr>
      <td><?php echo $sensor['name']; ?></td>
      <td class='num'><?php echo fmtnum($sensor['value']); ?></td>
   </tr>
   <?php
}

?>
