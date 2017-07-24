<?php
/**
 * DokuWiki Plugin fksyearlistresults (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Štěpán Stenchlák <stenchlak@fykos.cz>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_fksyearlistresults extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 500;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<fksyearlistresults.*?>',$mode,'plugin_fksyearlistresults');
    }

    /**
     * Handle matches of the fksyearlistresults syntax
     *
     * @param string          $match   The match of the syntax
     * @param int             $state   The state of the handler
     * @param int             $pos     The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){
        // Dokuwiki configuration for datadir value
        global $conf;

        // Search all pages
        search($search_results, $conf['datadir'], 'search_allpages', array(), '', -1);

        // Extract data
        $data = [];
        foreach ($search_results as $page) {
            // Better one additional preg_match, than 4 useless...
            if (!preg_match($this->getConf('id_filter'), $page['id'])) continue;

            if (preg_match($this->getConf('id_first_half'), $page['id'], $m)) {
                $data[$m[1]]['first'] = true;
            } elseif (preg_match($this->getConf('id_second_half'), $page['id'], $m)) {
                $data[$m[1]]['second'] = true;
            } elseif (preg_match($this->getConf('id_final'), $page['id'], $m)) {
                $data[$m[1]]['final'] = true;
            } elseif (preg_match($this->getConf('id_series'), $page['id'], $m)) {
                $data[$m[1]]['series'][$m[2]] = true;
            }
        }

        // Order data
        ksort($data, SORT_NATURAL | SORT_FLAG_CASE);

        return $data;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;

        $renderer->doc .= '<div class="row">';

        // For each year from first_year
        foreach ($data as $year => $data_year) {
            $renderer->doc .= "<div class=\"mb-3 col-lg-6 col-xl-4 col-md-6 col-sm-12 col-xs-12\">";

            // Title
            $renderer->doc .= '<h2>' . sprintf($this->getLang('title'),$year,$this->romanicNumber($year)) . '</h2>';

            if (isset($data_year['first'])) $renderer->doc .= '<p><a href="' . sprintf($this->getConf('url_first_half'),$year) . '">' . $this->getLang('first_half') . '</a></p>';
            if (isset($data_year['second'])) $renderer->doc .= '<p><a href="' . sprintf($this->getConf('url_second_half'),$year) . '">' . $this->getLang('second_half') . '</a></p>';
            if (isset($data_year['final'])) $renderer->doc .= '<p><a href="' . sprintf($this->getConf('url_final'),$year) . '">' . $this->getLang('final') . '</a></p>';

            // Series in list
            $renderer->doc .= '<ul>';
            foreach ($data_year['series'] as $series => $data_year_series) {
                $renderer->doc .= '<li><a href="' . sprintf($this->getConf('url_series'),$year, $series) . '">' . sprintf($this->getLang('series'),$series) . '</a></li>';
            }
            $renderer->doc .= '</ul>';


            $renderer->doc .= '</div>';
        }

        $renderer->doc .= '</div>';

        return true;
    }

    /**
     * Transform ordinary numbers to Roman numerals
     *
     * @param $integer Number to convert
     * @param bool $upcase
     * @return string Result
     */
    private function romanicNumber($integer, $upcase = true)
    {
        $table = ['M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1];
        $return = '';
        while($integer > 0)
        {
            foreach($table as $rom=>$arb)
            {
                if($integer >= $arb)
                {
                    $integer -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }

        return $return;
    }

}

