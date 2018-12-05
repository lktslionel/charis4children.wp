<?php
/* 
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2017 ThemePunch
*/

if( !defined( 'ABSPATH') ) exit();

class RsAddonParticlesSliderFront {
	
	protected function enqueueScripts() {
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		
	}
	
	protected function enqueuePreview() {
		
		add_action('revslider_preview_slider_head', array($this, 'enqueue_preview'));
		
	}
	
	protected function writeInitScript() {
		
		add_action('revslider_fe_javascript_output', array($this, 'write_init_script'), 10, 2);
		
	}
	
	public function enqueue_scripts() {
		
		$ops           = new RevSliderOperations();
		$globals       = $ops->getGeneralSettingsValues();
		
		$putJsToFooter = RevSliderFunctions::getVal($globals, 'js_to_footer', 'off') === 'off';
		
		$_handle       = 'rs-' . static::$_PluginTitle . '-front';
		$_base         = static::$_PluginUrl . 'public/assets/';
		
		wp_enqueue_style(
		
			$_handle, 
			$_base . 'css/revolution.addon.' . static::$_PluginTitle . '.css', 
			array(), 
			static::$_Version
			
		);
		
		wp_enqueue_script(
		
			$_handle, 
			$_base . 'js/revolution.addon.' . static::$_PluginTitle . '.min.js', 
			array('jquery', 'revmin'), 
			static::$_Version, 
			$putJsToFooter
			
		);
		
	}
	
	public function enqueue_preview() {
		
		$_base = static::$_PluginUrl . 'public/assets/';
		
		?>
		<link type="text/css" rel="stylesheet" href="<?php echo $_base . 'css/revolution.addon.' . static::$_PluginTitle . '.css'; ?>" />
		<script type="text/javascript" src="<?php echo $_base . 'js/revolution.addon.' . static::$_PluginTitle . '.min.js'; ?>"></script>
		<?php
		
	}

	public function write_init_script($_slider, $_id) {
		
		$_title = static::$_PluginTitle;
		$_enabled = $_slider->getParam($_title . '_enabled', false) == 'true';

		if($_enabled && wp_is_mobile()) $_enabled = $_slider->getParam('particles_hide_on_mobile', true) == 'false';
		if($_enabled) {
		
			$_id    = $_slider->getID();
			
			echo                  "\n";
			echo '                Rs' . ucfirst($_title) . 'AddOn(revapi' . $_id . ');' . "\n";
			
		}
		
	}
	
}
?>