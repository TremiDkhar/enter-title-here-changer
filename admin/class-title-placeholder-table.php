<?php
/**
 * Title Placeholder Table Class
 *
 * @package ETHC
 * @subpackage Admin
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2020, Tremi Dkhar
 * @since 0.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

// Load the WP_List_Table if not loaded.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . ' wp-admin/includes/class-wp-list-table.php';
}

class ETHC_Title_Placeholder_Table extends WP_List_Table {

	/**
	 * Retrive the table column
	 *
	 * @since 0.4.0
	 * @return array $columns Array of all the table columns
	 */
	public function get_columns() {
		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'label'       => __( 'Post Type', 'ethc' ),
			'placeholder' => __( 'Modified Title Placeholder', 'ethc' ),
		);

		return $columns;
	}

	/**
	 * This function renders most of the columns in the list table
	 *
	 * @since 0.4.0
	 *
	 * @param array $item Contains all the data of the placeholder
	 * @param array $column_name The name of the column
	 *
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		return $item[ $column_name ];
	}

	/**
	 * Render the checkbox column
	 *
	 * @since 0.0.1 Beta
	 * @param array $item Contains all the data for the checkbox column
	 * @return string Display a checkbox
	 */
	function column_cb( $item ) {
		return '<input type="checkbox" name="userid", value="" />';
	}

	public function column_label( $items ) {
		// var_dump( $items );
		$row_actions = array();

		$row_actions['edit']   = sprintf(
			'<a href="%s">%s</a>',
			wp_nonce_url(
				add_query_arg(
					array(
						'ethc-action' => 'edit',
						'post-type'   => $items['post_type'],
					)
				),
				'ethc_placeholder_nonce'
			),
			__( 'Edit', 'ethc' )
		);
		$row_actions['delete'] = sprintf(
			'<a href="%s">%s</a>',
			wp_nonce_url( add_query_arg(
				array(
					'ethc-action' => 'delete',
					'post-type'   => $items['post_type'],
				)
			), 'ethc_placeholder_nonce' ),
			__( 'Delete', 'ethc' )
		);

		return $items['label'] . $this->row_actions( $row_actions );
	}

	/**
	 * Retrive all the data for all the post title placeholder
	 *
	 * @since 0.4.0
	 * @return array $placeholders Array of all the data for the placeholder
	 */
	private function placeholder_data() {

		$items = array();

		$placeholders = get_option( 'ethc_placeholders' );

		if ( $placeholders ) {
			foreach ( $placeholders as $post_type => $placeholder ) {
				$items[] = array(
					'post_type'   => $post_type,
					'label'       => $placeholder['label'],
					'placeholder' => $placeholder['placeholder'],
				);
			}
		}

		return $items;

	}

	/**
	 * Setup the data for the table
	 *
	 * @since 0.4.0
	 * @return void
	 */
	public function prepare_items() {

		$columns = $this->get_columns();

		$sortable = array();

		$hidden = array();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->items = $this->placeholder_data();

	}

	/**
	 * Message to display if there is no items
	 *
	 * @since 0.4.0
	 * @return void
	 */
	function no_items() {
		_e( 'No Modified Post Placeholder found.', 'ethc' );
	}

	/**
	 * Remove the table top and button table display navigation.
	 *
	 * @since 0.4.0
	 * @return void
	 */
	protected function display_tablenav( $which ) {
	}
}
