<?php

class acf_price extends acf_price_common
{
	public function render_field_settings( $field )
	{
		acf_render_field_setting( $field, array(
			'label'			=> __('Format', 'acf-price'),
			'instructions'	=> __('Number format template', 'acf-price'),
			'type'			=> 'select',
			'name'			=> 'format',
			'choices'		=> $this->formats
		));
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
		wp_register_script( 'jquery-numeric', $this->settings['url'] . 'assets/js/jquery.number.min.js', array( 'jquery' ), $this->settings['version'] );
		wp_register_script( 'acf-price-v5', $this->settings['url'] . 'assets/js/acf-price-v5.js', array( 'jquery', 'jquery-numeric' ), $this->settings['version'] );

		wp_enqueue_script( 'acf-price-v5' );
	}

	public function update_value( $value, $post_id, $field )
	{
		$format = $this->parse_format( $field['format'] );
		$value = str_replace( array( $format['thousands_separator'], $format['decimal_point'] ), array( '', '.' ), $value );

		return $value;
	}

	public function load_value( $value, $post_id, $field )
	{
		$format = $this->parse_format( $field['format'] );

		if( empty( $value ) ) {
			$value = 0;
		}

		return number_format( $value, $format['decimals'], $format['decimal_point'], $format['thousands_separator'] );
	}
}