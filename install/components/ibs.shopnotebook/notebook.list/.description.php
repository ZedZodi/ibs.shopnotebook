<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("NOTEBOOK_LIST_NAME"),
    "DESCRIPTION" => GetMessage("NOTEBOOK_LIST_DESCRIPTION"),
    "COMPLEX" => "N",
    "SORT" => 10,
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "notebook",
            "NAME" => GetMessage("NOTEBOOK_LIST_CATALOG"),
            "SORT" => 30,
        )
    )
);
?>
