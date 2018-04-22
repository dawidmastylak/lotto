<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

include './lib/rb.php';
include './lib/shd.php';
include './lib/core.php';
R::setup('sqlite:lotto.db');

$c = new Core();

$c->eurojackpot($c->getSite('http://www.lotto.pl/eurojackpot/wyniki-i-wygrane'));
$c->lotto($c->getSite('http://www.lotto.pl/lotto/wyniki-i-wygrane'));

$json = array();
for ($i = 1105; $i > 1095; $i--) {
    $c->euromillonariaen($c->getSite('https://www.elgordo.com/results/euromillonariaen.asp?sort=' . $i), $i, $json);
}
file_put_contents('./cache/' . date('Ymd') . '_euromillonariaen.json', json_encode($json));

R::close();
?>