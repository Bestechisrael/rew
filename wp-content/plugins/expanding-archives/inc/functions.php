<?php
/**
 * Plugin Functions
 *
 * @package   expanding-archives
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Get Months
 *
 * @since 1.0.5
 * @return array
 */
function expanding_archives_get_months() {
	global $wpdb;

	if ( false === ( $months = get_transient( 'expanding_archives_months' ) ) ) {
		$months = $wpdb->get_results( "SELECT DISTINCT MONTH( post_date ) AS month , YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'event' GROUP BY month , year ORDER BY post_date DESC" );

		set_transient( 'expanding_archives_months', $months, DAY_IN_SECONDS );
	}

	return apply_filters( 'expanding-archives/months', $months );
}