<?php
/**
 * DokuWiki plugin for branches
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Stephan Dekker <Stephan@SparklingSoftware.com.au>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * This is the base class for all syntax classes, providing some general stuff
 */
class helper_plugin_branches extends DokuWiki_Plugin {

    var $jira = null;
    
    function helper_plugin_branches(){        
        $this->jira =& plugin_load('helper', 'jira');
        if (is_null($this->jira)) {
            msg('The branches plugin needs the the jira which cannot be loaded', -1);
            return false;
        }        
    }

    function getBranches()
    {
        $path = DOKU_INC; // Look at the root of this website
        $fulldirs = glob($path.'/*', GLOB_ONLYDIR);
        
        $dirs = array();
        foreach ($fulldirs as $dirname)
        {
            $dir = basename($dirname);
            if (stripos($dir, 'IP-') !== 0) continue;
            array_push($dirs, $dir);
        }
        
        return $dirs;
    }
    
    function getExistingBranches()
    {
        $branches = array();
        
        array_push(&$branches, "IP-165");
        array_push(&$branches, "IP-501");
        array_push(&$branches, "IP-502");
        array_push(&$branches, "IP-503");
        
        return $branches;
    }
    
    function getInProgressInitiatives()
    {
        if ($this->jira === null) return;
        
        $improvements = $this->jira->getJiraData("");
        return $improvements;
    }

}