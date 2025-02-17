<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("NOTEBOOK_COMPLEX_NAME"),
    "DESCRIPTION" => GetMessage("NOTEBOOK_COMPLEX_DESCRIPTION"),
    "COMPLEX" => "Y",
    "SORT" => 10,
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "notebook",
            "NAME" => GetMessage("NOTEBOOK_COMPLEX_CATALOG"),
            "SORT" => 30,
        )
    )
);
?>
