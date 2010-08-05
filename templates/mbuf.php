<?php

function display_mbuf(&$mbuf)
{
   if (!isset($mbuf))
   {  echo "No MBUF information avialable";
      return;
   }

   $mbuf = array_shift($mbuf);
   ?>
   <h2>mbuf Usage</h2>
   <table class='datum_section'>
   <tr>
      <td colspan='6'><?php echo $mbuf['totmbufs']; ?> mbufs in use:</td>
   </tr>
   <tr>
      <td></td>
      <td class='num'><?php echo $mbuf['mt_data']; ?></td>
      <td>data</td>
      <td></td>
      <td class='num'><?php echo $mbuf['mt_ftable']; ?></td>
      <td>frag reassembly hdrs</td>
   </tr>
   <tr>
      <td></td>
      <td class='num'><?php echo $mbuf['mt_header']; ?></td>
      <td>packet hdrs</td>
      <td></td>
      <td class='num'><?php echo $mbuf['mt_control']; ?></td>
      <td>extra data protocol msgs</td>
   </tr>
   <tr>
      <td></td>
      <td class='num'><?php echo $mbuf['mt_soname']; ?></td>
      <td>sock. names / addrs</td>
      <td></td>
      <td class='num'><?php echo $mbuf['mt_soopts']; ?></td>
      <td>sock. options</td>
   </tr>
   <tr>
      <td colspan='4'></td>
      <td class='num'><?php echo $mbuf['mt_oobdata']; ?></td>
      <td>out-of-band data</td>
   </tr>

   <tr><td colspan='6'><hr /></td></tr>

   <tr><td colspan='6'>

   <table>
   <tr>
   <td class='num'>
      <?php echo $mbuf['pgused']; ?>&nbsp;/&nbsp;<?php echo $mbuf['pgtotal']; ?>
   </td>
   <td>
      mbuf clusers in use (current/peak)
   </td>
   </tr>
   <tr>
   <td class='num'>
      <?php echo fmtmem($mbuf['totmem']); ?>
   </td>
   <td>
      allocated to network (<?php echo fmtnum($mbuf['totpct']); ?>% in use)
   </td>
   </tr>
   </table>

   </td></tr>

   <tr><td colspan='6'><hr /></td></tr>

   <tr>
      <td></td>
      <td class='num'><?php echo $mbuf['m_drops']; ?></td>
      <td>requests for memory denied</td>
      <td></td>
      <td class='num'><?php echo $mbuf['m_drain']; ?></td>
      <td>calls to protocol drain routines</td>
   </tr>
   <tr>
      <td></td>
      <td class='num'><?php echo $mbuf['m_wait']; ?></td>
      <td colspan='4'>requests for memory delayed</td>
   </tr>
   </table>
   <?php
}
?>
