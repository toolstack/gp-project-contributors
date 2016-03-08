<?php
/*
Plugin Name: GP Project Contributors
Plugin URI: http://glot-o-matic.com/gp-project-contributors
Description: Create a dynamic list of contirbutors to your GlotPress project with a WordPress shortcode.
Version: 0.5
Author: GregRoss
Author URI: http://toolstack.com
Tags: glotpress, glotpress plugin
License: GPLv2 or later
*/

class GP_Project_Contributors {
	public $id = 'gp-project-contributors';

	public function __construct() {
		add_shortcode( 'gp-project-contributors', array( $this, 'gp_project_contributors' ) );
	}
	
	public function gp_project_contributors( $atts ) {
		GLOBAL $wpdb, $gp_table_prefix;

		$project_id = '%';
		if( is_array( $atts ) ) {
			$projects = null;
			if( array_key_exists( 'name', $atts ) ) { 
				$project = GP::$project->find_one( array( 'name' => $atts['name'] ) );
				$project_id = $project->id;
			}
			
			if( array_key_exists( 'slug', $atts ) ) { 
				$project = GP::$project->find_one( array( 'slug' => $atts['slug'] ) );
				$project_id = $project->id;
			}

			if( array_key_exists( 'id', $atts ) ) { 
				$project_id = (int)$atts['id']; 
			}
			
		}
		
		wp_enqueue_style( 'dashicons' );

		// They're a call so let's create it.
		$gpl = new GP_Locales;
		
		// Setup some variables to use later.
		$return = '<style type="text/css">.gptl-twitter, .gptl-twitter:focus, .gptl-twitter:hover, .gptl-twitter:link, .gptl-twitter:visited, .gptl-twitter:active { color: #55acee; } .gptl-facebook, .gptl-facebook:focus, .gptl-facebook:hover, .gptl-facebook:link, .gptl-facebook:visited, .gptl-facebook:active { color: #3A5795; }</style><table style="border: 0px;">';
		$names = array();
        $links = array();
		
		// Grab all of the approvers from the GlotPress permissions table and join it to the WordPress users table so we can get display names later.
		$result = $wpdb->get_results( "SELECT * FROM {$gp_table_prefix}permissions INNER JOIN `{$wpdb->users}` on `{$gp_table_prefix}permissions`.`user_id` = `{$wpdb->users}`.`ID` WHERE `{$gp_table_prefix}permissions`.`action`='approve' AND `{$gp_table_prefix}permissions`.`object_id` LIKE '{$project_id}|%'" );

		// Loop through all the results from the database and create a list of locales with all their approvers associated with them.
		foreach( $result as $row ) {
			$details = explode( '|', $row->object_id );

			if( $details === FALSE || !isset( $details[1] ) ) { continue; }

			$current = $gpl->locales[$details[1]];
			
			$names[$current->english_name][] = $row->display_name;
            $links[$row->display_name] = $row->user_url;
		}

		// Sort the locale list.
		ksort( $names );
		
		// Loop through all the locales to do the output.
		foreach( $names as $key => $values ) {
			// Sort the approvers names alphabetically.
			ksort( $values );
			
			foreach( $values as $keynumber => $display_name ) {
				if( $links[$display_name] ) {
					$nice_link = parse_url( $links[$display_name], PHP_URL_HOST );
					$nice_link = str_ireplace( 'www.', '', $nice_link );
					$nice_link = strtolower( $nice_link );
					
					if( strstr( $display_name, $nice_link ) ) { 
						$nice_link = ''; 
					} else { 
						switch( $nice_link ) {
							case 'twitter.com':
								$nice_link = ' <span class="dashicons dashicons-twitter gptl-twitter"></span>';
								
								break;
							case 'facebook.com':
								$nice_link = ' <span class="dashicons dashicons-facebook gptl-facebook"></span>';
							
								break;
							default:
								$nice_link = ' (' . htmlentities( $nice_link ) . ')'; 
							
								break;
						} 
					}
					
					$values[$keynumber] = '<a href="' . htmlentities( $links[$display_name], ENT_QUOTES ) . '" target="_blank">' . htmlentities( $display_name, ENT_QUOTES ) . $nice_link . '</a>';
				} else {
					$values[$keynumber] = htmlentities( $display_name, ENT_QUOTES );
				}
			} 

			// Create the return string.
			$return .= "<tr><td style=\"text-align: right; border: 0px; background: transparent; white-space: nowrap;\">" . htmlentities( $key, ENT_QUOTES ) . ":</td><td style=\"border: 0px; background: transparent; padding-left:5px;\">" . implode( ', ', $values ) . "</td></tr>\r\n";
		}
		
		$return .= '</table>';
		
		// Return the value.
		return $return;
	}
}

// Add an action to WordPress's init hook to setup the plugin.  Don't just setup the plugin here as the GlotPress plugin may not have loaded yet.
add_action( 'gp_init', 'gp_project_contributors_init' );

// This function creates the plugin.
function gp_project_contributors_init() {
	GLOBAL $gp_project_contributors;
	
	$gp_project_contributors = new GP_Project_Contributors;
}
