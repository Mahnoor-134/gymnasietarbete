<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST, $_FILES);
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="test" value="hej">
    <input type="file" name="bild">
    <button type="submit">Skicka</button>
</form>
