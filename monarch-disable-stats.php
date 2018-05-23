<?php

/*
 * Plugin Name: Monarch Disable Stats
 * Plugin URI: https://github.com/moewe-io/monarch-disable-stats
 * Description: When activated this plugin will disable Monarchs statistic collection
 * Version: 1.00
 * Author: MOEWE
 * Author URI: https://www.moewe.io/
 * Text Domain: monarch-disable-stats
 * Domain Path: /languages
 */


class MOEWE_Monarch_Disable_Stats {

    function __construct() {
        add_action('plugins_loaded', [$this, 'disable_monarch_stats'], 100);
    }

    function disable_monarch_stats() {
        if (isset($GLOBALS['et_monarch'])) {
            remove_action('wp_ajax_add_stats_record_db', array($GLOBALS['et_monarch'], 'add_stats_record_db'));
            remove_action('wp_ajax_nopriv_add_stats_record_db', array($GLOBALS['et_monarch'], 'add_stats_record_db'));

            add_action('wp_ajax_add_stats_record_db', array($this, 'add_stats_record_db'));
            add_action('wp_ajax_nopriv_add_stats_record_db', array($this, 'add_stats_record_db'));
        }
    }

    function add_stats_record_db() {
        wp_die(__('Sorry, Monarch statistics are disabled.', 'monarch-disable-stats'));
    }

}

$GLOBALS['moewe_monarch_disable_stats'] = new MOEWE_Monarch_Disable_Stats();

// Updates
require 'libs/plugin-update-checker-4.4/plugin-update-checker.php';
Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/moewe-io/monarch-disable-stats/',
    __FILE__,
    'monarch-disable-stats'
)->setBranch('master');