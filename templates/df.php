<?php

function display_dfs(&$dfs)
{  global $alias;

   if (!isset($dfs))
   {  echo "No DF information available";
      return;
   }

   // determine if we should show the 'Mount' column or not
   $showMount = false;
   if (is_file('config/df_mounts.php'))
      require_once('config/df_mounts.php');

   foreach ($dfs as $df)
      if (isset($alias['df'][$df['name']]['mount'])) $showMount = true;

   ?>
   <h2>Filesystem(s)</h2>
   <table class='datum_section'>
   <tr>
      <td colspan='2'></td>
      <td width='100%'></td>
      <th colspan='4'>df -h</th>
      <th colspan='3'>Files</th>
      <th colspan='2'>Writes</th>
   </tr>
   <tr>
      <th>Part.</th>
      <th><?php echo ($showMount ? 'Mount' : ''); ?></th>
      <th>Usage</th>

      <th>Size</th>
      <th>Used</th>
      <th>Avail</th>
      <th>Capacity</th>

      <th>Used</th>
      <th>Avail.</th>
      <th>Total</th>
      <th>Sync.</th>
      <th>Async.</th>
   </tr>

   <?php foreach($dfs as $df) display_single_df($df); ?>

   <!-- Spacer Row - also provides bottom-border to the 'sub-tables' -->
   </table>
   <?php
}

function display_single_df(&$df)
{  global $alias;

   $blocksUsed = $df['blocks'] - $df['bfree'];
   $filesTotal = $df['files'] + $df['ffree'];
   ?>
   <tr>
      <td><?php echo $df['name']; ?>:</td>
      <td>
      <?php
      if (isset($alias['df'][$df['name']]['mount']))
         echo $alias['df'][$df['name']]['mount'];
      ?>
      </td>
      <td class='bar'><?php
         $usedWidth = round(($blocksUsed / $df['blocks']) * 100);
         $freeWidth = 100 - $usedWidth;
         echo statusbar(array($usedWidth => 'red',
                              $freeWidth => 'green'));
      ?></td>

      <td class='num'><?php echo fmtmem($df['blocks'] * 512); ?></td>
      <td class='num'><?php echo fmtmem($blocksUsed * 512); ?></td>
      <td class='num'><?php echo fmtmem($df['bavail'] * 512); ?></td>
      <td class='num'><?php echo $usedWidth; ?>%</td>

      <td class='num'><?php echo fmtnum($df['files']); ?></td>
      <td class='num'><?php echo fmtnum($df['ffree']); ?></td>
      <td class='num'><?php echo fmtnum($filesTotal); ?></td>

      <td class='num'><?php echo fmtnum($df['synwrites']); ?></td>
      <td class='num'><?php echo fmtnum($df['asyncwrites']); ?></td>
   </tr>
   <?php
}
