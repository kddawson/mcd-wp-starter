<?php
/**
 * install.php replacement page
 * See: http://perishablepress.com/press/2009/05/05/important-security-fix-for-wordpress/
 * Fix 1: nuke wp-admin/install.php
 * Fix 2: block access via htaccess
 * Fix 3: this file (may be replaced during updates - check)
 *
 */
?>
<?php header("HTTP/1.1 503 Service Temporarily Unavailable"); ?>
<?php header("Status 503 Service Temporarily Unavailable"); ?>
<?php header("Retry-After 3600"); // 60 minutes ?>
<?php mail("support@example.com", "Database Error", "D'oh! There's a problem with the database."); ?>

<!DOCTYPE html>
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Error Establishing Database Connection</title>
    </head>
    <body>
        <img src="images/wordpress-logo.png" alt="WordPress">
        <h1>Error Establishing Database Connection</h1>
        <p>We are currently experiencing database issues. Please check back shortly. Thank you.</p>
    </body>
</html>
