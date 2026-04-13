<?php
/**
 * Demo content installer.
 *
 * @package FleetMonitor_Core
 */

defined( 'ABSPATH' ) || exit;

class FleetMonitor_Demo_Content {

	public static function install() {
		// Reset the "products created" flag so WooCommerce class will re-run
		delete_option( 'fm_sample_products_created' );

		// Create sample products via the WooCommerce class
		if ( class_exists( 'FleetMonitor_WooCommerce' ) && class_exists( 'WooCommerce' ) ) {
			FleetMonitor_WooCommerce::maybe_create_sample_products();
		}

		self::create_sample_vehicles();
		self::create_sample_testimonials();
		self::create_sample_blog_posts();

		flush_rewrite_rules();
	}

	// --------------------------------------------------------
	// SAMPLE VEHICLES
	// --------------------------------------------------------

	private static function create_sample_vehicles() {
		$vehicles = array(
			array(
				'title'  => 'Mercedes Sprinter 314 – KR 12345A',
				'plate'  => 'KR 12345A',
				'make'   => 'Mercedes-Benz',
				'model'  => 'Sprinter 314 CDI',
				'year'   => '2022',
				'fuel'   => 'Diesel',
				'driver' => 'Jan Nowak',
				'lat'    => '50.0647',
				'lng'    => '19.9450',
				'speed'  => '78',
				'gps_id' => 'FM-X200-001',
				'status' => 'Active',
				'vin'    => 'WDB9066571K000001',
			),
			array(
				'title'  => 'Volkswagen Crafter 35 – WW 67890B',
				'plate'  => 'WW 67890B',
				'make'   => 'Volkswagen',
				'model'  => 'Crafter 35 TDI',
				'year'   => '2021',
				'fuel'   => 'Diesel',
				'driver' => 'Anna Kowalska',
				'lat'    => '52.2297',
				'lng'    => '21.0122',
				'speed'  => '0',
				'gps_id' => 'FM-X200-002',
				'status' => 'Idle',
				'vin'    => 'WV1ZZZ2CZ31000002',
			),
			array(
				'title'  => 'Ford Transit Custom – GD 11111C',
				'plate'  => 'GD 11111C',
				'make'   => 'Ford',
				'model'  => 'Transit Custom 2.0 TDCI',
				'year'   => '2023',
				'fuel'   => 'Diesel',
				'driver' => 'Piotr Wiśniewski',
				'lat'    => '54.3520',
				'lng'    => '18.6466',
				'speed'  => '52',
				'gps_id' => 'FM-X200-003',
				'status' => 'Active',
				'vin'    => 'WF0XXXTTGX3A00003',
			),
			array(
				'title'  => 'Renault Kangoo Electric – PZ 22222D',
				'plate'  => 'PZ 22222D',
				'make'   => 'Renault',
				'model'  => 'Kangoo E-Tech Electric',
				'year'   => '2023',
				'fuel'   => 'Electric',
				'driver' => 'Maria Lewandowska',
				'lat'    => '51.7592',
				'lng'    => '19.4559',
				'speed'  => '0',
				'gps_id' => 'FM-X200-004',
				'status' => 'Maintenance',
				'vin'    => 'VF1FW0ZFX3Y000004',
			),
			array(
				'title'  => 'Volvo FH 500 – LU 33333E',
				'plate'  => 'LU 33333E',
				'make'   => 'Volvo',
				'model'  => 'FH 500 I-SHIFT',
				'year'   => '2020',
				'fuel'   => 'Diesel',
				'driver' => 'Tomasz Zielinski',
				'lat'    => '53.1325',
				'lng'    => '23.1688',
				'speed'  => '90',
				'gps_id' => 'FM-X200-005',
				'status' => 'Active',
				'vin'    => 'YV2X4A1A9LA000005',
			),
		);

		foreach ( $vehicles as $v ) {
			// Check if vehicle with this plate already exists
			$existing = get_posts(
				array(
					'post_type'   => 'fm_vehicle',
					'meta_key'    => '_vehicle_plate', // phpcs:ignore WordPress.DB.SlowDBQuery
					'meta_value'  => $v['plate'], // phpcs:ignore WordPress.DB.SlowDBQuery
					'numberposts' => 1,
				)
			);

			if ( ! empty( $existing ) ) {
				continue;
			}

			$post_id = wp_insert_post(
				array(
					'post_title'   => wp_slash( $v['title'] ),
					'post_type'    => 'fm_vehicle',
					'post_status'  => 'publish',
					'post_content' => '',
				)
			);

			if ( is_wp_error( $post_id ) ) {
				continue;
			}

			$meta_map = array(
				'_vehicle_plate'        => $v['plate'],
				'_vehicle_make'         => $v['make'],
				'_vehicle_model'        => $v['model'],
				'_vehicle_year'         => $v['year'],
				'_vehicle_fuel_type'    => $v['fuel'],
				'_vehicle_driver'       => $v['driver'],
				'_vehicle_lat'          => $v['lat'],
				'_vehicle_lng'          => $v['lng'],
				'_vehicle_speed'        => $v['speed'],
				'_vehicle_gps_id'       => $v['gps_id'],
				'_vehicle_vin'          => $v['vin'],
				'_vehicle_last_updated' => gmdate( 'c' ),
			);

			foreach ( $meta_map as $meta_key => $meta_value ) {
				update_post_meta( $post_id, $meta_key, $meta_value );
			}

			// Assign vehicle type and status taxonomy terms
			wp_set_object_terms( $post_id, $v['status'], 'vehicle_status' );
		}
	}

