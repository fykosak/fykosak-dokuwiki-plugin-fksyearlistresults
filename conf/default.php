<?php
/**
 * Default settings for the fksyearlistresults plugin
 *
 * @author Štěpán Stenchlák <stenchlak@fykos.cz>
 */

$conf['id_filter'] = '/^rocnik([0-9]+):poradi:.*$/';

$conf['url_first_half'] = '/rocnik%d/poradi/pololeti1';
$conf['id_first_half'] = '/rocnik([0-9]+):poradi:pololeti1/';
$conf['url_second_half'] = '/rocnik%d/poradi/pololeti2';
$conf['id_second_half'] = '/rocnik([0-9]+):poradi:pololeti2/';
$conf['url_final'] = '/rocnik%d/poradi/konecne';
$conf['id_final'] = '/rocnik([0-9]+):poradi:konecne/';
$conf['url_series'] = '/rocnik%1$d/poradi/serie%2$d';
$conf['id_series'] = '/rocnik([0-9]+):poradi:serie([0-9]+)/';

