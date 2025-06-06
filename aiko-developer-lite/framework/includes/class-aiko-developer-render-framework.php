<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( dirname( __DIR__ ) ) . 'includes/class-aiko-developer-core.php';

class Aiko_Developer_Render_Framework {
	public $core;
	
	public function __construct() {
		if ( class_exists( 'Aiko_Developer_Core_Lite' ) ) {
			$this->core = new Aiko_Developer_Core_Lite();
		} elseif ( class_exists( 'Aiko_Developer_Core' ) ) {
			$this->core = new Aiko_Developer_Core();
		}
	}

	private function aiko_developer_render_php( $post ) {
		$php_output = get_post_meta( $post->ID, '_php_output', true );
		?>
		<pre><?php echo esc_html( $php_output ); ?></pre>
		<div class="aiko-developer-code-actions">
			<button class="button button-secondary button-large aiko-developer-edit" data-type="php"><?php echo esc_html__( 'Edit', 'aiko-developer-lite' ); ?></button>
			<button class="button button-secondary button-large aiko-developer-copy-code aiko-developer-button-secondary" data-type="php"><?php echo esc_html__( 'Copy code', 'aiko-developer-lite' ); ?></button>
		</div>
		<?php
	}

	public function get_aiko_developer_render_php( $post ) {
		$this->aiko_developer_render_php( $post );
	}

	private function aiko_developer_render_js( $post ) {
		$js_output = get_post_meta( $post->ID, '_js_output', true );
		?>
		<pre><?php echo esc_html( $js_output ); ?></pre>
		<div class="aiko-developer-code-actions">
			<button class="button button-secondary button-large aiko-developer-edit" data-type="js"><?php echo esc_html__( 'Edit', 'aiko-developer-lite' ); ?></button>
			<button class="button button-secondary button-large aiko-developer-copy-code aiko-developer-button-secondary" data-type="js"><?php echo esc_html__( 'Copy code', 'aiko-developer-lite' ); ?></button>
		</div>
		<?php
	}

	public function get_aiko_developer_render_js( $post ) {
		$this->aiko_developer_render_js( $post );
	}

	private function aiko_developer_render_css( $post ) {
		$css_output = get_post_meta( $post->ID, '_css_output', true );
		?>
		<pre><?php echo esc_html( $css_output ); ?></pre>
		<div class="aiko-developer-code-actions">
			<button class="button button-secondary button-large aiko-developer-edit" data-type="css"><?php echo esc_html__( 'Edit', 'aiko-developer-lite' ); ?></button>
			<button class="button button-secondary button-large aiko-developer-copy-code aiko-developer-button-secondary" data-type="css"><?php echo esc_html__( 'Copy code', 'aiko-developer-lite' ); ?></button>
		</div>
		<?php
	}

	public function get_aiko_developer_render_css( $post ) {
		$this->aiko_developer_render_css( $post );
	}