	// --------------------------------------------------------
	// SAMPLE TESTIMONIALS
	// --------------------------------------------------------

	private static function create_sample_testimonials() {
		$testimonials = array(
			array(
				'title'   => 'Adam Kowalski',
				'content' => 'FleetMonitor cut our fuel costs by 31% in the first quarter. The real-time alerts and driver behaviour reports are simply indispensable. Our drivers drive safer and our customers are happier.',
				'role'    => 'Fleet Director, Kowalski Transport Sp. z o.o.',
				'rating'  => '5',
				'company' => 'Kowalski Transport',
			),
			array(
				'title'   => 'Maria Nowak',
				'content' => 'We manage 120 vehicles across 3 countries and FleetMonitor gives us a single pane of glass. Setup was incredibly easy and the support team is exceptional.',
				'role'    => 'Operations Manager, EuroLogistics GmbH',
				'rating'  => '5',
				'company' => 'EuroLogistics',
			),
			array(
				'title'   => 'Piotr Wiśniewski',
				'content' => 'The WooCommerce store made it super easy to order replacement GPS units. Combined with the SaaS platform, everything is in one place. Highly recommend!',
				'role'    => 'Head of IT, City Delivery Services',
				'rating'  => '5',
				'company' => 'City Delivery Services',
			),
		);

		foreach ( $testimonials as $t ) {
			$existing = get_posts(
				array(
					'post_type'   => 'fm_testimonial',
					'post_status' => 'any',
					'title'       => $t['title'],
					'numberposts' => 1,
				)
			);

			if ( ! empty( $existing ) ) {
				continue;
			}

			$post_id = wp_insert_post(
				array(
					'post_title'   => wp_slash( $t['title'] ),
					'post_type'    => 'fm_testimonial',
					'post_status'  => 'publish',
					'post_content' => wp_slash( $t['content'] ),
				)
			);

			if ( ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_testimonial_role', $t['role'] );
				update_post_meta( $post_id, '_testimonial_rating', $t['rating'] );
				update_post_meta( $post_id, '_testimonial_company', $t['company'] );
			}
		}
	}

	// --------------------------------------------------------
	// SAMPLE BLOG POSTS
	// --------------------------------------------------------

