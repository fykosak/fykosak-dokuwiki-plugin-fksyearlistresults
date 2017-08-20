<?php
/**
 * Default settings for the fksyearlistresults plugin
 *
 * @author Štěpán Stenchlák <stenchlak@fykos.cz>
 */

$conf['cs_id_filter'] = '/^rocnik([0-9]+):poradi:.*$/';
$conf['en_id_filter'] = '/^year([0-9]+):results:.*$/';

$conf['cs_url_first_half'] = '/rocnik%d/poradi/pololeti1';
$conf['cs_id_first_half'] = '/rocnik([0-9]+):poradi:pololeti1/';
$conf['cs_url_second_half'] = '/rocnik%d/poradi/pololeti2';
$conf['cs_id_second_half'] = '/rocnik([0-9]+):poradi:pololeti2/';
$conf['cs_url_final'] = '/rocnik%d/poradi/konecne';
$conf['cs_id_final'] = '/rocnik([0-9]+):poradi:konecne/';
$conf['cs_url_series'] = '/rocnik%1$d/poradi/serie%2$d';
$conf['cs_id_series'] = '/rocnik([0-9]+):poradi:serie([0-9]+)/';

$conf['en_url_first_half'] = '/year%d/results/semester1';
$conf['en_id_first_half'] = '/year([0-9]+):results:semester1/';
$conf['en_url_second_half'] = '/year%d/results/semester2';
$conf['en_id_second_half'] = '/year([0-9]+):results:semester2/';
$conf['en_url_final'] = '/year%d/results/final';
$conf['en_id_final'] = '/year([0-9]+):results:final/';
$conf['en_url_series'] = '/year%1$d/results/series%2$d';
$conf['en_id_series'] = '/year([0-9]+):results:series([0-9]+)/';


