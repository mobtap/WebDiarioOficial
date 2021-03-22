<?php
 $file = $_REQUEST['arquivo'];
?>
<!-- 4:3 aspect ratio -->
<div class="embed-responsive embed-responsive-4by3">
  <iframe class="embed-responsive-item" width="100%" height="98%" frameborders="0" src="<?=$file?>"></iframe>
</div>
