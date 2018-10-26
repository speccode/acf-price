(function($){

    function initialize_field( $el ) {
        var $input = $el.find('input');
		var val = $input.val();
		$input.number(true, $input.data('format-decimals'), $input.data('format-decimal_point'), $input.data('format-thousands_separator') );
		$input.val(val);
    }

    $(document).on('acf/setup_fields', function(e, postbox){
        $(postbox).find('.field[data-field_type="price"]').each(function(){
            initialize_field( $(this) );
        });
    });
})(jQuery);