	private static function create_sample_blog_posts() {
		$posts = array(
			array(
				'title'   => '10 Ways GPS Fleet Tracking Reduces Fuel Costs',
				'excerpt' => 'Fuel is one of the biggest expenses for any fleet operation. Discover how real-time GPS tracking can help you cut fuel costs by up to 30%.',
				'content' => '<p>Fuel costs account for 30–40% of total fleet operating expenses. With fuel prices constantly rising, finding ways to reduce consumption is a top priority for fleet managers. Here are 10 proven strategies using GPS fleet tracking to slash your fuel bill.</p>
<h2>1. Eliminate Idling</h2>
<p>Excessive idling wastes fuel and increases engine wear. GPS systems can detect when a vehicle has been stationary with the engine running for more than a set threshold (e.g. 5 minutes) and send an alert to both the driver and the dispatcher.</p>
<h2>2. Optimise Routes</h2>
<p>Route optimisation algorithms analyse traffic patterns, road conditions and job locations to calculate the most fuel-efficient route for each journey. This alone can reduce mileage by 10–20%.</p>
<h2>3. Monitor Speeding</h2>
<p>Driving at 110 km/h instead of 90 km/h increases fuel consumption by up to 25%. GPS speed monitoring with automated alerts discourages speeding and encourages economical driving.</p>
<h2>4. Reduce Unnecessary Trips</h2>
<p>GPS data reveals patterns of personal or unauthorised vehicle use. By eliminating unnecessary journeys, you can reduce total mileage and fuel consumption significantly.</p>
<h2>5. Improve Maintenance Scheduling</h2>
<p>A well-maintained vehicle uses fuel more efficiently. GPS systems track mileage and engine hours to ensure services are never missed, keeping engines running at optimal efficiency.</p>',
				'cats'    => array( 'Fleet Management', 'Cost Reduction' ),
			),
			array(
				'title'   => 'Choosing the Right GPS Tracker for Your Fleet',
				'excerpt' => 'With dozens of GPS tracking devices on the market, choosing the right one for your fleet can be overwhelming. Our buying guide breaks it down.',
				'content' => '<p>The GPS tracker market is crowded with options ranging from simple consumer devices to enterprise-grade fleet management solutions. Choosing the right device requires careful consideration of your fleet\'s specific needs.</p>
<h2>Key Factors to Consider</h2>
<h3>1. Connectivity Technology</h3>
<p>Modern GPS trackers use 2G, 3G, 4G LTE or even satellite connectivity. For UK and European fleets, 4G LTE is now the standard, offering faster data speeds and better coverage. However, if you operate in remote areas, satellite connectivity may be necessary.</p>
<h3>2. Update Frequency</h3>
<p>Consumer GPS trackers typically update every 30–60 seconds, which is insufficient for professional fleet management. Professional trackers like the FleetTrack Pro X200 update every 5 seconds, giving you near real-time visibility.</p>
<h3>3. Installation Type</h3>
<p>There are three main installation types: hardwired (most secure), OBD plug-in (easiest) and magnetic (for temporary tracking). Each has its pros and cons.</p>
<h3>4. Waterproofing</h3>
<p>Vehicles face all weather conditions. Look for IP67 or higher waterproof ratings for external installation, or at minimum IP54 for interior use.</p>',
				'cats'    => array( 'Buying Guide', 'GPS Trackers' ),
			),
			array(
				'title'   => 'Driver Safety: How Fleet Monitoring Saves Lives',
				'excerpt' => 'Road accidents cost fleets billions each year. Learn how driver behaviour monitoring reduces accidents, insurance costs and liability.',
				'content' => '<p>Road traffic accidents are the leading cause of work-related fatalities in Europe, according to the European Agency for Safety and Health at Work. For fleet operators, the consequences extend far beyond the tragic human cost – accidents mean downtime, insurance claims, legal liability and reputational damage.</p>
<h2>The Data-Driven Approach to Safety</h2>
<p>GPS fleet management platforms collect detailed data on driver behaviour, including harsh braking, harsh acceleration, speeding, sharp cornering and phone use. This data enables fleet managers to identify at-risk drivers and intervene before accidents occur.</p>
<h2>Driver Scorecards</h2>
<p>Modern fleet platforms generate driver scorecards that rank drivers on a range of safety metrics. These can be shared with drivers (improving accountability) and used for training and performance reviews.</p>
<h2>Real Results</h2>
<p>Companies using driver behaviour monitoring typically see a 20–40% reduction in accident rates within the first year. Insurance premiums often fall by 15–30% as a direct result of improved safety records.</p>',
				'cats'    => array( 'Safety', 'Driver Management' ),
			),
		);

		foreach ( $posts as $post_data ) {
			$existing = get_posts(
				array(
					'post_type'   => 'post',
					'post_status' => 'any',
					'title'       => $post_data['title'],
					'numberposts' => 1,
				)
			);

			if ( ! empty( $existing ) ) {
				continue;
			}

			$post_id = wp_insert_post(
				array(
					'post_title'   => wp_slash( $post_data['title'] ),
					'post_excerpt' => wp_slash( $post_data['excerpt'] ),
					'post_type'    => 'post',
					'post_status'  => 'publish',
					'post_content' => wp_slash( $post_data['content'] ),
				)
			);

			if ( is_wp_error( $post_id ) ) {
				continue;
			}

			// Create and assign categories
			foreach ( $post_data['cats'] as $cat_name ) {
				$cat = get_category_by_slug( sanitize_title( $cat_name ) );
				if ( ! $cat ) {
					$result = wp_insert_term( $cat_name, 'category' );
					if ( ! is_wp_error( $result ) ) {
						wp_set_post_categories( $post_id, array( $result['term_id'] ), true );
					}
				} else {
					wp_set_post_categories( $post_id, array( $cat->term_id ), true );
				}
			}
		}
	}
}
