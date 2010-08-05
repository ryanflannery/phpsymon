<?php

function display_mem(&$memory)
{  global $config;

   if (!isset($memory))
   {  echo "No MEM information available.";
      return;
   }

   // Calculate the total amount of main memory present
   $mem = array_shift($memory);
   $total = $mem['real_total'] + $mem['free'];

   ?>
   <h2>Memory</h2>
   <table class='datum_section'>
   <tr>
      <td><b>Main:</b></td>
      <td>
         <table width='100%'>
         <tr>
            <td style='white-space: nowrap;'>
               <b>Active/Used/Free:</b>
               <?php
               // Display main memory amounts
               echo fmtmem($mem['real_active']) . "&nbsp;/&nbsp;";
               echo fmtmem($mem['real_total'])  . "&nbsp;/&nbsp;";
               echo fmtmem($mem['free']);
               ?>
            </td>
            <td style='white-space: nowrap;'>
               &nbsp;&nbsp;<b>Total:</b> <?php echo fmtmem($total); ?>
            </td>
         </tr>
         </table>
      </td>
   </tr>

      <tr>
         <td></td>
         <td><?php
            // Calculate width of various status bar colors
            $activeWidth = round(($mem['real_active'] / $total) * 100);
            $usedWidth   = ($mem['real_total'] - $mem['real_active']) / $total;
            $usedWidth   = round($usedWidth * 100);
            $freeWidth   = 100 - ($activeWidth + $usedWidth);

            echo statusbar(array($activeWidth => 'red',
                                 $usedWidth   => 'yellow',
                                 $freeWidth   => 'green'));
         ?></td>
      </tr>

   <tr>
      <td><b>Swap:</b></td>
      <td>
         <div style='float: right;'>
            <b>Total:</b> <?php echo fmtmem($mem['swap_total']); ?>
         </div>
         <b>Used / Free:</b>
         <?php
            echo fmtmem($mem['swap_used']) . "&nbsp;/&nbsp;";
            echo fmtmem($mem['swap_total'] - $mem['swap_used']);
         ?>
      </td>
   </tr>

      <tr>
         <td></td>
         <td><?php
            $usedWidth = round(($mem['swap_used'] / $mem['swap_total']) * 100);
            $freeWidth = 100 - $usedWidth;

            echo statusbar(array($usedWidth => 'red', $freeWidth => 'green'));
            ?></td>
      </tr>

      <tr>
         <td colspan='2'>
            <small>
               <?php echo colorsquare('red'); ?>      = Active
               <?php echo colorsquare('red'); ?>      +
               <?php echo colorsquare('yellow'); ?>   = Used
               <?php echo colorsquare('green'); ?>    = Free
            </small>
         </td>
      </tr>

   </table>
<?php } ?>
