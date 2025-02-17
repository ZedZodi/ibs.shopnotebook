<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("NOTEBOOK_DETAIL_NAME"),
    "DESCRIPTION" => GetMessage("NOTEBOOK_DETAIL_DESCRIPTION"),
    "ICON" => "/images/catalog.gif",
    "COMPLEX" => "N",
    "SORT" => 10,
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "notebook",
            "NAME" => GetMessage("NOTEBOOK_DETAIL_CATALOG"),
            "SORT" => 30,
        )
    )
);
?>
