<?php

require 'vendor\autoload.php';
use Symfony\Component\DomCrawler\Crawler;

function skin_already_in_array($skinArray,$newSkin) {
	$alreadyInArray = false;	

	foreach ($skinArray as $skins => $skinIn) {
		if ($skinIn['full_name'] == $newSkin) {
			$alreadyInArray = true;

			// echo 'skin in array = '. $skinIn['full_name'];
			// echo 'new skin = '. $newSkin. '</br>';
		}
	}
	return $alreadyInArray;
}

function make_links($colection,$page) {
	$new_link = $colection ."#p" .$page. "_price_asc";
	// echo 'schort link = #p'  .$page. "_price_asc";
	return $new_link;
}

	function round_up($number, $precision = 1)
{
    $fig = (int) str_pad('1', $precision, '0');
    return (ceil($number * $fig) / $fig);
};


function get_pages_count($colection) {
		$content = file_get_contents($colection);

		$crawler = new Crawler();
		$crawler->addContent($content);

		$skin_count_in_colection =  $crawler->filterXPath('//span[@id="searchResults_total"]')->text();
 		$pages =  $skin_count_in_colection / 10;
 		$pages = round_up($pages, $precision = 1);
 		// return $pages;
 		return array($pages, $skin_count_in_colection);
}	

function get_page_content($colection) {

		$skinArray = array();

		// $pages = get_pages_count($colection)[0];
		// echo '</br> pages = ' . $pages;

		// $skinCount = get_pages_count($colection)[1];
		// echo '</br> skin count = ' . $skinCount;

		// while ( count($skinCollectionArray) <= $skinCount) {
			
		// 	echo '+';
			
			// for ($i=1; $i <= $pages; $i++) {   -------------------------- page loop

				// echo 'for i=' . $i . '</br>';
				
				// $link = make_links($colection,1); //// make link with with page   -------- change for i

				// $content = file_get_contents($link);
				 $content = file_get_contents('http://steamcommunity.com/market/search?q=&category_730_ItemSet%5B%5D=tag_set_bravo_ii&category_730_ProPlayer%5B%5D=any&category_730_StickerCapsule%5B%5D=any&category_730_TournamentTeam%5B%5D=any&category_730_Weapon%5B%5D=any&category_730_Rarity%5B%5D=tag_Rarity_Common_Weapon&appid=730#p1_price_asc');

				 echo $content;

				$crawler = new Crawler();
				$crawler->addContent($content);

				 $skin_count_in_colection =  $crawler->filterXPath('//span[@id="searchResults_total"]')->text();
			 	 $pages =  $skin_count_in_colection / 10;
			 	 $pages = round_up($pages, $precision = 1);

				$nodeValues = $crawler->filterXPath('//a[@class="market_listing_row_link"]')->each(function (Crawler $node, $i) {
					// var_dump($node);


					$full_name =  $node->filterXPath('//span[@class="market_listing_item_name"]')->text();
					preg_match('/\((.+)\)/i', $full_name, $matches);
					$quality = $matches[1];
					preg_match('/(.+)\s\|/i', str_replace('StatTrak™ ', '', $full_name), $matches);
					$weapon = $matches[1];
					preg_match('/\|\s(.*)\s\(/i', $full_name, $matches);
					$skin_name = $matches[1];
					 // echo '</br> ' . $full_name;
					return [
						'full_name' => $full_name,
						'link' => $node->attr('href'),
						'start_trek' => (stripos($full_name, 'StatTrak')) !== false ? true : false,
						'quality' => $quality,
						'weapon' => $weapon,
						'skin_name' => $skin_name,
						'normal_price' => $node->filterXPath('//span[@class="normal_price"]')->text(),
						'sale_price' => $node->filterXPath('//span[@class="sale_price"]')->text(),
						'quantity' => $node->filterXPath('//span[@class="market_listing_num_listings_qty"]')->text(),
						];
				});

				// foreach ($nodeValues as $skins => $skin) {
				// 	// array_push($skinArray, $skin);

				// 	if (skin_already_in_array($skinArray,$skin['full_name']) == true) {
				// 		// echo 'skin already in array';
				// 	} else {
				// 		array_push($skinArray, $skin);
				// 	}
				// }

				$skinArray = array_merge($skinArray, $nodeValues);
				// var_dump($skinArray);
				// $skinArray = array_unique($skinArray);

			// } // for end   - ---------------------------- page loop end
	// }//while end

	// return $skinArray;
	return $nodeValues;
} // get pages end 

