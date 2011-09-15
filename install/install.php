<?php
/**
* @package jediPaypal
* @author    Florian Lonqueu-Brochard
* @copyright 2011 Florian Lonqueu-Brochard
* @license    MIT
*/


class jediPaypalModuleInstaller extends jInstallerModule {

    function install() {
        if ($this->firstDbExec())
           $this->execSQLScript('sql/schema');
    }
}