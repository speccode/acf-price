<?php

class acf_field_price extends acf_field
{
	public function __construct( $settings )
	{
		$this->name = 'price';
		$this->label = __('Price', 'acf-price');
		$this->category = 'jquery';
		$this->defaults = array(
			'format'				=> '|2/./ |'
		);

		$this->l10n = array(
			//'error'	=> __('Error! Please enter a higher value', 'acf-price'),
		);

		$this->settings = $settings;

    	parent::__construct();
	}


	public function render_field_settings( $field )
	{
		$choices = array(
			'|2/./ |' 	=> '1 337.55',
			'|2/,/ |' 	=> '1 337,55',
			'|2/./,|' 	=> '1,337.55',
			'|2/,/.|' 	=> '1.337,55',
			'|0//|' 	=> '1337',
			'|0// |' 	=> '1 337'
		);

		//apply_filter

		acf_render_field_setting( $field, array(
			'label'			=> __('Format','acf-price'),
			'instructions'	=> __('Number format template','acf-price'),
			'type'			=> 'select',
			'name'			=> 'format',
			'choices'		=> $choices
		));
	}

	private function parse_format( $format )
	{
		$elements = explode('/', str_replace('|', '', $format));
		if (count($elements) !== 3) {
			return $this->parse_format($this->defaults['format']);
		}

		return array(
			'decimals'		 		=> $elements[0],
			'decimal_point'			=> $elements[1],
			'thousands_separator' 	=> $elements[2]
		);
	}

	public function render_field( $field )
	{
		$format = $this->parse_format( $field['format'] );
		?>
		<input type="text" id="<?php echo $field['id'] ?>" class="acf_price"
			name="<?php echo esc_attr($field['name']) ?>"
			value="<?php echo esc_attr($field['value']) ?>"
			data-format-decimals="<?php echo $format['decimals'] ?>"
			data-format-decimal_point="<?php echo $format['decimal_point'] ?>"
			data-format-thousands_separator="<?php echo $format['thousands_separator'] ?>"
		/>
		<?php
	}

	public function input_admin_enqueue_scripts()
	{
		wp_register_script( 'jquery-numeric', $this->settings['url'] . 'js/jquery.number.min.js', array( 'jquery' ), $this->settings['version'] );
		wp_register_script( 'acf-price-v5', $this->settings['url'] . 'js/acf-price-v5.js', array( 'jquery', 'jquery-numeric' ), $this->settings['version'] );

		wp_enqueue_script( 'acf-price-v5' );
	}

	public function update_value( $value, $post_id, $field )
	{
		$format = $this->parse_format( $field['format'] );
		$value = str_replace( array( $format['decimal_point'], $format['thousands_separator'] ), array( '.', '' ), $value );
		return floatval($value);
	}

	public function format_value( $value, $post_id, $field )
	{
		$format = $this->parse_format( $field['format'] );

		if( empty( $value ) ) {
			$value = 0;
		}

		$value = floatval($value);

		return number_format( $value, $format['decimals'], $format['decimal_point'], $format['thousands_separator'] );
	}
}