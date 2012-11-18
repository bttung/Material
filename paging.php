<p class="pagingLink">
  <?php if($totalPages_rsMaterial > 1) echo $pageNum_rsMaterial." in ".$totalPages_rsMaterial;  ?>
  
  <?php if ($pageNum_rsMaterial > 0) { // Show if not first page ?>
    <a href="<?php printf("%s?pageNum_rsMaterial=%d%s", $currentPage, 0, $queryString_rsMaterial); ?>">&lt;&lt; First</a> <a href="<?php printf("%s?pageNum_rsMaterial=%d%s", $currentPage, max(0, $pageNum_rsMaterial - 1), $queryString_rsMaterial); ?>">&lt;</a> 
    <?php } // Show if not first page ?>
  <?php if ($pageNum_rsMaterial < $totalPages_rsMaterial) { // Show if not last page ?>
    <a href="<?php printf("%s?pageNum_rsMaterial=%d%s", $currentPage, min($totalPages_rsMaterial, $pageNum_rsMaterial + 1), $queryString_rsMaterial); ?>"> &gt;</a> <a href="<?php printf("%s?pageNum_rsMaterial=%d%s", $currentPage, $totalPages_rsMaterial, $queryString_rsMaterial); ?>">Last &gt;&gt;</a>
    <?php } // Show if not last page ?>
</p>