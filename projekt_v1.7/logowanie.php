<?php
include('cfg.php');
include('showpage.php');
include('admin/admin.php');
include('contact.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

?>
<p><a href="contact.php">Skontaktuj się z nami</a></p>
<p><a href="contact.php?action=przypomnij">Przypomnij hasło</a></p>
    <div id="logowanie">
        <?php
        echo FormularzLogowania();
        ?>
    </div>
</html>