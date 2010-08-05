<?php

function display_ifs(&$ifs)
{
   if (!isset($ifs))
   {  echo "No IF information available";
      return;
   }
   ?>
   <h2>Network Interface(s)</h2>
   <table class='datum_section'>
   <tr><td>

   <table>
   <tr>
      <td></td>
      <th colspan='2'>Bandwidth</th>
      <th colspan='2'>Packets</th>
      <th colspan='2'>Multicasts</th>
      <th colspan='2'>Errors</th>
      <td></td>
      <td></td>
   </tr>
   <tr>
      <th>IF</th>
      <th>In</th>
      <th>Out</th>
      <th>In</th>
      <th>Out</th>
      <th>In</th>
      <th>Out</th>
      <th>In</th>
      <th>Out</th>
      <th>Coll.</th>
      <th>Drops</th>
   </tr>

   <?php foreach($ifs as $if) display_single_if($if); ?>

   <!-- Spacer Row - also provides bottom-border to the 'sub-tables' -->
   <tr>
      <td colspan='11'></td>
   </tr>
   </table>

   </tr></td>
   </table>
   <?php
}

function display_single_if(&$if)
{  ?>
   <tr>
      <td><?php echo $if['name']; ?>:</td>
      <td class='num'><?php echo fmtmem($if['bytes_in']); ?></td>
      <td class='num'><?php echo fmtmem($if['bytes_out']); ?></td>
      <td class='num'><?php echo fmtnum($if['packets_in']); ?></td>
      <td class='num'><?php echo fmtnum($if['packets_out']); ?></td>
      <td class='num'><?php echo fmtnum($if['multicasts_in']); ?></td>
      <td class='num'><?php echo fmtnum($if['multicasts_out']); ?></td>
      <td class='num'><?php echo fmtnum($if['errors_in']); ?></td>
      <td class='num'><?php echo fmtnum($if['errors_out']); ?></td>
      <td class='num'><?php echo fmtnum($if['collisions']); ?></td>
      <td class='num'><?php echo fmtnum($if['drops']); ?></td>
   </tr>
   <tr>
      <td colspan='11'></td>
   </tr>
   <?php
}
