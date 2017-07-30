<?php
/**
 * Default settings for the fksyearlistresults plugin
 *
 * @author Štěpán Stenchlák <stenchlak@fykos.cz>
 */

$conf['cs_id_filter'] = '/^rocnik([0-9]+):poradi:.*$/';
$conf['en_filter'] = '/^year([0-9]+):result:.*$/';

$conf['cs_url_first_half'] = '/rocnik%d/poradi/pololeti1';
$conf['cs_id_first_half'] = '/rocnik([0-9]+):poradi:pololeti1/';
$conf['cs_url_second_half'] = '/rocnik%d/poradi/pololeti2';
$conf['cs_id_second_half'] = '/rocnik([0-9]+):poradi:pololeti2/';
$conf['cs_url_final'] = '/rocnik%d/poradi/konecne';
$conf['cs_id_final'] = '/rocnik([0-9]+):poradi:konecne/';
$conf['cs_url_series'] = '/rocnik%1$d/poradi/serie%2$d';
$conf['cs_id_series'] = '/rocnik([0-9]+):poradi:serie([0-9]+)/';

$conf['en_url_first_half'] = '/year%d/result/first-semester';
$conf['en_id_first_half'] = '/year([0-9]+):result:first-semester/';
$conf['en_url_second_half'] = '/year%d/result/second-semester';
$conf['en_id_second_half'] = '/year([0-9]+):result:second-semester/';
$conf['en_url_final'] = '/year%d/result/final';
$conf['en_id_final'] = '/year([0-9]+):result:final/';
$conf['en_url_series'] = '/year%1$d/result/series%2$d';
$conf['en_id_series'] = '/year([0-9]+):result:series([0-9]+)/';


