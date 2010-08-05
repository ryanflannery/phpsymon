<?php
function display_cpus(&$cpus)
{
   global $config;

   if (!isset($cpus))
   {  echo "No CPU information available";
      return;
   }

   ?>
   <!-- BEGIN: CPU INFORMATION -->
   <h2>CPU(s)</h2>
   <table class='datum_section'>

   <tr>
      <th>&#35;</th>
      <th width='100%'></th>
      <th>Usr</th>
      <th>Nic</th>
      <th>Sys</th>
      <th>int</th>
      <th>Idl</th>
   </tr>

   <?php foreach ($cpus as $cpu) { ?>
      <tr>
         <td><?php echo $cpu['name']; ?>:</td>
         <td><?php
            echo statusbar(array($cpu['user'] => 'red',
                                 $cpu['nice'] => 'purple',
                                 $cpu['system'] => 'yellow',
                                 $cpu['interrupt'] => 'blue',
                                 $cpu['idle'] => 'green'));
         ?></td>
         <td class='num'><?php echo sprintf("%.1f", $cpu['user']); ?></td>
         <td class='num'><?php echo sprintf("%.1f", $cpu['nice']); ?></td>
         <td class='num'><?php echo sprintf("%.1f", $cpu['system']); ?></td>
         <td class='num'><?php echo sprintf("%.1f", $cpu['interrupt']); ?></td>
         <td class='num'><?php echo sprintf("%.1f", $cpu['idle']); ?></td>
      </tr>
   <?php } ?>

   <tr>
      <td colspan='7'>
      <small>
         <?php echo colorsquare('red'); ?>      = User
         <?php echo colorsquare('purple'); ?>   = Nice
         <?php echo colorsquare('yellow'); ?>   = System
         <?php echo colorsquare('blue'); ?>     = Interrupt
         <?php echo colorsquare('green'); ?>    = Idle
      </small>
      </td>
   </tr>

   </table>
   <!-- BEGIN: CPU INFORMATION -->
<?php } ?>
