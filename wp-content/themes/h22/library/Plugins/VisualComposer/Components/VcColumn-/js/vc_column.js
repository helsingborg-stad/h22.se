window.ViewVCColumnModule = window.VcColumnView.extend({
  buildDesignHelpers: function() {
    if (window.VcColumnView.__super__.buildDesignHelpers) {
      window.VcColumnView.__super__.buildDesignHelpers.call(this);
    }
    var $columnToggle = this.$el.find(this.designHelpersSelector).get(0);
    var colorTheme = this.model.getParam('color_theme');
    this.$el.find('> .vc_controls .c-section').remove();
    $(
      '<span class="c-section vc_color_dot c-section--color-theme-' +
        colorTheme +
        '"></span>',
    ).insertAfter($columnToggle);

    var hiddenSizes = this.model.getParam('hidden_sizes');
    this.$el.find('.hidden-sizes').remove();
    if (hiddenSizes && hiddenSizes.length > 0) {
      $(
        '<div class="hidden-sizes" style="padding: 10px 5px; background-color: #5b9dd9; color: white;"><span>Hidden in ' +
          hiddenSizes +
          '</span></div>',
      ).insertAfter(this.$el.find('> .vc_controls:first-child'));
    }
  },
});
