<?php
ob_start();
require_once('header.php');
?>
<!--Message to replace standard 404 error message -->
<p class="well">
    Oops!!!! We don't seem to have that page...please try one of the above links.
</p>

<?php 
require_once('footer.php'); 
ob_flush();
?>