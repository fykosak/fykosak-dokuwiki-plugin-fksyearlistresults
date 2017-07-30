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
            if (!preg_match($this->getConf($conf['lang'] . '_' . 'id_filter'), $page['id'])) continue;

            if (preg_match($this->getConf($conf['lang'] . '_' . 'id_first_half'), $page['id'], $m)) {
                $data[$m[1]]['first'] = true;
            } elseif (preg_match($this->getConf($conf['lang'] . '_' . 'id_second_half'), $page['id'], $m)) {
                $data[$m[1]]['second'] = true;
            } elseif (preg_match($this->getConf($conf['lang'] . '_' . 'id_final'), $page['id'], $m)) {
                $data[$m[1]]['final'] = true;
            } elseif (preg_match($this->getConf($conf['lang'] . '_' . 'id_series'), $page['id'], $m)) {
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
        global $conf;

        if($mode != 'xhtml') return false;

        $renderer->doc .= '<div class="row">';

        // For each year from first_year
        foreach ($data as $year => $data_year) {
            $renderer->doc .= '<div class="mb-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">';

            // Title
            $renderer->doc .= '<h2>' . sprintf($this->getLang('title'),$year) . '</h2>';

            if (isset($data_year['first'])) $renderer->doc .= '<p><a href="' . sprintf($this->getConf($conf['lang'] . '_' . 'url_first_half'),$year) . '">' . $this->getLang('first_half') . '</a></p>';
            if (isset($data_year['second'])) $renderer->doc .= '<p><a href="' . sprintf($this->getConf($conf['lang'] . '_' . 'url_second_half'),$year) . '">' . $this->getLang('second_half') . '</a></p>';
            if (isset($data_year['final'])) $renderer->doc .= '<p><a href="' . sprintf($this->getConf($conf['lang'] . '_' . 'url_final'),$year) . '">' . $this->getLang('final') . '</a></p>';

            // Series in list
            $renderer->doc .= '<ul>';
            foreach ($data_year['series'] as $series => $data_year_series) {
                $renderer->doc .= '<li><a href="' . sprintf($this->getConf($conf['lang'] . '_' . 'url_series'),$year, $series) . '">' . sprintf($this->getLang('series'),$series) . '</a></li>';
            }
            $renderer->doc .= '</ul>';


            $renderer->doc .= '</div>';
        }

        $renderer->doc .= '</div>';

        return true;
    }

}

