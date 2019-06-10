# H22

## Getting started

1. Install dependencies.

   ```
   composer install
   npm install
   ```

2. Create `config/database.php` based on `config/database-example.php` and update it to match yout database setup (and create the database).
3. Create `config/salts.php` based on `config/salts-example.php` and update it with values generated here: https://api.wordpress.org/secret-key/1.1/salt/.
4. Go to `wp-content/themes/h22` and install dependencies.

   ```
   npm install
   ```

## Creating components

The theme uses WPBakery Page Builder (aka Visual Composer). This is how you add a new component to Visual Composer with a Blade template.

1. Create a folder in wp-content/themes/h22/library/Plugins/VisualComposer/Components/ named after the component in upper camel case, e.g. `ButtonGroup`.
2. Create a php file in the new folder with the same name, e.g. `ButtonGroup.php`.
3. Create a class in the php file that in the namespace matching the filepath and that extends `\WPBakeryShortCode`, `\WPBakeryShortCodesContainer` or the shortcode you wish to override. Because the file is included twice by Visual Composer, the class declaration should also be wrapped in a if statement that checks if the class in already defined. The class must also use the `\H22\Plugins\VisualComposer\Components\BaseComponentController` trait. Example:

   ```php
   <?php
   namespace H22\Plugins\VisualComposer\Components\Card;

   use H22\Plugins\VisualComposer\Components\BaseComponentController;

   if (!class_exists('\H22\Plugins\VisualComposer\Components\Card\Card')):
     class Card extends \WPBakeryShortCode
     {
       use BaseComponentController;

       public function __construct()
       {
         $settings = array(
           'name' => __('Card', 'h22'),
           'base' => 'vc_h22_card',
           'class' => '',
           'icon' => 'icon-wpb-ui-button',
           'description' => __('Card', 'h22'),
           'category' => __('Content', 'js_composer'),
           'params' => array(
             array(
               'type' => 'textfield',
               'heading' => __('Heading', 'h22'),
               'param_name' => 'heading',
             ),
           ),
           'html_template' => dirname(__FILE__) . '/Card.php',
         );
         $init = $this->init($settings);
         if ($init) {
           parent::__construct($settings);
         }
       }
       public function prepareData($data)
       {
         // Create a new associative array of data for the balde template and return
         return $data;
       }
     }
   endif;
   ?>
   ```

4. Create a blade file inside a views folder with the same name as the component folder but in lowercase, e.g. `views/buttongroup.blade.php`.
5. If you need to add CSS for the component, create a Sass file in wp-content/themes/h22/assets/source/sass/components. Include the file inside wp-content/themes/h22/assets/source/sass/app.scss, e.g. `@import 'components/button-group'`.

Check out the WPBakery Page Builder API documentation: https://kb.wpbakery.com/docs/inner-api/

## Activating and deactivating default VC components

To add or remove built-in components go to wp-content/themes/h22/library/Plugins/VisualComposer/RemoveElements.php and update the `allThemeRegisteredVcModules` method.
