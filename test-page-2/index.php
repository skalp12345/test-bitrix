<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs('https://code.jquery.com/jquery-3.6.0.min.js');

if (CModule::IncludeModule('iblock')) {
	$products = [];
	$arOrder = Array("NAME" => "ASC");
	$arSelect = Array("ID", "NAME","DETAIL_PAGE_URL");
	$arFilter = Array("IBLOCK_ID" => 17);
	$res = CIBlockElement::GetList($arOrder, $arFilter, false, Array(), $arSelect);
	while($ob = $res->GetNextElement())
	{
	 $arFields = $ob->GetFields();
	 array_push($products, $arFields);
	}
}?>

<table class="table">
	<thead>
		<tr>
			<td>Наименование</td>
			<td>Розничная цена</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($products as $value): ?>
			<tr>
				<td>
					<a href="<?=$value["DETAIL_PAGE_URL"];?>"><?=$value["NAME"];?></a>
				</td>
				<td>
					<? 
					$price = CPrice::GetBasePrice($value["ID"]);
					echo number_format($price["PRICE"],0,0,'');
					?> 
					₽
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<style>
	.table .active {
		background: #ccc;
	}
</style>

<script>
	$(document).ready(function() {
	    $('.table tr').on('click', function(){
	    	$(this).toggleClass('active');
	    	$('.table tr').not(this).removeClass('active');
		});
	});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>