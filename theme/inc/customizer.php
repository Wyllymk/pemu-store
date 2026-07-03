<?php
/**
 * Pemu — inc/customizer.php (updated with Pemu Ventures business info)
 */
defined('ABSPATH') || exit;

add_action('customize_register','pemu_customizer_settings');
function pemu_customizer_settings(WP_Customize_Manager $wp): void {
    $wp->add_panel('pemu_panel',['title'=>'🌿 Pemu Theme Settings','priority'=>30]);

    $sec = fn(string $id, string $title, int $p=10) =>
        $wp->add_section($id,['title'=>$title,'panel'=>'pemu_panel','priority'=>$p]);

    $txt = fn(string $k, string $label, string $sec, string $def='', string $type='text') => [
        $wp->add_setting($k,['default'=>$def,'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']),
        $wp->add_control($k,['label'=>$label,'section'=>$sec,'type'=>$type]),
    ];

    // Contact
    $sec('pemu_contact','📞 Contact & Social',10);
    $txt('pemu_whatsapp_number','WhatsApp Number (no +, e.g. 254707551484)','pemu_contact','254707551484');
    $txt('pemu_email','Email Address','pemu_contact','Pemuherbalsupplements@gmail.com','email');
    $txt('pemu_address','Physical Address','pemu_contact','Nairobi, Kenya');
    $txt('pemu_social_tiktok','TikTok URL','pemu_contact','https://tiktok.com/@pemuventures');
    $txt('pemu_social_instagram','Instagram URL','pemu_contact','https://instagram.com/pesh_muturi');
    $txt('pemu_social_facebook','Facebook URL','pemu_contact','');
    $wp->add_setting('pemu_free_delivery_threshold',['default'=>'0','sanitize_callback'=>'absint']);
    $wp->add_control('pemu_free_delivery_threshold',['label'=>'Free Delivery Threshold KES (0 = none)','section'=>'pemu_contact','type'=>'number']);

    // Announcement
    $sec('pemu_announcement','📢 Announcement Bar',20);
    $wp->add_setting('pemu_announcement_enabled',['default'=>true,'sanitize_callback'=>'wp_validate_boolean']);
    $wp->add_control('pemu_announcement_enabled',['label'=>'Show bar','section'=>'pemu_announcement','type'=>'checkbox']);
    $txt('pemu_announcement_text','Text','pemu_announcement','🌿 Natural health, real results! Trusted organic products — countrywide delivery.');

    // Hero
    $sec('pemu_hero','🦸 Homepage Hero',30);
    $txt('pemu_hero_headline','Headline','pemu_hero','Natural Health. Real Results.');
    $txt('pemu_hero_subheadline','Sub-headline','pemu_hero','Trusted organic products for energy, immunity, detox & hormone balance. All natural, no GMO, gluten free, vegan. Countrywide delivery.');
    $txt('pemu_hero_cta_primary','Primary CTA','pemu_hero','Shop Now');
    $txt('pemu_hero_cta_wa','WhatsApp CTA','pemu_hero','Order via WhatsApp');
    $txt('pemu_hero_badge','Badge Text','pemu_hero','🌿 All Natural · No GMO · Organic');
    $txt('pemu_hero_social_proof','Social Proof','pemu_hero','Trusted by thousands of Kenyans');
    $wp->add_setting('pemu_hero_image',['default'=>'','sanitize_callback'=>'esc_url_raw']);
    $wp->add_control(new WP_Customize_Image_Control($wp,'pemu_hero_image',['label'=>'Hero Background Image','section'=>'pemu_hero']));

    // Homepage
    $sec('pemu_homepage','🏠 Homepage Sections',40);
    foreach (['pemu_show_trust_bar'=>'Trust Bar','pemu_show_categories'=>'Category Grid','pemu_show_bestsellers'=>'Best Sellers','pemu_show_new_arrivals'=>'New Arrivals','pemu_show_testimonials'=>'Testimonials'] as $k=>$label) {
        $wp->add_setting($k,['default'=>true,'sanitize_callback'=>'wp_validate_boolean']);
        $wp->add_control($k,['label'=>$label,'section'=>'pemu_homepage','type'=>'checkbox']);
    }

    // Footer
    $sec('pemu_footer','🦶 Footer',50);
    $txt('pemu_footer_tagline','Tagline','pemu_footer','Natural health, real results! Trusted organic products for energy, immunity, detox & hormone balance.');
    $txt('pemu_footer_copyright','Copyright','pemu_footer','© '.date('Y').' Pemu Ventures. All rights reserved.');
}
