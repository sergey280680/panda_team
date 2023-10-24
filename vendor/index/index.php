<?php
if ($_SESSION['message']) {
    $class = ($_SESSION['message_type'] == 'error') ? 'msg error' : 'msg success';
    echo '<div class="' . $class . '">' . $_SESSION['message'] . '</div>';
}
unset($_SESSION['message'], $_SESSION['message_type']);
?>