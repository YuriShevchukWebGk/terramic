<?$APPLICATION->IncludeComponent("bitrix:menu", "top_catalog", array(
	"ROOT_MENU_TYPE" => "top_catalog",
	"MENU_CACHE_TYPE" => "A",
	"MENU_CACHE_TIME" => "3600000",
	"MENU_CACHE_USE_GROUPS" => "N",
	"MENU_CACHE_GET_VARS" => array(),
	"CACHE_SELECTED_ITEMS" => "N",
	"MAX_LEVEL" => \Bitrix\Main\Config\Option::get("aspro.optimus", "MAX_DEPTH_MENU", 2),
	"CHILD_MENU_TYPE" => "left",
	"USE_EXT" => "Y",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N",
	),false
);?>