<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Stephan Dekker <stephan@sparklingsoftware.com.au>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

class action_plugin_branches_createnewbranch extends DokuWiki_Action_Plugin {

    var $basePath = "";

    function register(&$controller){
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle', array());
        $this->basePath = dirname(DOKU_INC);
    }
 
    function handle(&$event, $param){
        $branch_id = $_GET['create_branch'];
        if ($branch_id)
        {
            msg('Created branch: '.$branch_id);
            $src = $this->basePath.DIRECTORY_SEPARATOR.'master';
            $dst = $this->basePath.DIRECTORY_SEPARATOR.$branch_id;
            
            $this->rcopy($src, $dst);
            
            ptln('<script>url="http://localhost:8030/'.$branch_id.'";setTimeout("location.href=url",15);</script>');
        }
    }
    
    // copies files and non-empty directories
    function rcopy($src, $dst) {
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
            {
                if ($file != "." && $file != "..")
                {
                    $this->rcopy($src.DIRECTORY_SEPARATOR.$file, $dst.DIRECTORY_SEPARATOR.$file);
                }
            }
        }
        else if (file_exists($src)) copy($src, $dst);
    }
    
}
