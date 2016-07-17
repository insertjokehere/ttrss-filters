<?php
class Af_Comics_Gunnerkrigg extends Af_ComicFilter {

	function supported() {
		return array("Gunnerkrigg Court");
	}

	function process(&$article) {
		$owner_uid = $article["owner_uid"];

		if (strpos($article["link"], "gunnerkrigg.com") !== FALSE) {

				$doc = new DOMDocument();
				@$doc->loadHTML(fetch_file_contents($article["link"]));

				$basenode = false;

				if ($doc) {
					$xpath = new DOMXPath($doc);
					$basenode = $xpath->query('(//img[@class="comic_image"])')->item(0);

					if ($basenode) {
                        $basenode->setAttribute("src","http://www.gunnerkrigg.com".$basenode->getAttribute("src")); //The image URL on the site does not contain a domain component, only a path
						$article["content"] = $doc->saveXML($basenode) . "<br />" . $article["content"];
					}
				}

			return true;
		}

		return false;
	}
}
?>
