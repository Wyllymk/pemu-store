<?php
/**
 * Pemu — inc/seo.php
 * JSON-LD, Open Graph, Twitter Card, AI/LLM SEO signals.
 */
defined('ABSPATH') || exit;

/* ── 1. Product JSON-LD ── */
add_action('wp_head','pemu_product_jsonld');
function pemu_product_jsonld(): void {
    if (!function_exists('is_product')||!is_product()) return;
    global $product;
    if (!$product instanceof WC_Product) $product=wc_get_product(get_the_ID());
    if (!$product) return;
    $schema=['@context'=>'https://schema.org','@type'=>'Product',
        'name'=>$product->get_name(),
        'image'=>wp_get_attachment_image_url($product->get_image_id(),'full')?: get_theme_file_uri('assets/images/fallback-product.webp'),
        'description'=>wp_strip_all_tags($product->get_short_description()?:substr($product->get_description(),0,300)),
        'sku'=>$product->get_sku()?: (string)$product->get_id(),
        'brand'=>['@type'=>'Brand','name'=>'Pemu Ventures'],
        'offers'=>['@type'=>'Offer','priceCurrency'=>get_woocommerce_currency(),'price'=>$product->get_price(),
            'availability'=>$product->is_in_stock()?'https://schema.org/InStock':'https://schema.org/OutOfStock',
            'url'=>get_permalink(),'seller'=>['@type'=>'Organization','name'=>'Pemu Ventures']],
        'keywords'=>implode(', ', array_map(fn($t)=>$t->name, get_the_terms(get_the_ID(),'product_tag')?: [])),
    ];
    if ($product->get_rating_count()>0) {
        $schema['aggregateRating']=['@type'=>'AggregateRating',
            'ratingValue'=>$product->get_average_rating(),'reviewCount'=>$product->get_review_count(),
            'bestRating'=>'5','worstRating'=>'1'];
    }
    echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>'."\n";
}

/* ── 2. Organization JSON-LD ── */
add_action('wp_head','pemu_org_jsonld');
function pemu_org_jsonld(): void {
    if (function_exists('is_product')&&is_product()) return;
    $schema=['@context'=>'https://schema.org','@type'=>'Organization',
        'name'=>'Pemu Ventures','url'=>home_url('/'),
        'logo'=>get_theme_file_uri('assets/images/logo.svg'),
        'description'=>'Natural health, real results! Trusted organic products for energy, immunity, detox & hormone balance. All natural, no GMO, organic, gluten free, vegan.',
        'sameAs'=>array_values(array_filter([get_option('pemu_social_tiktok','https://tiktok.com/@pemuventures'),get_option('pemu_social_instagram','https://instagram.com/pesh_muturi')])),
        'contactPoint'=>['@type'=>'ContactPoint','telephone'=>'+254707551484','contactType'=>'customer service','areaServed'=>'KE','availableLanguage'=>['English','Swahili']],
        'address'=>['@type'=>'PostalAddress','addressLocality'=>'Nairobi','addressCountry'=>'KE'],
        'knowsAbout'=>['Natural health supplements','Organic vitamins','Body enhancement','Weight control','Herbal products','Detox supplements','Hormone balance'],
    ];
    echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>'."\n";
}

/* ── 3. WebSite + Sitelinks Searchbox ── */
add_action('wp_head','pemu_website_jsonld');
function pemu_website_jsonld(): void {
    if (!is_front_page()) return;
    $schema=['@context'=>'https://schema.org','@type'=>'WebSite',
        'name'=>'Pemu Ventures','url'=>home_url('/'),
        'description'=>'Natural health, real results! Trusted organic products for energy, immunity, detox & hormone balance.',
        'potentialAction'=>['@type'=>'SearchAction',
            'target'=>['@type'=>'EntryPoint','urlTemplate'=>home_url('/?s={search_term_string}&post_type=product')],
            'query-input'=>'required name=search_term_string'],
    ];
    echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>'."\n";
}

