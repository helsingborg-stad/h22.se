window.ViewVCRowModule = window.VcRowView.extend({
	// Render method called after element is added( cloned ), and on first initialisation
	render: function () {
		window.ViewVCRowModule.__super__.render.call(this); //make sure to call __super__. To execute logic fron inherited view. That way you can extend original logic. Otherwise, you will fully rewrite what VC will do at this event
		this.renderMobileInvertedColumns(this.model);

		return this;
	},
	ready: function (e) {
		window.ViewVCRowModule.__super__.ready.call(this, e);

		return this;
	},
	//Called every time when params is changed/appended. Also on first initialisation
	changeShortcodeParams: function (model) {
		window.ViewVCRowModule.__super__.changeShortcodeParams.call(this, model);

		this.renderMobileInvertedColumns(this.model);
	},
	changeShortcodeParent: function (model) {
		window.ViewVCRowModule.__super__.changeShortcodeParent.call(this, model);
	},
	deleteShortcode: function (e) {
		window.ViewVCRowModule.__super__.deleteShortcode.call(this, e);
	},
	editElement: function (e) {
		window.ViewVCRowModule.__super__.editElement.call(this, e);
	},
	clone: function (e) {
		window.ViewVCRowModule.__super__.clone.call(this, e);
	},
	renderMobileInvertedColumns: function (model) {
		var $containerElement = model.view.$el;
		var $prependToElement = model.view.$el.find(".wpb_element_wrapper").first();
		$containerElement.find(".vc_row_mobile_invert_cols").remove();
		if (model && model.getParam("mobile_invert_cols") === "yes") {
			var $mobileInvertColsContainer = jQuery("<div>", {
				class: "vc_row_mobile_invert_cols",
			});
			$mobileInvertColsContainer.css({
				"background-color": "#f3a84a",
				padding: "10px",
			});
			var $smartphoneIcon = jQuery("<span>", {
				class: "icon icon-smartphone",
			});
			$smartphoneIcon.css({
				"font-size": "18px",
			});
			$smartphoneIcon.text("Inverted columns are active in tablet/mobile view");
			$mobileInvertColsContainer.append($smartphoneIcon);

			$prependToElement.prepend($mobileInvertColsContainer);
		}
	},
});
