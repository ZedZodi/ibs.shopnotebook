<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

if ($this->arResult['NOTEBOOK']) {
    ?>
    <div class="notebook-detail">
        <h1><?= $this->arResult['NOTEBOOK']['NAME'] ?></h1>
        <p>Год выпуска: <?= $this->arResult['NOTEBOOK']['YEAR'] ?></p>
        <p>Цена: <?= $this->arResult['NOTEBOOK']['PRICE'] ?></p>
    </div>
    <?php
} else {
    echo 'Ноутбук не найден.';
}
