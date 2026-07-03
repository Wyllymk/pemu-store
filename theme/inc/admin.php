<?php
/**
 * Pemu — inc/admin.php
 * Theme admin settings page for business info, branding, and content.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Register the admin menu page.
 */
add_action( 'admin_menu', 'pemu_register_admin_page' );
function pemu_register_admin_page(): void {
	add_menu_page(
		'🌿 Pemu Settings',
		'🌿 Pemu',
		'manage_options',
		'pemu-settings',
		'pemu_admin_page_html',
		'',
		30
	);
}

/**
 * Register settings.
 */
add_action( 'admin_init', 'pemu_register_admin_settings' );
function pemu_register_admin_settings(): void {
	$settings = pemu_admin_settings_fields();
	foreach ( $settings as $section_id => $section ) {
		foreach ( $section['fields'] as $field_id => $field ) {
			$args = [
				'id'          => $field_id,
				'type'        => $field['type'] ?? 'text',
				'default'     => $field['default'] ?? '',
				'options'     => $field['options'] ?? [],
				'description' => $field['description'] ?? '',
				'placeholder' => $field['placeholder'] ?? '',
			];
			register_setting( 'pemu_settings', $field_id, [
				'sanitize_callback' => $field['sanitize'] ?? 'sanitize_text_field',
				'default'           => $args['default'],
			] );
		}
	}
}

/**
 * Define all admin settings fields.
 */
function pemu_admin_settings_fields(): array {
	return [
		'branding' => [
			'title'  => '🖌️ Branding',
			'fields' => [
				'pemu_site_name' => [
					'label'       => 'Site Name',
					'type'        => 'text',
					'default'     => 'Pemu Ventures',
					'description' => 'Used in the header logo and SEO title.',
				],
				'pemu_site_tagline' => [
					'label'       => 'Tagline',
					'type'        => 'text',
					'default'     => 'Your health, Our priority.',
					'description' => 'Shown below the logo in the header.',
				],
				'pemu_logo' => [
					'label'       => 'Logo URL',
					'type'        => 'image',
					'default'     => '',
					'description' => 'Upload or paste a logo image URL. If empty, the default SVG logo is used.',
				],
			],
		],
		'contact' => [
			'title'  => '📞 Contact & Social',
			'fields' => [
				'pemu_whatsapp_number' => [
					'label'       => 'WhatsApp Number',
					'type'        => 'text',
					'default'     => '254707551484',
					'sanitize'    => 'pemu_sanitize_phone_number',
					'description' => 'Without + prefix. e.g. 254707551484',
				],
				'pemu_email' => [
					'label'       => 'Email Address',
					'type'        => 'email',
					'default'     => 'Pemuherbalsupplements@gmail.com',
					'description' => 'Used for order notifications and contact forms.',
				],
				'pemu_address' => [
					'label'       => 'Physical Address',
					'type'        => 'text',
					'default'     => 'Nairobi, Kenya',
				],
				'pemu_phone' => [
					'label'       => 'Phone Number (display)',
					'type'        => 'text',
					'default'     => '0707 551 484',
					'description' => 'Displayed on the site (not used for WhatsApp).',
				],
				'pemu_social_tiktok' => [
					'label'       => 'TikTok URL',
					'type'        => 'url',
					'default'     => 'https://tiktok.com/@pemuventures',
				],
				'pemu_social_instagram' => [
					'label'       => 'Instagram URL',
					'type'        => 'url',
					'default'     => 'https://instagram.com/pesh_muturi',
				],
				'pemu_social_facebook' => [
					'label'       => 'Facebook URL',
					'type'        => 'url',
					'default'     => '',
				],
			],
		],
		'homepage' => [
			'title'  => '🏠 Homepage Hero',
			'fields' => [
				'pemu_hero_headline' => [
					'label'       => 'Hero Headline',
					'type'        => 'text',
					'default'     => 'Natural Health. Real Results.',
				],
				'pemu_hero_subheadline' => [
					'label'       => 'Hero Sub-headline',
					'type'        => 'textarea',
					'default'     => 'Trusted organic products for energy, immunity, detox & hormone balance. All natural, no GMO, gluten free, vegan. Countrywide delivery.',
				],
				'pemu_hero_cta_primary' => [
					'label'       => 'Primary CTA Text',
					'type'        => 'text',
					'default'     => 'Shop Now',
				],
				'pemu_hero_cta_wa' => [
					'label'       => 'WhatsApp CTA Text',
					'type'        => 'text',
					'default'     => 'Order via WhatsApp',
				],
				'pemu_hero_badge' => [
					'label'       => 'Hero Badge Text',
					'type'        => 'text',
					'default'     => '🌿 All Natural · No GMO · Organic',
				],
				'pemu_hero_social_proof' => [
					'label'       => 'Hero Social Proof',
					'type'        => 'text',
					'default'     => 'Trusted by thousands of Kenyans',
				],
				'pemu_hero_image' => [
					'label'       => 'Hero Background Image URL',
					'type'        => 'image',
					'default'     => '',
					'description' => 'Upload a hero background image (recommended: 1920×900).',
				],
			],
		],
		'footer' => [
			'title'  => '🦶 Footer',
			'fields' => [
				'pemu_footer_tagline' => [
					'label'       => 'Footer Tagline',
					'type'        => 'textarea',
					'default'     => 'Natural health, real results! Trusted organic products for energy, immunity, detox & hormone balance.',
				],
				'pemu_footer_copyright' => [
					'label'       => 'Copyright Text',
					'type'        => 'text',
					'default'     => '© ' . date( 'Y' ) . ' Pemu Ventures. All rights reserved.',
				],
			],
		],
	];
}

