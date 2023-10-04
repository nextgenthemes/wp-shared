<?php declare(strict_types=1);
namespace Nextgenthemes\WP\Admin;

use function \Nextgenthemes\WP\attr;
use function \Nextgenthemes\WP\get_defined_key;
use function \Nextgenthemes\WP\has_valid_key;

function label_text( array $option ): void {
	?>
	<span class="nextgenthemes-label-text">
		<?php
		echo esc_html( $option['label'] );

		if ( $option['premium'] ) {

			printf(
				' <span>(</span><a href="https://nextgenthemes.com/plugins/arve-%s">%s</a><span>)</span>',
				esc_attr( $option['tag'] ),
				esc_html( $option['tag_name'] )
			);
		}

		if ( ! empty( $option['tag'] ) && 'not' === $option['tag'] ) : // TODO this seems to be unused
			?>
			&nbsp;
			<span class="button-primary button-primary--ngt-small">
				<?php echo esc_html( $option['tag'] ); ?>
			</span>
		<?php endif; ?>
	</span>
	<?php
}

function print_boolean_field( string $key, array $option ): void {
	?>
	<p>
		<label>
			<input
				type="checkbox"
				x-model="<?php echo esc_attr( "options.$key" ); ?>"
			>
			<?php label_text( $option ); ?> -- <span x-text="<?php echo esc_attr( "options.$key" ); ?>"></span>
		</label>
	</p>
	<?php
}

function print_boolean_radio_field( string $key, array $option ): void {
	?>
	<p>
		<?php label_text( $option ); ?>
		<label>
			<input
				type="radio"
				x-model="<?php echo esc_attr( "options.$key" ); ?>"
				v-bind:value="true"
				name="<?php echo esc_attr( "options.$key" ); ?>"
			>
			Yes
		</label>
		&nbsp;&nbsp;&nbsp;
		<label>
			<input
				type="radio"
				x-model="<?php echo esc_attr( "options.$key" ); ?>"
				v-bind:value="false"
				name="<?php echo esc_attr( "options.$key" ); ?>"
			>
			No
		</label>
	</p>
	<?php
}

function print_string_field( string $key, array $option ): void {
	?>
	<p>
		<label>
			<?php label_text( $option ); ?>
			<input
				x-model.debounce="<?php echo esc_attr( "options.$key" ); ?>"
				type="text"
				class="large-text"
				placeholder="<?php echo esc_attr( $option['placeholder'] ); ?>"
			/>
			<span x-text="<?php echo esc_attr( "options.$key" ); ?>"></span>
		</label>
	</p>
	<?php
}

function print_hidden_field( string $key, array $option ): void {} // yes we need this nothing function

function print_old_hidden_field( string $key, array $option ): void {
	?>
	<input x-model="<?php echo esc_attr( "options.$key" ); ?>" type="hidden" />
	<?php
}

function print_licensekey_field( string $key, array $option ): void {

	$readonly = get_defined_key( $key ) ? 'readonly' : '';
	?>
	<p>
		<label>
			<?php label_text( $option ); ?>
			<input x-model="<?php echo esc_attr( "options.$key" ); ?>" type="text" class="medium-text" style="width: 350px;" <?php echo esc_attr( $readonly ); ?> />
			<?php if ( has_valid_key( $key ) ) : ?>
				<button @click="action( 'deactivate', '<?php echo esc_attr( "options.$key" ); ?>' )" class="button button-secondary">Deactivate</button>
			<?php else : ?>
				<button @click="action( 'activate', '<?php echo esc_attr( "options.$key" ); ?>' )" class="button button-secondary">Activate</button>
			<?php endif; ?>
			<br>
			Status: <?php echo esc_html( "{{ vm.{$key}_status }}" ); ?>
		</label>
	</p>
	<?php
}

function print_image_upload_field( string $key, array $option ): void {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_media();
	?>
	<p>
		<label>
			<?php label_text( $option ); ?>
			<input x-model="<?php echo esc_attr( "options.$key" ); ?>" type="text" class="large-text" />
			<a class="button-secondary" @click="<?php echo esc_attr( "uploadImage('$key')" ); ?>">
				<?php esc_html_e( 'Upload Image', 'advanced-responsive-video-embedder' ); ?>
			</a>
		</label>
	</p>
	<?php
}

function print_integer_field( string $key, array $option ): void {
	?>
	<p>
		<label>
			<?php label_text( $option ); ?>
			<input x-model="<?php echo esc_attr( "options.$key" ); ?>" type="number" />
		</label>
	</p>
	<?php
}

function print_select_field( string $key, array $option ): void {

	?>
	<p>
		<label>
			<?php label_text( $option ); ?>
			<select x-model="<?php echo esc_attr( "options.$key" ); ?>" >
				<option disabled>Please select one</option>
				<?php foreach ( $option['options'] as $k => $v ) : ?>
					<option value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</p>
	<?php
}

function block_attr( $key, $option ) {

	if ( empty( $option['tag'] ) ) {
		$block_attr['class'] = "ngt-option-block ngt-option-block--$key";
	} else {
		$block_attr = array(
			'class'  => "ngt-option-block ngt-option-block--$key ngt-option-block--{$option['tag']}",
			'v-show' => "sectionsDisplayed['{$option['tag']}']",
		);
	}

	return attr( $block_attr );
}

function print_settings_blocks( array $settings, array $sections, array $premium_sections, string $context ): void {

	$description_allowed_html = array(
		'a'      => array(
			'href'   => array(),
			'target' => array(),
			'title'  => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'code'   => array(),
	);

	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	foreach ( $settings as $key => $option ) {

		if ( 'settings-page' === $context && empty($option['option']) ) {
			continue;
		}

		if ( 'settings-page' === $context && ! empty($option['options']) ) {
			unset($option['options']['']);
		}

		$option['premium']  = in_array( $option['tag'], $premium_sections, true );
		$option['tag_name'] = $sections[ $option['tag'] ];
		$field_type         = isset( $option['ui'] ) ? $option['ui'] : $option['type'];
		$block_class        = "ngt-option-block ngt-option-block--$key ngt-option-block--{$option['tag']}";

		if ( 'hidden' !== $field_type ) :
			?>
			<div 
				class="<?php echo esc_attr( $block_class ); ?>"
				x-showw="tab == '<?php echo esc_attr( $option['tag'] ); ?>'"
			>
				<?php
				$function = __NAMESPACE__ . "\\print_{$field_type}_field";

				$function( $key, $option );

				if ( ! empty( $option['description'] ) ) {
					printf(
						'<p>%s</p>',
						wp_kses( $option['description'], $description_allowed_html )
					);
				}
				?>
				<hr>
			</div>
			<?php
		endif;
	}
}
