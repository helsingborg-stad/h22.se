<?php
define('H22_PATH', get_stylesheet_directory() . '/');

// Load translations
add_action('after_setup_theme', function () {
    load_theme_textdomain('h22', get_stylesheet_directory() . '/languages');
});

//Include vendor files
if (file_exists(dirname(ABSPATH) . '/vendor/autoload.php')) {
    require_once dirname(ABSPATH) . '/vendor/autoload.php';
}

//Include theme functions
require_once H22_PATH . 'library/Vendor/Psr4ClassLoader.php';
$loader = new H22\Vendor\Psr4ClassLoader();
$loader->addPrefix('H22', H22_PATH . 'library');
$loader->addPrefix('H22', H22_PATH . 'source/php/');
$loader->register();

//Load fields
add_action('init', function () {
    $acfExportManager = new \AcfExportManager\AcfExportManager();
    $acfExportManager->setTextdomain('h22');
    $acfExportManager->setExportFolder(H22_PATH . 'library/AcfFields');
    $acfExportManager->autoExport(array());
    $acfExportManager->import();
});

function html_build_attribute_value($value, $callback = 'htmlspecialchars') {
	if (!isset($value) || $value === false) {
		return null;
	}
	if ($value === true) {
		return '';
	}
	if (is_array($value)) {
		$value = implode(' ', array_filter(array_map('trim', $value)));
	}
	return $callback($value);
}

/**
 *  Join style array items into a string with key as CSS Propety and value as CSS Value.
 *  eg. ['background-color] => 'blue' -> "background-color: blue;"
 *  @param array $styleAttribute
 *  @return string|null
 */
function html_build_style_attributes($styleAttribute)
{
    if (!is_array($styleAttribute)
        || empty($styleAttribute)) {
        return null;
    }

    // Remove empty styles
    $styleAttribute = array_filter($styleAttribute, function ($style) {
        return is_string($style) && !empty($style);
    });

    if (empty($styleAttribute)) {
        return null;
    }

    $styles = array();
    foreach ($styleAttribute as $cssPropety => $cssValue) {
        if (substr($cssValue, -1) !== ';') {
            $cssValue .= ';';
        }

        $styles[] = $cssPropety . ': ' . $cssValue;
    }

    $styleAttribute = implode(' ', $styles);

    return $styleAttribute;
}

function html_build_attributes($attrs, $callback = 'htmlspecialchars')
{
    if (!is_array($attrs)) {
        return (string) $attrs;
    }
    $return = '';

    foreach ($attrs as $name => $value) {
        if ($name === 'style' && is_array($value)) {
            $value = html_build_style_attributes($value);
        }

        $value = html_build_attribute_value($value, $callback);
        if (!isset($value)) {
            continue;
        }
        $return .= ' ' . $callback($name) . '="' . $value . '"';
    }
    return $return;
}

// Remove add read more button
function tinymce_editor_buttons($buttons)
{
    foreach ($buttons as $key => $value) {
        if ($value == 'wp_more') {
            unset($buttons[$key]);
        }
    }
    return $buttons;
}

add_filter('mce_buttons', 'tinymce_editor_buttons', 99);

function custom_image_sizes($size_names)
{
    unset($size_names['thumbnail']);
    unset($size_names['medium']);
    unset($size_names['full']);

    return $size_names;
}
add_filter('image_size_names_choose', 'custom_image_sizes');

function h22_tiny_mce_before_init($settings)
{
    $plugins = explode(',', $settings['plugins']);
    $plugins[] = 'h22';
    $settings['plugins'] = implode(',', $plugins);

    // XXX: This is how you add more formats:
    # $extra_formats = [
    # 	'preamble' => [
    # 		'block' => 'p',
    # 		'classes' => ['preample'],
    # 		'title' => 'Preamble',
    # 	],
    # ];
    # // `$settings['formats']` can’t be json_decode’d because it’s not in real
    # // JSON format. We just splice our JSON into it just after the last `}`:
    # $settings['formats'] =
    # 	substr($settings['formats'], 0, -1) .
    # 	',' .
    # 	substr(json_encode($extra_formats), 1);

    // Remove `h1` and `pre` from the `formatselect` dropdown
    // XXX: The `formatselect` dropdown doesn’t work very well for anything other
    // than plain HTML tags, so adding the `preamble` format here wasn’t optimal.
    $settings['block_formats'] =
        # 'Preamble=preamble;' .
        'Paragraph=p;' .
        'Heading 2=h2;' .
        'Heading 3=h3;' .
        'Heading 4=h4;' .
        'Heading 5=h5;' .
        'Heading 6=h6;';

    $settings['toolbar1'] = implode(',', [
        'formatselect',
        'bold',
        'italic',
        'bullist',
        'numlist',
        'blockquote',
        'alignleft',
        'aligncenter',
        'alignright',
        'link',
        'spellchecker',
        'fullscreen',
        'wp_adv',
    ]);
    $settings['toolbar2'] = implode(',', [
        # 'styleselect',
        'metadata',
        'strikethrough',
        'pastetext',
        'removeformat',
        'charmap',
        'outdent',
        'indent',
        'undo',
        'redo',
        'wp_help',
        'pricons',
    ]);

    # // Adds custom options to the `styleselect` dropdown
    # $style_formats = json_decode($settings['style_formats'], true);
    # $style_formats = [];
    # $style_formats[] = [
    # 	'block' => 'p',
    # 	'title' => 'Paragraph',
    # ];
    # $style_formats[] = [
    # 	'format' => 'preamble',
    # 	'title' => 'Preamble',
    # ];
    # $style_formats[] = [
    # 	'block' => 'h2',
    # 	'title' => 'Heading 2',
    # ];
    # $style_formats[] = [
    # 	'block' => 'h3',
    # 	'title' => 'Heading 3',
    # ];
    # $style_formats[] = [
    # 	'block' => 'h4',
    # 	'title' => 'Heading 4',
    # ];
    # $settings['style_formats'] = json_encode($style_formats);
    #
    # // Override all default options in `styleselect` dropdown
    # $settings['style_formats_merge'] = false;

    return $settings;
}
add_filter('tiny_mce_before_init', 'h22_tiny_mce_before_init');

function h22_after_wp_tiny_mce()
{
    $src = get_stylesheet_directory_uri() . '/assets/tinymce-plugin.js';
    echo "<script type=\"text/javascript\" src=\"$src\"></script>";
}
add_action('after_wp_tiny_mce', 'h22_after_wp_tiny_mce');

//Run app
new H22\App();

// Example, How to add custom third party visual composer blade rendered components
// add_filter('helsingborg-h22/visual-composer/register-components', function($components) {
//     $components[dirname(__FILE__). '/ThirdParty/ButtonGroup'] = array(
//         'componentName' => 'ButtonGroup',
//         'namespace' => '\ThirdParty\ButtonGroup\ButtonGroup',
//     );
//     return $components;
// });

// Example, How to add custom third party component that overrides the base class
// add_filter('helsingborg-h22/visual-composer/init-class-component/card', function($class, $component, $path) {
//     require_once(dirname(__FILE__). '/ThirdParty/Card.php');
//     return '\ThirdParty\Card';
// }, 10, 3);