	private function aiko_developer_render_home_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . '../assets/views/welcome.php';
		$ai_selection = get_option( 'aiko_developer_ai_selection', 'openai' );
		$key = 'aiko_developer_' . $ai_selection . '_api_key';
		$api_key = get_option( $key, '' ); 
		if ( empty( $api_key ) ) {
			$this->get_aiko_developer_render_settings_page();
		}
	}

	public function get_aiko_developer_render_home_page( $post ) {
		$this->aiko_developer_render_home_page( $post );
	}

	private function aiko_developer_render_settings_page() {
		$ai_selection = get_option( 'aiko_developer_ai_selection', 'openai' );
		$key = 'aiko_developer_' . $ai_selection . '_api_key';
		$api_key = get_option( $key, '' ); 
		?>
		<div class="wrap">
			<?php if ( empty( $api_key ) ) { ?>
			<div id="aiko-developer-api-not-present-wrapper" class="aiko-developer-notice aiko-developer-notice-show aiko-developer-notice-error">
				<div class="aiko-developer-notice-content">
					<p id="aiko-developer-api-not-present"><?php echo esc_html__( 'You must have ', 'aiko-developer-lite' ); ?><a href="<?php echo ( 'openai' === $ai_selection ? esc_url( 'https://platform.openai.com/api-keys' ) : ( 'deepseek' === $ai_selection ? esc_url( 'https://platform.deepseek.com/api_keys' ) : esc_url( 'https://console.anthropic.com/settings/keys' ) ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo ( 'openai' === $ai_selection ? esc_html__( 'OpenAI', 'aiko-developer-lite' ) : ( 'deepseek' === $ai_selection ? esc_html__( 'DeepSeek', 'aiko-developer-lite' ) : esc_html__( 'Anthropic', 'aiko-developer-lite' ) ) ) . esc_html__( ' API key', 'aiko-developer-lite' ); ?></a><?php echo esc_html__( ' if you want to use our plugin. Choose another platform or enter the API key.', 'aiko-developer-lite' ); ?></p>
				</div>
			</div>
			<?php } ?>
			<form method="post" class="aiko-developer-settings-form aiko-developer-hidden" action="options.php">
				<h1 class="aiko-developer-settings-on-top"><?php echo esc_html__( 'AIKO Settings', 'aiko-developer-lite' ); ?></h1>
				<?php
				settings_fields( 'aiko_developer_settings' );
				do_settings_sections( 'aiko_developer_settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function get_aiko_developer_render_settings_page() {
		$this->aiko_developer_render_settings_page();
	}

	private function aiko_developer_render_openai_api_key_field() {
		$api_key = get_option( 'aiko_developer_openai_api_key', '' );
		?>
		<input type="text" name="aiko_developer_openai_api_key" value="<?php echo esc_attr( $api_key ); ?>" class="regular-text">
		<input type="hidden" value="find-by-openai-api-key-field">
		<p class="description"><?php echo esc_html__( 'Please, enter your ', 'aiko-developer-lite' ); ?><a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'OpenAI API key', 'aiko-developer-lite' ); ?></a>.</p>
		<?php
	}

	public function get_aiko_developer_render_openai_api_key_field() {
		$this->aiko_developer_render_openai_api_key_field();
	}

	private function aiko_developer_render_openai_model_description() {
		?>
		<p class="description"><?php echo esc_html__( 'AI models serve three distinct roles: AI Developer, AI Reviewer, and AI Consultant.', 'aiko-developer-lite' ); ?></p>
		<?php
	}

	public function get_aiko_developer_render_openai_model_description() {
		$this->aiko_developer_render_openai_model_description();
	}

	private function aiko_developer_openai_model_array() {
		$models = array(
			'o4-mini'      => 'o4-mini',
			'o3'           => 'o3',
			'o3-mini'      => 'o3-mini',
			'o1'           => 'o1',
			'o1-mini'      => 'o1-mini',
			'gpt-4.1'      => 'gpt-4.1',
			'gpt-4.1-mini' => 'gpt-4.1-mini',
			'gpt-4.1-nano' => 'gpt-4.1-nano',
			'gpt-4o'       => 'gpt-4o',
			'gpt-4o-mini'  => 'gpt-4o-mini',
		);
		return $models;
	}

	public function get_aiko_developer_openai_model_array() {
		return $this->aiko_developer_openai_model_array();
	}

	private function aiko_developer_render_openai_model_field() {
		$model   = get_option( 'aiko_developer_openai_model', 'o3-mini' );
		$model   = $this->core->get_aiko_developer_o1_preview_fallback( $model, 'developer' );
		$options = $this->get_aiko_developer_openai_model_array();
		?>
		<select name="aiko_developer_openai_model" class="regular-text">
			<?php foreach ( $options as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $model, $value ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php echo esc_html__( 'Generates the actual code based on functional requirements, playing the most crucial role in our plugin.', 'aiko-developer-lite' ); ?></p>
		<p class="description"><a href="https://platform.openai.com/docs/models/" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Click here', 'aiko-developer-lite' ); ?></a><?php echo esc_html__( ' to learn more about OpenAI models. ', 'aiko-developer-lite' ); ?></p>
		<?php
	}

	public function get_aiko_developer_render_openai_model_field() {
		$this->aiko_developer_render_openai_model_field();
	}

	private function aiko_developer_render_consultant_openai_model_field() {
		$consultant_model = get_option( 'aiko_developer_consultant_openai_model', 'gpt-4.1' );
		$options          = $this->get_aiko_developer_openai_model_array();
		?>
		<select name="aiko_developer_consultant_openai_model" class="regular-text">
			<?php foreach ( $options as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $consultant_model, $value ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php echo esc_html__( 'Assists users in writing functional requirements by reformulating their input.', 'aiko-developer-lite' ); ?></p>
		<?php
	}

	public function get_aiko_developer_render_consultant_openai_model_field() {
		$this->aiko_developer_render_consultant_openai_model_field();
	}
}
