window.ViewVcColumnInnerModule = window.VcColumnView.extend({
  offsetClasses: [],
  render: function () {
    if (window.VcColumnView.__super__.render) {
      window.ViewVcColumnInnerModule.__super__.render.call(this);
    }

    // Remove default column class
    this.$el.removeClass(this.convertSize(this.current_column_width));
    return this;
  },
  changeShortcodeParams: function (model) {
    if (window.ViewVcColumnInnerModule.__super__.changeShortcodeParams) {
      window.ViewVcColumnInnerModule.__super__.changeShortcodeParams.call(this, model);
    }

    // Custom column functionality
    this.setColumnClasses(model);
  },
  setColumnClasses: function (model) {
    // Disables parent class behaviour
    if (typeof model !== 'undefined') {
        var offset, width;
        offset = model.getParam( 'offset' ) || '';
        width = model.getParam( 'width' ) || '1/1'; 
 

        // Remove old class
        if (typeof this.css_class_width !== 'undefined') {
          this.$el.removeClass( 'vc_col-md-' + this.css_class_width );
        }
    
        // Add default breakpoint width class
        this.css_class_width = this.convertSize(width);
        if ( this.css_class_width !== width ) {
          this.css_class_width = this.css_class_width.replace( /[^\d]/g, '' );
        }
        this.$el.addClass( 'vc_col-md-' + this.css_class_width );

        // Remove old offset classes
        if ( ! _.isEmpty( this.offsetClasses ) ) {
          this.offsetClasses.forEach(function(offsetClass) {
            this.$el.removeClass(offsetClass);
          }.bind(this));

          this.offsetClasses = [];
        }
    
        // Apoebd new offset classes
        if ( ! _.isEmpty( offset ) ) {
          this.offsetClasses = offset.split(' ');

          this.offsetClasses.forEach(function(offsetClass) {
            this.$el.addClass(offsetClass);
          }.bind(this));
        }
    }
  },
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
