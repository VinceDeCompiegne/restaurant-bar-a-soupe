<?php
$reservation = (isset($_GET['err']) && !empty($_GET['err'])) ? htmlspecialchars($_GET['err']) : null;
echo $reservation;
?>