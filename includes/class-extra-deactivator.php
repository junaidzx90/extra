<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Extra
 * @subpackage Extra/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Extra
 * @subpackage Extra/includes
 * @author     Md Junayed <admin@easeare.com>
 */
class Extra_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook('extra_eur_cron');
	}

}
