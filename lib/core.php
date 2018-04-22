<?php

class core
{
    public function getSite($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $head = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $head;
    }


    public function euromillonariaen($html, $losowanie, &$json)
    {
        $html = str_get_html($html);
        $json[] = array(
            'losowanie' => $losowanie,
            'dzien' => str_replace('&nbsp;', ' ', $html->find('.result_big .center .body_game .c', 0)->innertext),
            'l1' => $html->find('.result_big .body_game .balls .num .int-num', 0)->innertext,
            'l2' => $html->find('.result_big .body_game .balls .num .int-num', 1)->innertext,
            'l3' => $html->find('.result_big .body_game .balls .num .int-num', 2)->innertext,
            'l4' => $html->find('.result_big .body_game .balls .num .int-num', 3)->innertext,
            'l5' => $html->find('.result_big .body_game .balls .num .int-num', 4)->innertext,
            'd1' => $html->find('.result_big .body_game .balls .esp .int-num', 0)->innertext,
            'd2' => $html->find('.result_big .body_game .balls .esp .int-num', 1)->innertext,

        );

        $tables = R::inspect();
        if (!in_array('euromillonariaen', $tables)) {
            R::exec("CREATE TABLE [euromillonariaen] (
                            [id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
                            [losowanie] INTEGER null,
                            [dzien] TEXT  NULL,
                            [l1] INTEGER  NULL,
                            [l2] INTEGER  NULL,
                            [l3] INTEGER  NULL,
                            [l4] INTEGER  NULL,
                            [l5] INTEGER  NULL,
                            [d1] INTEGER  NULL,
                            [d2] INTEGER  NULL
                            )");
        }
        foreach ($json as $j) {
            $is = R::getRow('select id from euromillonariaen where losowanie = :losowanie',
                array('losowanie' => $j['losowanie']));
            if ($is['id'] > 0) {
                continue;
            }
            $rekord = R::dispense('euromillonariaen');
            foreach ($j as $k => $v) {
                $rekord[$k] = $v;
            }
            $id = R::store($rekord);
        }




    }


    public function eurojackpot($html)
    {
        $html = str_get_html($html);
        $json = array();
        foreach ($html->find('.ostatnie-wyniki-table tr') as $t) {
            if ((int)$t->find('td', 0)->innertext > 0) {
                $json[] = array(
                    'losowanie' => $t->find('td', 0)->innertext,
                    'dzien' => $t->find('td', 1)->innertext,
                    'l1' => $t->find('td', 2)->find('.sortkolejnosc .number span', 0)->innertext,
                    'l2' => $t->find('td', 2)->find('.sortkolejnosc .number span', 1)->innertext,
                    'l3' => $t->find('td', 2)->find('.sortkolejnosc .number span', 2)->innertext,
                    'l4' => $t->find('td', 2)->find('.sortkolejnosc .number span', 3)->innertext,
                    'l5' => $t->find('td', 2)->find('.sortkolejnosc .number span', 4)->innertext,
                    'd1' => $t->find('td', 2)->find('.sortkolejnosc .number span', 6)->innertext,
                    'd2' => $t->find('td', 2)->find('.sortkolejnosc .number span', 7)->innertext,

                );
            }
        }
        file_put_contents('./cache/' . date('Ymd') . '_eurojackpot.json', json_encode($json));



        $tables = R::inspect();
        if (!in_array('eurojackpot', $tables)) {
            R::exec("CREATE TABLE [eurojackpot] (
                            [id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
                            [losowanie] INTEGER null,
                            [dzien] TEXT  NULL,
                            [l1] INTEGER  NULL,
                            [l2] INTEGER  NULL,
                            [l3] INTEGER  NULL,
                            [l4] INTEGER  NULL,
                            [l5] INTEGER  NULL,
                            [d1] INTEGER  NULL,
                            [d2] INTEGER  NULL
                            )");
        }
        foreach ($json as $j) {
            $is = R::getRow('select id from eurojackpot where losowanie = :losowanie',
                array('losowanie' => $j['losowanie']));
            if ($is['id'] > 0) {
                continue;
            }
            $rekord = R::dispense('eurojackpot');
            foreach ($j as $k => $v) {
                $rekord[$k] = $v;
            }
            $id = R::store($rekord);
        }



    }

    public function lotto($html)
    {
        $html = str_get_html($html);
        $json_lotto = array();
        $json_plus = array();
        $json_szansa = array();
        foreach ($html->find('.ostatnie-wyniki-table tr') as $t) {
            if ((int)$t->find('td', 1)->innertext > 0) {
                if ($t->find('td img', 0)->alt == 'Lotto') {
                    $json_lotto[] = array(
                        'losowanie' => $t->find('td', 1)->innertext,
                        'dzien' => $t->find('td', 2)->innertext,
                        'l1' => $t->find('td', 3)->find('.sortkolejnosc .number span', 0)->innertext,
                        'l2' => $t->find('td', 3)->find('.sortkolejnosc .number span', 1)->innertext,
                        'l3' => $t->find('td', 3)->find('.sortkolejnosc .number span', 2)->innertext,
                        'l4' => $t->find('td', 3)->find('.sortkolejnosc .number span', 3)->innertext,
                        'l5' => $t->find('td', 3)->find('.sortkolejnosc .number span', 4)->innertext,
                        'l6' => $t->find('td', 3)->find('.sortkolejnosc .number span', 5)->innertext,

                    );
                } elseif ($t->find('td img', 0)->alt == 'Lotto Plus') {
                    $json_plus[] = array(
                        'losowanie' => $t->find('td', 1)->innertext,
                        'dzien' => $t->find('td', 2)->innertext,
                        'l1' => $t->find('td', 3)->find('.sortkolejnosc .number span', 0)->innertext,
                        'l2' => $t->find('td', 3)->find('.sortkolejnosc .number span', 1)->innertext,
                        'l3' => $t->find('td', 3)->find('.sortkolejnosc .number span', 2)->innertext,
                        'l4' => $t->find('td', 3)->find('.sortkolejnosc .number span', 3)->innertext,
                        'l5' => $t->find('td', 3)->find('.sortkolejnosc .number span', 4)->innertext,
                        'l6' => $t->find('td', 3)->find('.sortkolejnosc .number span', 5)->innertext,

                    );
                } elseif ($t->find('td img', 0)->alt == 'Super Szansa') {
                    $json_szansa[] = array(
                        'losowanie' => $t->find('td', 1)->innertext,
                        'dzien' => $t->find('td', 2)->innertext,
                        'l1' => $t->find('td', 3)->find('.number span', 0)->innertext,
                        'l2' => $t->find('td', 3)->find('.number span', 1)->innertext,
                        'l3' => $t->find('td', 3)->find('.number span', 2)->innertext,
                        'l4' => $t->find('td', 3)->find('.number span', 3)->innertext,
                        'l5' => $t->find('td', 3)->find('.number span', 4)->innertext,
                        'l6' => $t->find('td', 3)->find('.number span', 5)->innertext,
                        'l7' => $t->find('td', 3)->find('.number span', 6)->innertext,

                    );
                }
            }
        }

        $tables = R::inspect();
        if (!in_array('lotto', $tables)) {
            R::exec("CREATE TABLE [lotto] (
                            [id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
                            [losowanie] INTEGER null,
                            [dzien] TEXT  NULL,
                            [l1] INTEGER  NULL,
                            [l2] INTEGER  NULL,
                            [l3] INTEGER  NULL,
                            [l4] INTEGER  NULL,
                            [l5] INTEGER  NULL,
                            [l6] INTEGER  NULL
                            )");
        }
        foreach ($json_lotto as $j) {
            $is = R::getRow('select id from lotto where losowanie = :losowanie',
                array('losowanie' => $j['losowanie']));
            if ($is['id'] > 0) {
                continue;
            }
            $rekord = R::dispense('lotto');
            foreach ($j as $k => $v) {
                $rekord[$k] = $v;
            }
            $id = R::store($rekord);
        }
        file_put_contents('./cache/' . date('Ymd') . '_lotto.json', json_encode($json_lotto));



        $tables = R::inspect();
        if (!in_array('lottoplus', $tables)) {
            R::exec("CREATE TABLE [lottoplus] (
                            [id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
                            [losowanie] INTEGER null,
                            [dzien] TEXT  NULL,
                            [l1] INTEGER  NULL,
                            [l2] INTEGER  NULL,
                            [l3] INTEGER  NULL,
                            [l4] INTEGER  NULL,
                            [l5] INTEGER  NULL,
                            [l6] INTEGER  NULL
                            [l7] INTEGER  NULL
                            )");
        }
        foreach ($json_plus as $j) {
            $is = R::getRow('select id from lottoplus where losowanie = :losowanie',
                array('losowanie' => $j['losowanie']));
            if ($is['id'] > 0) {
                continue;
            }
            $rekord = R::dispense('lottoplus');
            foreach ($j as $k => $v) {
                $rekord[$k] = $v;
            }
            $id = R::store($rekord);
        }
        file_put_contents('./cache/' . date('Ymd') . '_lotto_plus.json', json_encode($json_plus));


        $tables = R::inspect();
        if (!in_array('superszansa', $tables)) {
            R::exec("CREATE TABLE [superszansa] (
                            [id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
                            [losowanie] INTEGER null,
                            [dzien] TEXT  NULL,
                            [l1] INTEGER  NULL,
                            [l2] INTEGER  NULL,
                            [l3] INTEGER  NULL,
                            [l4] INTEGER  NULL,
                            [l5] INTEGER  NULL,
                            [l6] INTEGER  NULL
                            )");
        }
        foreach ($json_szansa as $j) {
            $is = R::getRow('select id from superszansa where losowanie = :losowanie',
                array('losowanie' => $j['losowanie']));
            if ($is['id'] > 0) {
                continue;
            }
            $rekord = R::dispense('superszansa');
            foreach ($j as $k => $v) {
                $rekord[$k] = $v;
            }
            $id = R::store($rekord);
        }
        file_put_contents('./cache/' . date('Ymd') . '_super_szansa.json', json_encode($json_szansa));
    }


}

?>