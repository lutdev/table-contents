<?php
namespace Lutdev\TOC;

/**
 * Class TableContents for generation table of contents
 *
 * @package Lutskevich\TOC
 */
class TableContents
{
    public $symbols = "/\!|\?|:|\.|\,|\;|\\|\/|{|}|\[|\]|\(|\)|\%|\^|\*|_|\=|\+|\@|\#|\~|`|\'|\"|“/";
    public $spaces = "/ |\&nbsp\;|\\r|\\n/";
    public $stripTags = "/<\/?[^>]+>|\&[a-z]+;|\'|\"/";

    /**
     * Add ID attribute to the headers (h1-h10)
     *
     * @param string $description
     *
     * @return string
     */
    public function headerLinks($description)
    {
        /**
         * Support h1-h10 headers. You can using wysiwyg editor and replace h7-h10 tags.
         * This operation clear p tags around headers
         */
        $description = preg_replace("/<(p|[hH](10|[1-9]))>(<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>)<\/(p|[hH](10|[1-9]))>/", "$3", $description);

        preg_match_all("/<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>/", $description, $items);

        $usedItem = [];

        for ($i = 0; $i < count($items[0]); $i++) {

            $name = preg_replace($this->stripTags, '', trim($this->replaceH1Symbols($items[2][$i])));

            if ($name) {
                $link = preg_replace($this->symbols, '', strtolower($name));
                $link = preg_replace($this->spaces, '-', $link);
                $repeatCount = count(array_keys($usedItem, $name));

                if ($repeatCount > 0) {
                    $link .= '-' . ($repeatCount + 1);
                }

                $title = "<h" . $items[1][$i] . " id='" . $link . "'>" . $items[2][$i] . "</h" . $items[1][$i] . ">";

                $description = $this->replaceFirstOccurrence($items[0][$i], $title, $description);

                $usedItem[] = $name;
            } else {
                $description = $this->replaceFirstOccurrence($items[0][$i], '', $description);
            }
        }

        return $description;
    }

    /**
     * Generate table of contents
     *
     * @param string $originText
     *
     * @return string
     */
    public function tableContents($originText)
    {
        $originText = preg_replace("/<(p|[hH](10|[1-9]))>(<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>)<\/(p|[hH](10|[1-9]))>/", "$3", $originText);

        preg_match_all("/<[hH](10|[1-9]).*?>(.*?)<\/[hH](10|[1-9])>/", $originText, $items);

        $menu = "{";
        $subItemsCount = 0;
        $parentItem = [];
        $usedItem = [];

        for ($i = 0; $i < count($items[0]); $i++) {

            $name = preg_replace($this->stripTags, "", trim(html_entity_decode($this->replaceH1Symbols($items[2][$i]), ENT_QUOTES)));

            if ($name) {
                $link = preg_replace($this->symbols, "", strtolower($name));
                $link = preg_replace($this->spaces, "-", $link);
                $repeatCount = count(array_keys($usedItem, $name));

                if ($repeatCount > 0) {
                    $link .= "-" . ($repeatCount + 1);
                }

                if ($i == 0) {
                    $menu .= '"' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';
                } elseif ($i != 0 && $items[1][$i] > $items[1][$i - 1]) {

                    $quantity = $items[1][$i] - $items[1][$i - 1];
                    $menu .= ', "subItems": {';
                    array_push($parentItem, (int)$items[1][$i - 1]);
                    $subItemsCount += $quantity;

                    for ($j = 1; $j <= $quantity - 1; $j++) {
                        $menu .= "\"" . $j . "\":{";
                        $menu .= '"subItems": {';
                        array_push($parentItem, $items[1][$i - 1] + $j);
                    }

                    $menu .= '"' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';

                } elseif ($i != 0 && $items[1][$i] < $items[1][$i - 1]) {
                    $quantity = $items[1][$i - 1] - $items[1][$i];
                    $menu .= "}";

                    if ($subItemsCount) {
                        for ($j = 1; $j <= $quantity * 2; $j++) {
                            $menu .= "}";
                            if ($j % 2 == 0) {
                                $subItemsCount--;
                                array_pop($parentItem);
                            }
                        }
                    }

                    $menu .= ', "' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';
                } else {
                    $menu .= '}, "' . $i . '": {';
                    $menu .= '"title": "' . $name . '",';
                    $menu .= '"link": "' . $link . '"';
                }

                if (!array_key_exists($i + 1, $items[1])) {
                    $a = $items[1][$i];

                    $lastParent = array_shift($parentItem);

                    if ($lastParent && $lastParent < $a) {
                        for ($q = 0; $q <= ($a - $lastParent) * 2; $q++) {
                            $menu .= "}";
                        }
                    } else {
                        $menu .= "}";
                    }
                }

                $usedItem[] = $name;
            }
        }
        $menu .= "}";

        return $menu;
    }

    /**
     * Replace special symbols in the headers
     *
     * @param string $text
     *
     * @return string
     */
    protected function replaceH1Symbols($text)
    {
        $text = preg_replace("/\&nbsp\;/", " ", $text);
        $text = preg_replace("/\&lt\;/", "«", $text);
        $text = preg_replace("/\&gt\;/", "»", $text);
        $text = preg_replace("/\&laquo\;/", "«", $text);
        $text = preg_replace("/\&raquo\;/", "»", $text);

        return $text;
    }

    /**
     * Replace first occurrence
     *
     * @param $from
     * @param $to
     * @param $subject
     *
     * @return mixed
     *
     * @link http://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
     */
    protected function replaceFirstOccurrence($from, $to, $subject)
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return preg_replace($from, $to, $subject, 1);
    }
}