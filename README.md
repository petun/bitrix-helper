# bitrix-helper
Bitrix Helper Classes 

# Typical Apache Configuration
```
<VirtualHost *:80>
    DocumentRoot "/Users/petun/Sites/elprocom"
    ServerName elprocom.local    
    ErrorLog "/private/var/log/apache2/elprocom.org-error_log"
    CustomLog "/private/var/log/apache2/elprocom.org-access_log" common

    <IfModule mod_php5.c>
     php_value default_charset utf8
     php_admin_value mbstring.func_overload 2
     php_value mbstring.internal_encoding UTF-8
     php_admin_value realpath_cache_size "4096k"
    </IfModule>
</VirtualHost>
```

## Transfer site. Database settings:
- /bitrix/.settings.php
- /bitrix/php_interface/dbconn.php


## Register main app objects for IDE:
```php
<?php /* @var CMain $APPLICATION */ 
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
```


## Typical Template Example
```html
<head>
  ....	
	<?$APPLICATION->ShowHead();?>
  ....
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/style.css">
	...
	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
 <div id="panel"><?$APPLICATION->ShowPanel();?></div>
 <h1><?$APPLICATION->ShowTitle(false);?></h1>
 ...
```



# Components
## Include Component
```php
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/test.php"
	)
);?>
```


## Menu Component
```php
<?$APPLICATION->IncludeComponent(
	"bitrix:menu",  
	".default",  // template
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"ROOT_MENU_TYPE" => "top", // menu type
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
```

# Api Examples
## Resize Image
```php
// zoom crop example
<?
$file = $arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'];
$photo = CFile::ResizeImageGet($file, array("width"=>300, "height"=>200), BX_RESIZE_IMAGE_EXACT, false);

$photo = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array("width"=>553, "height"=>300), BX_RESIZE_IMAGE_EXACT, false);
?>
<img src="<?=$photo['src'];?>" alt="" />
```


## Site Settings
```php
<?
$rsSites = CSite::GetByID("s1");
$arSite = $rsSites->Fetch();
?>
Array
(
    [LID] => s1
    [SORT] => 1
    [DEF] => Y
    [ACTIVE] => Y
    [NAME] => Sitename
    [DIR] => /
    [FORMAT_DATE] => DD.MM.YYYY
    [FORMAT_DATETIME] => DD.MM.YYYY HH:MI:SS
    [FORMAT_NAME] => #NAME# #LAST_NAME#
    [WEEK_START] => 1
    [CHARSET] => UTF-8
    [LANGUAGE_ID] => ru
    [DOC_ROOT] => 
    [DOMAIN_LIMITED] => N
    [SERVER_NAME] => 
    [SITE_NAME] => Sitename
    [EMAIL] => 
    [CULTURE_ID] => 1
    [ID] => s1
    [length(L.DIR)] => 1
    [ifnull(length(L.DOC_ROOT), 0)] => 0
    [DIRECTION] => Y
    [DOMAINS] => 
    [ABS_DOC_ROOT] => /Users/petun/Sites/sitename
)

```


## Usefull arItem variables
```php
$arItem['NAME'];
$arItem['DISPLAY_PROPERTIES']['propName']['DISPLAY_VALUE'];
$arItem['PREVIEW_PICTURE'];
$arItem['PREVIEW_TEXT'];
$arItem['~PREVIEW_TEXT']; // raw data
$arItem["DETAIL_PAGE_URL"];
$arParams["DISPLAY_PICTURE"];
$arResult["DETAIL_PICTURE"]["SRC"];
$arResult["DETAIL_PICTURE"]["TITLE"];
$arResult["DISPLAY_ACTIVE_FROM"]; // date


```
