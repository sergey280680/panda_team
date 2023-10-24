<?php
if (isset($_SESSION['user']['name_surveys']) && is_array($_SESSION['user']['name_surveys'])) {
    foreach ($_SESSION['user']['name_surveys'] as $id => $name) {
        echo  "<li>
                   <a class='nav-link' href='survey_page.php?id={$id}' >$name</a> 
              </li>";
    }
}
?>