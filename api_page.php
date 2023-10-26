<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
include 'template/head.php';
?>
<body>
<h1>API Response</h1>
<div id="json-container"></div>
<script src="js/api.js"></script>
</body>
</html>