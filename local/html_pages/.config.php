<?
$arHTMLPagesOptions = array(
	"INCLUDE_MASK" => "/*",
	"EXCLUDE_MASK" => "/bitrix/*; /404.php; ",
	"FILE_QUOTA" => "100",
	"BANNER_BGCOLOR" => "#0c9a88",
	"BANNER_STYLE" => "white",
	"STORAGE" => "files",
	"ONLY_PARAMETERS" => "id; ELEMENT_ID; SECTION_ID; PAGEN_1; ",
	"IGNORED_PARAMETERS" => "utm_source; utm_medium; utm_campaign; utm_content; fb_action_ids; utm_term; yclid; gclid; _openstat; from; referrer1; r1; referrer2; r2; referrer3; r3; ",
	"WRITE_STATISTIC" => "Y",
	"EXCLUDE_PARAMS" => "ncc; ",
	"COMPOSITE" => "Y",
	"~INCLUDE_MASK" => array(
		0 => "'^/.*?\$'",
	),
	"~EXCLUDE_MASK" => array(
		0 => "'^/bitrix/.*?\$'",
		1 => "'^/404\\.php\$'",
	),
	"~FILE_QUOTA" => "104857600",
	"INDEX_ONLY" => "",
	"~GET" => array(
		0 => "id",
		1 => "ELEMENT_ID",
		2 => "SECTION_ID",
		3 => "PAGEN_1",
	),
	"~IGNORED_PARAMETERS" => array(
		0 => "utm_source",
		1 => "utm_medium",
		2 => "utm_campaign",
		3 => "utm_content",
		4 => "fb_action_ids",
		5 => "utm_term",
		6 => "yclid",
		7 => "gclid",
		8 => "_openstat",
		9 => "from",
		10 => "referrer1",
		11 => "r1",
		12 => "referrer2",
		13 => "r2",
		14 => "referrer3",
		15 => "r3",
	),
	"~EXCLUDE_PARAMS" => array(
		0 => "ncc",
	),
	"COMPRESS" => "1",
	"STORE_PASSWORD" => "Y",
	"COOKIE_LOGIN" => "BITRIX_SM_LOGIN",
	"COOKIE_PASS" => "BITRIX_SM_UIDH",
	"COOKIE_NCC" => "BITRIX_SM_NCC",
	"COOKIE_CC" => "BITRIX_SM_CC",
	"COOKIE_PK" => "BITRIX_SM_PK",
	"NO_PARAMETERS" => "N",
	"ALLOW_HTTPS" => "",
	"GROUPS" => array(
	),
	"DOMAINS" => array(
		"terramic.ru" => "terramic.ru",
	),
	"AUTO_UPDATE" => "Y",
	"AUTO_UPDATE_TTL" => "120",
	"FRAME_MODE" => "Y",
	"FRAME_TYPE" => "DYNAMIC_WITH_STUB",
	"AUTO_COMPOSITE" => "Y",
);
?>