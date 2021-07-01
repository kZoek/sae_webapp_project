<?php
// XSS defense
 function escape($str){
     return htmlentities($str,ENT_QUOTES,'UTF-8');
 }
?>