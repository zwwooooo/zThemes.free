(function($, window){
	$(function(){
		var textarea_name = 'sidebar_ad_area_long_text_ad_only_home_html_id';
		$('textarea[name="'+textarea_name+'"]').attr('data-customize-setting-link',textarea_name);
		setTimeout(function(){
			var editor2 = tinyMCE.get(textarea_name);
			if(editor2){
				editor2.onChange.add(function (ed, e) {
					// Update HTML view textarea (that is the one used to send the data to server).
					ed.save();
					$('textarea[name="'+textarea_name+'"]').trigger('change');
				});
			}
		}, 1000);
	})
})(jQuery, window);