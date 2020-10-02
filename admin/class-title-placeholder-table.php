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
	 * @param array $item Contains all the data of the placeholder.
	 * @param array $column_name The name of the column.
	 *
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		return $item[ $column_name ];
	}

	public function column_label( $items ) {
		$row_actions = array();

		$row_actions['edit']   = $this->get_edit_link( $items['post_type'], $items['placeholder'] );
		$row_actions['delete'] = $this->get_delete_link( $items['post_type'] );

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
		esc_html_e( 'No Modified Post Placeholder found.', 'ethc' );
	}

	/**
	 * Remove the table top and button table display navigation.
	 *
	 * @since 0.4.0
	 * @param string $which Determine whether its a top or bottom table nav.
	 * @return void
	 */
	protected function display_tablenav( $which ) {
	}

	/**
	 * Create the edit link for the particular item
	 *
	 * @since 0.4.0
	 * @param string $post_type Post Type.
	 * @return string HTML Markup for the edit link.
	 */
	public function get_edit_link( $post_type, $placeholder ) {
		return sprintf(
			'<a href="%s" data-post-type="%s" data-placeholder="%s">%s</a>',
			wp_nonce_url(
				add_query_arg(
					array(
						'ethc-action' => 'edit',
						'post-type'   => $post_type,
					)
				),
				'ethc_placeholder_nonce'
			),
			$post_type,
			$placeholder,
			__( 'Edit', 'ethc' )
		);

	}

	/**
	 * Create the delete markup link for the item
	 *
	 * @since 0.4.0
	 * @param string $post_type Post Type.
	 * @return string HTML Markup for the delete link.
	 */
	private function get_delete_link( $post_type ) {
		return sprintf(
			'<a href="%s" data-post-type="%s">%s</a>',
			wp_nonce_url(
				add_query_arg(
					array(
						'ethc-action' => 'delete',
						'post-type'   => $post_type,
					)
				),
				'ethc_placeholder_nonce'
			),
			$post_type,
			__( 'Delete', 'ethc' )
		);

	}
}
