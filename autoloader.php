<?php
foreach (glob("src/*.php") as $filename){
    require_once($filename);
}
