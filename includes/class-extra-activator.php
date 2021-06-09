<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Extra
 * @subpackage Extra/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Extra
 * @subpackage Extra/includes
 * @author     Md Junayed <admin@easeare.com>
 */
class Extra_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
		$extra_v1 = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}extra_v1` (
			`ID` INT NOT NULL AUTO_INCREMENT,
			`numar_comanda` FLOAT NOT NULL,
			`extra_euro` FLOAT NOT NULL,
			`valoare_tva` FLOAT NOT NULL,
			PRIMARY KEY (`ID`)) ENGINE = InnoDB";
			dbDelta($extra_v1);
	}

}
