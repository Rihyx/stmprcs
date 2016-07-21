<?php

require 'vendor\autoload.php';
use Symfony\Component\DomCrawler\Crawler;

function make_links($colection,$page) {	
	return preg_replace('/start=\d+/', 'start=' . $page . '0', $colection);
}

	function round_up($number, $precision = 1) {
    $fig = (int) str_pad('1', $precision, '0');
    return (ceil($number * $fig) / $fig);
};


function get_pages_count($colection) {
	$content = file_get_contents($colection);
	$content = json_decode($content);
	$skinCount = $content->total_count;
	$pages = round_up($skinCount / 10,$precision = 1);
	return array($pages, $skinCount);
}


function get_content2($link) {
		$skinArray = array();
		
		if ($link!='') {
			// echo 'link is full';
					
				// echo 'pages = '. get_pages_count($link)[0]. '</br>';
				// echo 'skin count = '. get_pages_count($link)[1]. '</br>';
			for ($i=0; $i < get_pages_count($link)[0]; $i++) { 
				$newLink = make_links($link,$i);
				// echo $newLink . '</br>';
				// echo 'i = ' . $i . '</br>';
			

				$content = file_get_contents($newLink);
				$content = json_decode($content);

				$htmlContent = $content->results_html;
				$htmlCOntentClean = html_entity_decode($htmlContent);

				$crawler = new Crawler();
				$crawler->addContent($htmlCOntentClean);

				$nodeValues = $crawler->filterXPath('//a[@class="market_listing_row_link"]')->each(function (Crawler $node, $i) {
					$full_name =  $node->filterXPath('//span[@class="market_listing_item_name"]')->text();
					preg_match('/\((.+)\)/i', $full_name, $matches);
					$quality = $matches[1];
					preg_match('/(.+)\s\|/i', str_replace('StatTrak™ ', '', $full_name), $matches);
					$weapon = $matches[1];
					preg_match('/\|\s(.*)\s\(/i', $full_name, $matches);
					$skin_name = $matches[1];
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
							
				$skinArray = array_merge($skinArray, $nodeValues);
				unset($nodeValues);
				unset($content);
				sleep(1);
			}// for end
			return $skinArray;
		} else {
			return 'empty';
		}/// is not empty 
	 // return $skinArray;
}// function get_content2 end

?>
