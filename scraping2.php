<?php
    $xml  = simplexml_load_file('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml?5105e8233f9433cf70ac379d6ccc5775');
    $xml->registerXPathNamespace('d', 'http://www.ecb.int/vocabulary/2002-08-01/eurofxref');
    $list = $xml->xpath('//d:Cube[@currency and @rate]');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>xpath</title>
   </head>
   <body>
       <table>
           <tr>
               <th>currency</th>
               <th>rate</th>
           </tr>
           <?php $cube ?>
           <?php foreach ($list as $cube): ?>
           <?php $attrs = $cube->attributes(); ?>
           <tr>
               
               <td><?php echo $attrs['currency']; ?></td>
               <td><?php echo $attrs['rate']; ?></td>
           </tr>
           <?php endforeach; ?>

        </table>
    </body>
</html>