/**
 * Render the admin page HTML.
 */
function pemu_admin_page_html(): void {
	if ( ! current_user_can( 'manage_options' ) ) return;

	$active_tab = $_GET['tab'] ?? 'branding';
	$sections   = pemu_admin_settings_fields();
	?>
	<div class="wrap" style="max-width:900px;margin:20px auto;">
		<div style="background:#fff;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,.08);overflow:hidden;">
			<div style="background:linear-gradient(135deg,#1E4D6B,#153a52);padding:24px 32px;">
				<h1 style="color:#fff;margin:0;font-size:24px;font-weight:800;display:flex;align-items:center;gap:10px;">
					<span style="font-size:28px;">🌿</span> Pemu Theme Settings
				</h1>
				<p style="color:rgba(255,255,255,.7);margin:6px 0 0;font-size:13px;">
					Configure your store branding, contact info, homepage content, and footer.
				</p>
			</div>

			<!-- Tabs -->
			<div style="border-bottom:1px solid #e2e8f0;padding:0 24px;display:flex;gap:4px;overflow-x:auto;">
				<?php foreach ( $sections as $key => $section ) : ?>
					<a href="?page=pemu-settings&tab=<?php echo esc_attr( $key ); ?>"
					   style="display:inline-block;padding:14px 18px 12px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:3px solid <?php echo $active_tab === $key ? '#6DB33F' : 'transparent'; ?>;color:<?php echo $active_tab === $key ? '#1e293b' : '#64748b'; ?>;transition:all .15s;">
						<?php echo esc_html( $section['title'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>

			<!-- Form -->
			<form method="post" action="options.php" style="padding:24px 32px 32px;">
				<?php settings_fields( 'pemu_settings' ); ?>
				<?php
				$current_section = $sections[ $active_tab ] ?? reset( $sections );
				foreach ( $current_section['fields'] as $field_id => $field ) :
					$value = get_option( $field_id, $field['default'] ?? '' );
				?>
				<div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #f1f5f9;">
					<label for="<?php echo esc_attr( $field_id ); ?>" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:4px;">
						<?php echo esc_html( $field['label'] ); ?>
					</label>
					<?php if ( $field['description'] ?? '' ) : ?>
						<p style="margin:0 0 8px;font-size:12px;color:#94a3b8;"><?php echo esc_html( $field['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( $field['type'] === 'textarea' ) : ?>
						<textarea id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_id ); ?>"
						          style="width:100%;max-width:600px;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;line-height:1.5;color:#1e293b;background:#f8fafc;min-height:80px;"
						          placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
					<?php elseif ( $field['type'] === 'image' ) : ?>
						<div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
							<input type="text" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_id ); ?>"
							       value="<?php echo esc_attr( $value ); ?>"
							       style="flex:1;min-width:200px;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;color:#1e293b;background:#f8fafc;"
							       placeholder="https://example.com/image.jpg">
							<button type="button" class="button pemu-upload-btn" data-target="<?php echo esc_attr( $field_id ); ?>"
							        style="padding:6px 16px;border-radius:8px;">Upload Image</button>
							<?php if ( $value ) : ?>
								<img src="<?php echo esc_url( $value ); ?>" style="max-width:80px;max-height:80px;border-radius:8px;border:1px solid #e2e8f0;">
							<?php endif; ?>
						</div>
					<?php elseif ( $field['type'] === 'email' ) : ?>
						<input type="email" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_id ); ?>"
						       value="<?php echo esc_attr( $value ); ?>"
						       style="width:100%;max-width:600px;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;color:#1e293b;background:#f8fafc;"
						       placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>">
					<?php elseif ( $field['type'] === 'url' ) : ?>
						<input type="url" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_id ); ?>"
						       value="<?php echo esc_attr( $value ); ?>"
						       style="width:100%;max-width:600px;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;color:#1e293b;background:#f8fafc;"
						       placeholder="https://">
					<?php else : ?>
						<input type="text" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_id ); ?>"
						       value="<?php echo esc_attr( $value ); ?>"
						       style="width:100%;max-width:600px;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;color:#1e293b;background:#f8fafc;"
						       placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>">
					<?php endif; ?>
				</div>
				<?php endforeach; ?>

				<div style="margin-top:24px;display:flex;gap:10px;align-items:center;">
					<?php submit_button( '💾 Save Settings', 'primary', 'submit', false, [
						'style' => 'padding:10px 28px;border-radius:10px;font-weight:700;font-size:14px;background:#6DB33F;border-color:#6DB33F;color:#fff;',
					] ); ?>
				</div>
			</form>
		</div>

		<!-- Footer note -->
		<p style="text-align:center;margin-top:16px;font-size:12px;color:#94a3b8;">
			Pemu Theme v<?php echo esc_html( wp_get_theme()->get( 'Version' ) ); ?> &mdash;
			Built with ❤️ for Pemu Ventures
		</p>
	</div>

	<script>
	// Media uploader for image fields
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelectorAll('.pemu-upload-btn').forEach(function(btn) {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				var target = this.getAttribute('data-target');
				var input = document.getElementById(target);
				if (!input) return;

				// If wp.media is available, use it
				if (typeof wp !== 'undefined' && wp.media) {
					var frame = wp.media({
						title: 'Select Image',
						button: { text: 'Use this image' },
						multiple: false
					});
					frame.on('select', function() {
						var attachment = frame.state().get('selection').first().toJSON();
						input.value = attachment.url;
						// Show preview
						var preview = input.parentElement.querySelector('img');
						if (preview) {
							preview.src = attachment.url;
						} else {
							var img = document.createElement('img');
							img.src = attachment.url;
							img.style.cssText = 'max-width:80px;max-height:80px;border-radius:8px;border:1px solid #e2e8f0;';
							input.parentElement.appendChild(img);
						}
					});
					frame.open();
				} else {
					// Fallback: prompt for URL
					var url = prompt('Enter image URL:', input.value);
					if (url) input.value = url;
				}
			});
		});
	});
	</script>
	<?php
}

/**
 * Custom sanitize for phone numbers.
 */
function pemu_sanitize_phone_number( $value ): string {
	return preg_replace( '/[^0-9]/', '', $value );
}
