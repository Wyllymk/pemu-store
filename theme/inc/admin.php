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
					'default'     => 'Performance Supplements. Kenyan Prices.',
				],
				'pemu_hero_subheadline' => [
					'label'       => 'Hero Sub-headline',
					'type'        => 'textarea',
					'default'     => 'Lab-tested protein, creatine, pre-workout & wellness essentials. Delivered countrywide, paid on M-Pesa.',
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
					'default'     => '100% Authentic · Discreet Shipping',
				],
				'pemu_hero_social_proof' => [
					'label'       => 'Hero Social Proof',
					'type'        => 'text',
					'default'     => 'Trusted by 12,000+ Kenyans',
				],
				'pemu_hero_product_image' => [
					'label'       => 'Hero Product Image',
					'type'        => 'image',
					'default'     => '',
					'description' => 'Upload or choose an image to display inside the hero product showcase. Leave empty to show the featured product automatically or a default emoji.',
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

	$sections = pemu_admin_settings_fields();
	// Read active tab from sessionStorage via JS below; default to branding.
	// We still set a server-side default so the first load works without JS.
	$active_tab = 'branding';
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

			<!-- Form (ALL tabs rendered simultaneously, JS controls visibility) -->
			<form method="post" action="options.php" style="padding:24px 32px 32px;">
				<?php settings_fields( 'pemu_settings' ); ?>

				<!-- Tab navigation -->
				<div style="display:flex;gap:4px;overflow-x:auto;" data-pemu-tabs>
					<?php foreach ( $sections as $key => $section ) : ?>
						<button type="button"
						        data-tab="<?php echo esc_attr( $key ); ?>"
						        style="display:inline-block;padding:14px 18px 12px;font-size:13px;font-weight:600;border:none;background:none;cursor:pointer;border-bottom:3px solid <?php echo $active_tab === $key ? '#6DB33F' : 'transparent'; ?>;color:<?php echo $active_tab === $key ? '#1e293b' : '#64748b'; ?>;transition:all .15s;">
							<?php echo esc_html( $section['title'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>

				<?php foreach ( $sections as $sec_key => $section ) : ?>
				<div class="pemu-tab-panel" id="pemu-panel-<?php echo esc_attr( $sec_key ); ?>"
				     style="<?php echo $active_tab === $sec_key ? '' : 'display:none;'; ?>">
					<?php foreach ( $section['fields'] as $field_id => $field ) :
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
				</div>
				<?php endforeach; ?>

				<div style="margin-top:24px;display:flex;gap:10px;align-items:center;">
					<?php submit_button( '💾 Save All Settings', 'primary', 'submit', false, [
						'style' => 'padding:10px 28px;border-radius:10px;font-weight:700;font-size:14px;background:#6DB33F;border-color:#6DB33F;color:#fff;',
					] ); ?>
				</div>
			</form>

			<script>
			// Tab switching: show/hide panels (all fields always in DOM → no data loss)
			// Uses sessionStorage to persist the active tab across saves (redirect back).
			(function() {
				var tabs = document.querySelectorAll('[data-tab]');
				var panels = {};
				document.querySelectorAll('.pemu-tab-panel').forEach(function(p) {
					panels[p.id.replace('pemu-panel-', '')] = p;
				});

				// Retrieve saved tab from sessionStorage (survives redirect after save)
				var savedTab = sessionStorage.getItem('pemu_active_tab');
				if (savedTab && panels[savedTab]) {
					activateTab(savedTab);
				} else {
					// Default: first tab with visible panel
					var firstKey = Object.keys(panels)[0];
					if (firstKey) activateTab(firstKey);
				}

				function activateTab(key) {
					// Update tab styles
					tabs.forEach(function(t) {
						t.style.borderBottomColor = 'transparent';
						t.style.color = '#64748b';
					});
					var activeTab = document.querySelector('[data-tab="' + key + '"]');
					if (activeTab) {
						activeTab.style.borderBottomColor = '#6DB33F';
						activeTab.style.color = '#1e293b';
					}
					// Update panels
					Object.keys(panels).forEach(function(k) {
						panels[k].style.display = k === key ? '' : 'none';
					});
				}

				tabs.forEach(function(tab) {
					tab.addEventListener('click', function() {
						var key = this.getAttribute('data-tab');
						// Persist to sessionStorage so it survives redirect after form save
						sessionStorage.setItem('pemu_active_tab', key);
						activateTab(key);
					});
				});


			})();
			</script>
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
