(function($){

	function initialize_field( $el ) {
		var $input = $el.find('input');
		$input.number( true, $input.data('format-decimals'), $input.data('format-decimal_point'), $input.data('format-thousands_separator') );
	}

	acf.add_action('ready append', function( $el ) {
		acf.get_fields({ type : 'price'}, $el).each(function(){
			initialize_field( $(this) );
		});
	});
})(jQuery);
