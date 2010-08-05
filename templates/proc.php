<?php

function display_procs(&$procs)
{
   if (!isset($procs))
   {  echo "No PROC information available";
      return;
   }
   ?>
   <h2>Process(es)</h2>
   <table class='datum_section'>
   <tr>
      <td colspan='4'></td>
      <th colspan='3'>Time (ticks)</th>
      <td colspan='2'></td>
   </tr>
   <tr>
      <th>Command</th>
      <th>Number</th>
      <th>Size</th>
      <th>Res.</th>
      <th>User</th>
      <th>System</th>
      <th>Interrupt</th>
      <th>Time</th>
      <th>CPU%</th>
   </tr>

   <?php foreach($procs as $proc) display_single_proc($proc); ?>

   </table>
   <?php
}

function display_single_proc(&$proc)
{  ?>
   <tr>
      <td><?php echo $proc['name']; ?></td>
      <td class='num'><?php echo fmtnum($proc['number']); ?></td>
      <td class='num'><?php echo fmtmem($proc['procsz']); ?></td>
      <td class='num'><?php echo fmtmem($proc['rsssz']); ?></td>
      <td class='num'><?php echo fmtnum($proc['uticks']); ?></td>
      <td class='num'><?php echo fmtnum($proc['sticks']); ?></td>
      <td class='num'><?php echo fmtnum($proc['iticks']); ?></td>
      <td class='num'><?php echo fmtnum($proc['cpusec']); ?></td>
      <td class='num'><?php echo fmtnum($proc['cpupct']); ?></td>
   </tr>
   <?php
}

?>
