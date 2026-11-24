<?php

//initiera sessionshantering
session_start();

//radera all information i sessionsvariabler
session_unset(); 

//Avslutaŕ den aktuell sesssionen
session_destroy();

//skicka användaren till startsidan
header('Location: index.php');

?>