<?php namespace Codeable\Poll\ACF;

class ACF {

	public static function register() {
		self::registerChampionData();
		self::registerClanData();
	}

	private static function registerChampionData() {

		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5dbc31e7ce843',
				'title' => 'Champion data',
				'fields' => array(
					array(
						'key' => 'field_5dbc320e727ac',
						'label' => 'Champion image',
						'name' => 'champion_image',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'champions',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;

		if ( function_exists( 'acf_add_local_field_group' ) ):

			acf_add_local_field_group( array(
				'key'    => 'group_5d8a12837a26a',
				'title'  => 'Poll data',
				'fields' => array(
						array(
						'key'               => 'field_5dbc2ff975d75',
						'label'             => 'Poll description',
						'name'              => 'poll_description',
						'type'              => 'textarea',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'maxlength'         => '',
						'rows'              => '',
						'new_lines'         => '',
					),
						array(
							'key'               => 'field_5d8a128b14d61',
							'label'             => 'Poll data',
							'name'              => 'poll_data',
							'type'              => 'repeater',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'collapsed'         => '',
							'min'               => 0,
							'max'               => 0,
							'layout'            => 'table',
							'button_label'      => '',
							'sub_fields'        => array(
								array(
									'key'               => 'field_5d8a12ad14d62',
									'label'             => 'Champion data',
									'name'              => 'champion_data',
									'type'              => 'group',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'layout'            => 'table',
									'sub_fields'        => array(
										array(
											'key'               => 'field_5d8a12e514d63',
											'label'             => 'Champion',
											'name'              => 'champion',
											'type'              => 'post_object',
											'instructions'      => '',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'post_type'         => array(
												0 => 'champions',
											),
											'taxonomy'          => '',
											'allow_null'        => 0,
											'multiple'          => 0,
											'return_format'     => 'id',
											'ui'                => 1,
										),
										array(
											'key'               => 'field_5d8a185914d64',
											'label'             => 'Boons count',
											'name'              => 'boons_count',
											'type'              => 'number',
											'instructions'      => '',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 0,
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'min'               => 0,
											'max'               => '',
											'step'              => '',
										),
										array(
											'key'               => 'field_5d8a187314d65',
											'label'             => 'Color',
											'name'              => 'color',
											'type'              => 'color_picker',
											'instructions'      => '',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => '#123456',
										),
									),
								),
							),
						),
						array(
							'key'               => 'field_5d8b31a91e141',
							'label'             => 'Timeframe',
							'name'              => 'timeframe',
							'type'              => 'group',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'layout'            => 'row',
							'sub_fields'        => array(
								array(
									'key'               => 'field_5d8b31b91e142',
									'label'             => 'Start date',
									'name'              => 'start_date',
									'type'              => 'date_time_picker',
									'instructions'      => '',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'display_format'    => 'Y-m-d H:i:s',
									'return_format'     => 'Y-m-d H:i:s',
									'first_day'         => 1,
								),
								array(
									'key'               => 'field_5d8b31d41e143',
									'label'             => 'End date',
									'name'              => 'end_date',
									'type'              => 'date_time_picker',
									'instructions'      => '',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'display_format'    => 'Y-m-d H:i:s',
									'return_format'     => 'Y-m-d H:i:s',
									'first_day'         => 1,
								),
							),
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'poll',
							),
						),
					),
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => true,
					'description'           => '',
				)
			);

		endif;
	}

	private static function registerClanData() {
		if ( function_exists( 'acf_add_local_field_group' ) ):

			acf_add_local_field_group( array(
				'key'                   => 'group_5d8a28e4524f4',
				'title'                 => 'Clan logo',
				'fields'                => array(
					array(
						'key'               => 'field_5d8a294e0ffdd',
						'label'             => 'Clan logo',
						'name'              => 'clan_logo',
						'type'              => 'image',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'url',
						'preview_size'      => 'thumbnail',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'taxonomy',
							'operator' => '==',
							'value'    => 'clans',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

		endif;
	}
}