<?php

function display_pf(&$pf)
{  global $config;

   if (!isset($pf))
   {  echo "No PF information available";
      return;
   }

   // Grab the PF config data
   $pfConfig = &$config['display']['pf'];
   $pf = array_shift($pf);

   ?>
   <h2>PF</h2>
   <table class='datum_section'>
   <tr><td>

   <!-- BEGIN PF bandwidth/packet table -->
   <table>
   <tr>
      <td></td>
      <th colspan='2'>Bandwidth</th>
      <th colspan='2'>Packets In</th>
      <th colspan='2'>Packets Out</th>
   </tr>
   <tr>
      <th>IPv</th>
      <th>Pass</th>
      <th>Drop</th>
      <th>Pass</th>
      <th>Drop</th>
      <th>Pass</th>
      <th>Drop</th>
   </tr>

   <tr>
      <td>IPv4:</td>
      <td class='num'><?php echo fmtmem($pf['bytes_v4_in']); ?></td>
      <td class='num'><?php echo fmtmem($pf['bytes_v4_out']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v4_in_pass']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v4_in_drop']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v4_out_pass']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v4_out_drop']); ?></td>
   </tr>

   <tr>
      <td colspan='7'></td>
   </tr>

   <tr>
      <td>IPv6:</td>
      <td class='num'><?php echo fmtmem($pf['bytes_v6_in']); ?></td>
      <td class='num'><?php echo fmtmem($pf['bytes_v6_out']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v6_in_pass']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v6_in_drop']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v6_out_pass']); ?></td>
      <td class='num'><?php echo fmtnum($pf['packets_v6_out_drop']); ?></td>
   </tr>

   <!-- Spacer Row - also provides bottom-border to the 'sub-tables' -->
   <tr>
      <td colspan='7'></td>
   </tr>
   </table>
   <!-- END PF bandwidth/packet table -->


   </td></tr><tr><td>


   <!-- BEGIN PF counter table -->
   <table>
   <tr>
      <th colspan='6'>Counters</td>
   </tr>
   <tr>
      <th>Match</th>
      <th>Bad-Offset</th>
      <th>Fragment</th>
      <th>Short</th>
      <th>Normalize</th>
      <th>Memory</th>
   </tr>
   <tr>
      <td class='num'><?php echo fmtnum($pf['counters_match']); ?></td>
      <td class='num'><?php echo fmtnum($pf['counters_badoffset']); ?></td>
      <td class='num'><?php echo fmtnum($pf['counters_fragment']); ?></td>
      <td class='num'><?php echo fmtnum($pf['counters_short']); ?></td>
      <td class='num'><?php echo fmtnum($pf['counters_normalize']); ?></td>
      <td class='num'><?php echo fmtnum($pf['counters_memory']); ?></td>
   </tr>
   <tr>
      <td colspan='6' class='tb'></td>
   </tr>
   </table>
   <!-- END PF counter table -->


   </td></tr><tr><td>


   <!-- BEGIN PF state table -->
   <table>
   <tr>
      <th colspan='4'>State Table</th>
   </tr>
   <tr>
      <th>Entries</th>
      <th>Searches</th>
      <th>Inserts</th>
      <th>Removals</th>
   </tr>
   <tr>
      <td class='num'><?php echo fmtnum($pf['states_entries']); ?></td>
      <td class='num'><?php echo fmtnum($pf['states_searches']); ?></td>
      <td class='num'><?php echo fmtnum($pf['states_inserts']); ?></td>
      <td class='num'><?php echo fmtnum($pf['states_removals']); ?></td>
   </tr>
   <tr>
      <td colspan='4' class='tb'></td>
   </tr>
   </table>
   <!-- END PF state table -->

   </td></tr>
   </table>
   <?php
}
