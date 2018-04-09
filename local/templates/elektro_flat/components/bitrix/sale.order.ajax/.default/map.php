<?define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
__IncludeLang($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/bitrix/sale.order.ajax/lang/'.LANGUAGE_ID.'/map.php');

CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

$location = "";
$arStore = array();
$arStoreId = array();

if($_REQUEST["delivery"]) {
	$deliveryId = IntVal($_REQUEST["delivery"]);

	$dbDelivery = CSaleDelivery::GetList(
		array("SORT" => "ASC"),
		array("ID" => $deliveryId),
		false,
		false,
		array("ID", "STORE")
	);
	$arDelivery = $dbDelivery->Fetch();

	if(count($arDelivery) > 0 && strlen($arDelivery["STORE"]) > 0) {
		$arStoreInfo = unserialize($arDelivery["STORE"]);
		foreach($arStoreInfo as $val)
			$arStoreId[$val] = $val;
	}

	$arStoreLocation = array("yandex_scale" => 11, "PLACEMARKS" => array());

	$siteId = substr($_REQUEST["siteId"], 0, 2);

	$dbList = CCatalogStore::GetList(
		array("SORT" => "DESC", "ID" => "ASC"),
		array("ACTIVE" => "Y", "ID" => $arStoreId, "ISSUING_CENTER" => "Y", "+SITE_ID" => $siteId),
		false,
		false,
		array("ID", "SORT", "TITLE", "ADDRESS", "DESCRIPTION", "IMAGE_ID", "PHONE", "SCHEDULE", "GPS_N", "GPS_S", "SITE_ID", "ISSUING_CENTER", "EMAIL")
	);
	while($arStoreTmp = $dbList->Fetch()) {
		$arStore[$arStoreTmp["ID"]] = $arStoreTmp;

		if(intval($arStoreTmp["IMAGE_ID"]) > 0) {
			$arStore[$arStoreTmp["ID"]]["IMAGE"] = CFile::ResizeImageGet($arStoreTmp["IMAGE_ID"], array("width" => 50, "height" => 50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		}

		if(floatval($arStoreLocation["yandex_lat"]) <= 0)
			$arStoreLocation["yandex_lat"] = $arStoreTmp["GPS_N"];

		if(floatval($arStoreLocation["yandex_lon"]) <= 0)
			$arStoreLocation["yandex_lon"] = $arStoreTmp["GPS_S"];

		$arLocationTmp = array();
		$arLocationTmp["ID"] = $arStoreTmp["ID"];
		if(strlen($arStoreTmp["GPS_N"]) > 0)
			$arLocationTmp["LAT"] = $arStoreTmp["GPS_N"];
		if(strlen($arStoreTmp["GPS_S"]) > 0)
			$arLocationTmp["LON"] = $arStoreTmp["GPS_S"];
		if(strlen($arStoreTmp["TITLE"]) > 0)
			$arLocationTmp["TEXT"] = $arStoreTmp["TITLE"]."\r\n".$arStoreTmp["DESCRIPTION"];

		$arStoreLocation["PLACEMARKS"][] = $arLocationTmp;
	}

	$location = serialize($arStoreLocation);
}

$showImages = (isset($_REQUEST["showImages"]) && $_REQUEST["showImages"] == "Y") ? true : false;?>

<html>
	<head>
		<?$APPLICATION->ShowHead();?>
	</head>
	<body>
		<?$rnd = "or".randString(4);?>
		<table class="data">
			<tr>
				<td width="50%" class="map">
					<div class="view_map">
						<?$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default",
							Array(
								"INIT_MAP_TYPE" => "MAP",
								"MAP_DATA" => $location,
								"MAP_WIDTH" => "100%",
								"MAP_HEIGHT" => "400",
								"CONTROLS" => array(0 => "TYPECONTROL",),
								"OPTIONS" => array(0 => "ENABLE_SCROLL_ZOOM", 1 => "ENABLE_DRAGGING",),
								"MAP_ID" => $rnd,
							)
						);?>
					</div>
				</td>
				<td width="50%" class="ora-store">
					<script>
						var arStore = <?=CUtil::PhpToJSObject($arStore);?>;
						var objName = '<?=$rnd?>';
					</script>
					<div class="ora-storelist">
						<table id="store_table">
							<?$i = 1;
							$countCount = count($arStore);
							$arDefaultStore = array_shift(array_values($arStore));
                            
							foreach($arStore as $val) {
                                //$checked = ($val["ID"] == $arDefaultStore["ID"]) ? "checked" : "";
								$checked = ($val["ID"] == $_POST["BUYER_STORE"]) ? "checked" : "";?>
								<tr class="store_row <?=$checked?>" id="row_<?=$val["ID"]?>" onclick="setChangeStore(<?=$val["ID"]?>);">
									<?if($showImages) {?>
										<td class="image">
											<?if(intval($val["IMAGE_ID"]) > 0):?>
												<img src="<?=$val["IMAGE"]["src"]?>" width="<?=$val["IMAGE"]["width"]?>" height="<?=$val["IMAGE"]["height"]?>" />
											<?else:?>
												<img src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" width="50px" height="50px" />
											<?endif;?>
										</td>
									<?}?>
									<td class="info">
										<div class="name">
											<?=htmlspecialcharsbx($val["TITLE"])?>
										</div>
										<?if(!empty($val["PHONE"])):?>
											<div class="phone">
												<?=GetMessage('MAP_PHONE');?>: <?=htmlspecialcharsbx($val["PHONE"])?>
											</div>
										<?endif;
										if(!empty($val["EMAIL"])):?>
											<div class="email">
												<?=GetMessage('MAP_EMAIL');?>: <a href="mailto:<?=htmlspecialcharsbx($val["EMAIL"])?>"><?=htmlspecialcharsbx($val["EMAIL"])?></a>
											</div>
										<?endif;
										if(!empty($val["ADDRESS"])):?>
											<div class="adres">
												<?=GetMessage('MAP_ADRES');?>: <?=htmlspecialcharsbx($val["ADDRESS"])?>
											</div>
										<?endif;
										if(!empty($val["SCHEDULE"])):?>
											<div class="shud">
												<?=GetMessage('MAP_WORK');?>: <?=htmlspecialcharsbx($val["SCHEDULE"])?>
											</div>
										<?endif;
										if(!empty($val["DESCRIPTION"])):?>
											<div class="desc">
												<?=GetMessage('MAP_DESC');?>: <?=htmlspecialcharsbx($val["DESCRIPTION"])?>
											</div>
										<?endif;?>
									</td>
								</tr>
								<?$i++;
							}?>
						</table>
					</div>
				</td>
			</tr>
		</table>
		<input type="hidden" name="POPUP_STORE_ID" id="POPUP_STORE_ID" value="<?=$arDefaultStore["ID"]?>" >
		<input type="hidden" name="POPUP_STORE_NAME" id="POPUP_STORE_NAME" value="<?=$arDefaultStore["TITLE"]?>" >
				
		<script type="text/javascript">
			function setChangeStore(id) {
				var store = arStore[id];

				BX('POPUP_STORE_ID').value = id;
				BX('POPUP_STORE_NAME').value = BX.util.htmlspecialchars(store["TITLE"]);

				var tbl = BX('store_table');
				for(var i = 0; i < tbl.getElementsByTagName('tr').length; i++)
					BX.removeClass(BX(tbl.getElementsByTagName('tr')[i].id), 'checked');

				BX.addClass(BX('row_' + id), 'checked');

				if(window.GLOBAL_arMapObjects[objName])
					window.GLOBAL_arMapObjects[objName].panTo([parseFloat(store["GPS_N"]), parseFloat(store["GPS_S"])], {flying: 1});
			}
			if(BX('BUYER_STORE') && parseInt(BX('BUYER_STORE').value) > 0) {
				BX('POPUP_STORE_ID').value = BX('BUYER_STORE').value;
				BX('POPUP_STORE_NAME').value =  BX.util.htmlspecialchars(arStore[BX('BUYER_STORE').value]["TITLE"]);
			}
		</script>
				
		<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
	</body>
</html>