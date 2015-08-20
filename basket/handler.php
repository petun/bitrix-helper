<?
//require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

require_once("Basket.php");
require_once("BasketServiceObserver.php");
require_once("BasketHandler.php");

$basket = new Basket(new BitrixItemResolver('PRICE'));
$basket->attach(new BasketServiceObserver());
$handler = new BasketHandler($basket);
$handler->process();

//require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");




