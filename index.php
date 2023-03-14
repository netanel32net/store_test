<?php session_start();
error_reporting(0);
include_once('includes/config.php');
include_once('includes/header.php');
include_once('includes/topBar.php');
?>
<?php include('includes/products3index.php'); ?>
<!-- include('includes/product_deal.php');  אם אתה מוחק פה, תמחק גם תקובץ במערכת-->
<?php include_once('includes/sidebar.php'); ?>
<?php include('includes/list_products2.php'); ?>
        <!-- page 1 of ... -->
<?php include('includes/onetwopage.php'); ?>
        <!-- includes/pageEmail -->
<?php include_once('includes/pageEmail.php'); ?>

        <!-- Footer-->
<?php include_once('includes/footer.php'); ?>

