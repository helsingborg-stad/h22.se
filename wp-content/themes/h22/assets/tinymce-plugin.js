function getTargetElm(editor) {
	return document.getElementById(editor.id);
}

function getWrapper(editor) {
	return getTargetElm(editor).closest('.wp-editor-wrap');
}

function getCurrentShortcode(editor) {
	var node = getTargetElm(editor);
	while (node && !(node.dataset && node.dataset.vcShortcode)) {
		node = node.parentNode;
	}
	return node && node.dataset && node.dataset.vcShortcode;
}

tinymce.PluginManager.add('h22', function(editor, url) {
	switch (getCurrentShortcode(editor)) {
		// case 'vc_h22_teaser':
		// case 'vc_column_text':
		default:
			// Remove "Add media" buttons
			var wrapper = getWrapper(editor);
			var mediaButtons = wrapper.querySelector('.wp-media-buttons');
			if (mediaButtons) {
				mediaButtons.innerHTML = '';
			}
			break;
	}
});
