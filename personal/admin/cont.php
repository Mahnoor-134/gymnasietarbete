<?php

var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_SERVER['CONTENT_LENGTH']);
var_dump($_POST);
var_dump($_FILES);

exit;

?>
<form method="POST" enctype="multipart/form-data">

    <input type="text" name="car_model" value="BMW">

    <button type="submit">Test</button>

</form>
<label for="image">Image:</label>
<input
    type="file"
    id="image"
    name="image"
    accept="image/jpeg,image/png,image/webp"
>
