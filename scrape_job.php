<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/app/scrape.php';
require_once __DIR__ .'/libs/utility.php';


use Scrape\Libs\Utility;
use App\Scrapper\Scrape;

$scrape = new Scrape(new Utility);
$start_url = getenv("START_URL");
$request = $scrape->scrape($start_url);
print_r(($request) ? $request : "Failed Adding Data To File");
exit(0);

?>