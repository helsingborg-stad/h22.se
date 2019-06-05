window.ViewVCSectionModule = window.VcSectionView.extend({
	buildDesignHelpers: function() {
		window.VcSectionView.__super__.buildDesignHelpers.call(this);
		var $elementToPrepend = this.$el.find(this.designHelpersSelector);
		var colorTheme = this.model.getParam('color_theme');
		this.$el.find('> .vc_controls .c-section').remove();
		$(
			'<span class="vc_row_color c-section c-section--color-theme-' +
				colorTheme +
				'"></span>',
		).insertAfter($elementToPrepend);
	},
});
