<?php

function display_ios(&$drives)
{
   if (!isset($drives))
   {  echo "No IO information available";
      return;
   }
   ?>
   <h2>Drive(s)</h2>
   <table class='datum_section'>
   <tr>
      <td></td>
      <th colspan='2'>Throughput</th>
      <th colspan='2'>Transfers</th>
      <td></td>
   </tr>
   <tr>
      <th>Drive</th>
      <th>Read</th>
      <th>Written</th>
      <th>Read</th>
      <th>Write</th>
      <th>Seeks</th>
   </tr>

   <?php foreach($drives as $drive) display_single_io($drive); ?>

   </td></tr>
   </table>
   <?php
}

function display_single_io(&$drive)
{  ?>
   <tr>
      <td><?php echo $drive['name']; ?>:</td>
      <td class='num'><?php echo fmtmem($drive['total_rbytes']); ?></td>
      <td class='num'><?php echo fmtmem($drive['total_wbytes']); ?></td>
      <td class='num'><?php echo fmtnum($drive['total_rxfer']); ?></td>
      <td class='num'><?php echo fmtnum($drive['total_wxfer']); ?></td>
      <td class='num'><?php echo fmtnum($drive['total_seeks']); ?></td>
   </tr>
   <?php
}

?>
