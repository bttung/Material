<!--
/*
<table border="1" cellpadding="1" cellspacing="1">
  <tr>
    <td>id</td>
    <td>fileName</td>
  </tr>
  
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsFile['id']; ?></td>
      <td>
	  	<?php 
			echo $row_rsFile['fileName']; 
			$searchFileName = $row_rsFile['fileName'];
			if (searchInPDF("FAX", $searchFileName )) echo "PDF内にある";
		?>
      </td>
    </tr>
    <?php } while ($row_rsFile = mysql_fetch_assoc($rsFile)); ?>
</table>

*/
-->