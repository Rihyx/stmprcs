<?php

function sort_with_quality($grade) {
	if ($grade != 'empty') {
		$BattleScarred = array();
		$WellWorn = array();
		$FieldTested = array();
		$MinimalWear = array();
		$FactoryNew = array();	

		foreach ($grade as $skins => $skin) {
			if ($skin['start_trek'] == false) {

				if ($skin['quality'] == 'Battle-Scarred') {
					$BattleScarred[] = $skin;
				}
				if ($skin['quality'] == 'Well-Worn') {
					$WellWorn[] = $skin;
				}
				if ($skin['quality'] == 'Field-Tested') {
					$FieldTested[] = $skin;
				}
				if ($skin['quality'] == 'Minimal Wear') {
					$MinimalWear[] = $skin;
				}
				if ($skin['quality'] == 'Factory New') {
					$FactoryNew[] = $skin;
				}
			}
		}// fore end
	}//if empty end
return  array($BattleScarred, $WellWorn, $FieldTested, $MinimalWear, $FactoryNew);
}

function make_calculation($grade1, $grade2) {
	$skinsWithProfit = array();
	$skinsWithProfitCount = 0;
	$skinsDisadvantageCount = 0;

	if (($grade1 != 'empty') && ($grade2 != 'empty')) {
		foreach ($grade1 as $grade1SkinsArray => $grade1Skin) {
			foreach ($grade2 as $grade2SkinsArray => $grade2Skin) {
				if ($grade1Skin['quality'] == $grade2Skin['quality']) {
					if (($grade1Skin['start_trek'] == false) && ($grade2Skin['start_trek'] == false)) {
						
						$lowSkinSum = $grade1Skin['normal_price']*10;
						$betterSkinPriceWithPercent = $grade2Skin['normal_price']*0.87;

						if ($lowSkinSum > $betterSkinPriceWithPercent) {
							$profit = $betterSkinPriceWithPercent - $lowSkinSum;
							$skinsWithProfitCount++;
							$skinsWithProfit[] = [
													'skin to buy' => $grade1Skin,
													'skin with profit' => $grade2Skin,
													'profit' => $profit,
													'' => '',
												];

						} else {
							$skinsDisadvantageCount++;
						}

					}//stattrek
				}
			}
		}
	}
}

?>