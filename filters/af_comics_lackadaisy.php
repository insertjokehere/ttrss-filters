<?php
class Af_Comics_Lackadaisy extends Af_ComicFilter {

	function supported() {
		return array("Lackadaisy");
	}

	function process(&$article) {
		$owner_uid = $article["owner_uid"];

		if (strpos($article["link"], "lackadaisy.foxprints.com") !== FALSE) {

            $doc = new DOMDocument();
            @$doc->loadHTML(fetch_file_contents($article["link"]));

            $basenode = false;

            if ($doc) {
                $xpath = new DOMXPath($doc);
                $basenode = $xpath->query('(//div[@id="content"]/img)')->item(0);

                if ($basenode) {
                    $article["content"] = $doc->saveXML($basenode);
                }

                $descr_node = $xpath->query('(//div[@class="description"])')->item(0);

                if ($descr_node) {
                    $article["content"] = $article["content"] . "<br />" . $doc->saveXML($descr_node);
                }
            }

			return true;
		}

		return false;
	}
}
?>
