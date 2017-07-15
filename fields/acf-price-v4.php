<?php

class acf_price extends acf_price_common
{
    //render_field_settings
    function create_options( $field )
    {
        $key = $field['name'];

        ?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
    <td class="label">
        <label><?php _e('Format', 'acf-price'); ?></label>
        <p class="description"><?php  _e('Number format template', 'acf-price'); ?></p>
    </td>
    <td>
        <?php

        do_action('acf/create_field', array(
            'type'      =>  'select',
            'name'      =>  'fields['.$key.'][format]',
            'value'     =>  $field['format'],
            'layout'    =>  'horizontal',
            'choices'   =>  $this->formats
        ));

        ?>
    </td>
</tr>
        <?php
    }

    //render_field
    function create_field( $field )
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
        wp_register_script( 'acf-price-v4', $this->settings['url'] . 'assets/js/acf-price-v4.js', array( 'jquery', 'jquery-numeric' ), $this->settings['version'] );

        wp_enqueue_script( 'acf-price-v4' );
    }
}
