<?php session_start(); ?>
<?php header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"'); ?>
<?php header('Pragma: no-cache'); ?>
<?php header('Cache-Control: private, no-store, no-cache, must-revalidate'); ?>
<?php header("Location: ".$_GET['to']); ?>