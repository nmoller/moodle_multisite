<?php
/**
 *
 * PHP Version 5.5
 * @category:
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: <nmoller@crosemont.qc.ca>
 * @link http://github.com/nmoller GitHub
 * 
 */

require __DIR__.'/../src/config/configs.php';
use cad\config as cc;

$CFG = new \stdClass();
$CFG->wiggling = 'test';

$fake_request_uri = 'dev/admin/cron.php';
$t1 = new cc\configs($fake_request_uri);
$CFG = $t1->set_configs($CFG);

var_dump($CFG);