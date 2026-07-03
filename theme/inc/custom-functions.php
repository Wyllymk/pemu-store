<?php
/**
 * Pemu Ventures — functions.php
 */
defined('ABSPATH') || exit;

$pemu_modules = ['inc/helpers.php','inc/setup.php','inc/enqueue.php','inc/woocommerce.php','inc/seo.php','inc/whatsapp.php','inc/customizer.php'];
foreach ($pemu_modules as $m) {
    $path = get_theme_file_path($m);
    if (file_exists($path)) require_once $path;
}

/* Auto-create FAQ page on theme activation */
add_action('after_switch_theme','pemu_create_default_pages');
function pemu_create_default_pages(): void {
    $pages = [
        'faq' => ['title'=>'FAQ','template'=>'page-faq.php'],
        'privacy-policy' => ['title'=>'Privacy Policy','template'=>''],
    ];
    foreach ($pages as $slug => $data) {
        if (!get_page_by_path($slug)) {
            $id = wp_insert_post(['post_title'=>$data['title'],'post_name'=>$slug,'post_status'=>'publish','post_type'=>'page','comment_status'=>'closed']);
            if ($id && $data['template']) update_post_meta($id,'_wp_page_template',$data['template']);
        }
    }
    // Store business info defaults
    $defaults = ['pemu_whatsapp_number'=>'254707551484','pemu_email'=>'Pemuherbalsupplements@gmail.com','pemu_address'=>'Nairobi, Kenya','pemu_social_tiktok'=>'https://tiktok.com/@pemuventures','pemu_social_instagram'=>'https://instagram.com/pesh_muturi'];
    foreach ($defaults as $k=>$v) { if (!get_option($k)) update_option($k,$v); }
}

/* x-collapse directive support for Alpine.js accordion (FAQ page) */
add_action('wp_footer','pemu_alpine_collapse_plugin',5);
function pemu_alpine_collapse_plugin(): void {
    echo '<script>
    document.addEventListener("alpine:init",function(){
        if(typeof Alpine==="undefined") return;
        Alpine.directive("collapse",function(el,{expression},{effect,evaluateLater}){
            effect(function(){
                if(el.style.display==="none"||el.style.maxHeight==="0px"){
                    el.style.overflow="hidden"; el.style.maxHeight="0"; el.style.display="block";
                    return;
                }
            });
        });
        // Simpler collapse: show/hide with transition
        document.querySelectorAll("[x-collapse]").forEach(function(el){
            if(!el.hasAttribute("style")) { el.style.overflow="hidden"; }
        });
    });
    </script>';
}