(function($){
	var getValues = function() {
		var values = [];
		$(".vc_column_offset_field").each(function( key, element ) {
			if ($(element).is("select")) {
				if ($(element).val().length > 0) {
					values.push($(element).val());
				}
			}

			if ($(element).attr("type") === "checkbox" && $(element).is(":checked")) {
				values.push($(element).attr("name"));
			}
		});
        
		return values.join(" ");
	};
    
	$(".vc_column_offset_field").change(function() {
		$("input[name=\"offset\"]").val(getValues());
	});
    
})(jQuery);
  