/* ── 4. FAQ JSON-LD (on FAQ page) ── */
add_action('wp_head','pemu_faq_jsonld');
function pemu_faq_jsonld(): void {
    if (!is_page('faq')&&!is_page_template('page-faq.php')) return;
    $faqs=[
        ['q'=>'Do you deliver countrywide?','a'=>'Yes! We deliver to all 47 counties in Kenya. Nairobi same-day, nationwide 24–48 hours.'],
        ['q'=>'Are your products genuine?','a'=>'Yes. All products are 100% authentic, lab-tested, natural, organic, non-GMO, gluten-free, and vegan.'],
        ['q'=>'How do I pay?','a'=>'M-Pesa, Bank Transfer, or Cash on Delivery. Order via WhatsApp for payment guidance.'],
        ['q'=>'How do I order via WhatsApp?','a'=>'Message +254707551484. Tell us what you need, confirm payment, and we deliver.'],
        ['q'=>'What is your return policy?','a'=>'7-day returns on unopened items. Contact WhatsApp with your order number.'],
    ];
    $items=array_map(fn($f)=>['@type'=>'Question','name'=>$f['q'],'acceptedAnswer'=>['@type'=>'Answer','text'=>$f['a']]],$faqs);
    $schema=['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>$items];
    echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>'."\n";
}

/* ── 5. Breadcrumb JSON-LD ── */
add_action('wp_head','pemu_breadcrumb_jsonld');
function pemu_breadcrumb_jsonld(): void {
    if (is_front_page()||is_home()) return;
    $items=[]; $pos=1;
    $items[]=['@type'=>'ListItem','position'=>$pos++,'name'=>'Home','item'=>home_url('/')];
    if (function_exists('is_product')&&is_product()) {
        $terms=get_the_terms(get_the_ID(),'product_cat');
        if ($terms&&!is_wp_error($terms)) { $t=reset($terms); $items[]=['@type'=>'ListItem','position'=>$pos++,'name'=>$t->name,'item'=>get_term_link($t)]; }
        $items[]=['@type'=>'ListItem','position'=>$pos,'name'=>get_the_title(),'item'=>get_permalink()];
    } elseif (function_exists('is_shop')&&is_shop()) {
        $items[]=['@type'=>'ListItem','position'=>$pos,'name'=>woocommerce_page_title(false),'item'=>wc_get_page_permalink('shop')];
    } elseif (is_page()||is_single()) {
        $items[]=['@type'=>'ListItem','position'=>$pos,'name'=>get_the_title(),'item'=>get_permalink()];
    } else { return; }
    if (count($items)<2) return;
    $schema=['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>$items];
    echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>'."\n";
}

/* ── 6. Open Graph + Twitter Card (TikTok link previews) ── */
add_action('wp_head','pemu_social_meta',1);
function pemu_social_meta(): void {
    global $product;
    if (function_exists('is_product')&&is_product()&&!$product instanceof WC_Product) $product=wc_get_product(get_the_ID());
    $is_p=$product instanceof WC_Product;
    $title=$is_p?$product->get_name().' — Pemu Ventures':(is_front_page()?'Pemu Ventures — Natural Health, Real Results':wp_title('—',false).' — Pemu Ventures');
    $desc =$is_p?wp_strip_all_tags($product->get_short_description()?:substr($product->get_description(),0,160)):'Natural health, real results! Trusted organic products for energy, immunity, detox & hormone balance. All natural, no GMO, organic, gluten free, vegan.';
    $image=$is_p?wp_get_attachment_image_url($product->get_image_id(),'pemu-og'):get_theme_file_uri('assets/images/og-default.jpg');
    $url  =$is_p?get_permalink():(is_singular()?get_permalink():home_url(add_query_arg([])));
    $title=$title?:get_bloginfo('name'); $desc=$desc?:get_bloginfo('description');
    $image=$image?:get_theme_file_uri('assets/images/og-default.jpg');
    echo '<link rel="canonical" href="'.esc_url($url).'">'."\n";
    echo '<meta name="description" content="'.esc_attr(wp_trim_words($desc,25)).'">'."\n";
    // AI/LLM signals
    echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">'."\n";
    $og=['og:type'=>$is_p?'product':'website','og:title'=>$title,'og:description'=>wp_trim_words($desc,25),'og:image'=>$image,'og:image:width'=>'1200','og:image:height'=>'630','og:url'=>$url,'og:site_name'=>'Pemu Ventures','og:locale'=>'en_KE'];
    if ($is_p) { $og['product:price:amount']=$product->get_price(); $og['product:price:currency']='KES'; $og['product:availability']=$product->is_in_stock()?'in stock':'out of stock'; }
    foreach ($og as $prop=>$content) { if ($content) echo '<meta property="'.esc_attr($prop).'" content="'.esc_attr($content).'">'."\n"; }
    $tw=['twitter:card'=>'summary_large_image','twitter:title'=>$title,'twitter:description'=>wp_trim_words($desc,25),'twitter:image'=>$image,'twitter:site'=>'@pemuventures'];
    foreach ($tw as $name=>$content) { if ($content) echo '<meta name="'.esc_attr($name).'" content="'.esc_attr($content).'">'."\n"; }
}

/* ── 7. LLM.txt / AI crawler hints via wp_head meta ── */
add_action('wp_head','pemu_llm_hints',5);
function pemu_llm_hints(): void {
    // Structured hints for AI search engines (Perplexity, ChatGPT, etc.)
    echo '<meta name="keywords" content="natural supplements Kenya, organic vitamins Nairobi, body enhancement supplements, weight control supplements, herbal supplements Kenya, pemu ventures, health supplements online Kenya, no GMO supplements, gluten free vitamins Kenya">'."\n";
    echo '<meta name="author" content="Pemu Ventures">'."\n";
    echo '<meta name="business:contact_data:phone_number" content="+254707551484">'."\n";
    echo '<meta name="business:contact_data:email" content="Pemuherbalsupplements@gmail.com">'."\n";
    echo '<meta name="business:contact_data:country_name" content="Kenya">'."\n";
    echo '<meta name="geo.region" content="KE-30">'."\n";
    echo '<meta name="geo.placename" content="Nairobi, Kenya">'."\n";
}
