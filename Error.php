<?php
ob_start();
require_once('header.php');
?>
<!--Error message for unexpected errors-->
<p class="well">
    Something seems to have gone slightly wrong. But don't worry, our support team has already been notified and will get things fixed asap.
</p>

<?php 
require_once('footer.php'); 
ob_flush();
?>