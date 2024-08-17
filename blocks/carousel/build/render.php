<?php
/**
 * Server-side render function for the block.
 */

// echo '<pre>';
// print_r($attributes);
// print_r($content);
// echo '</pre>';

$promotions = isset($attributes['promotions']) ? $attributes['promotions'] : [];
$transition_timer = isset($attributes['transition_timer']) ? $attributes['transition_timer'] : 3000;
?>
<div <?php echo get_block_wrapper_attributes(array(
    'data-transition-timer' => $transition_timer // Add this attribute
)); ?>>
    <?php if (!empty($promotions)) : ?>
        <div class="swiper-container wp-block-literati-example-carousel-block">
            <div class="swiper-wrapper">
                <?php foreach ($promotions as $promotion) : 
                    $header = get_post_meta($promotion['id'], '_promotion_header', true);
                    $text = get_post_meta($promotion['id'], '_promotion_text', true);
                    $button = get_post_meta($promotion['id'], '_promotion_button', true);
                    $image = get_post_meta($promotion['id'], '_promotion_image', true);
                    ?>
                    <?php if (isset($promotion['title']['rendered'], $promotion['content']['rendered'])) : ?>

                        <div class="swiper-slide promotion-slide">
                            <figure class="promotion-slide-image">
                            <?php if ($image) : ?>
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($header); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/path/to/default-image.jpg'); ?>" alt="<?php esc_attr_e('Default image', 'text-domain'); ?>">
                            <?php endif; ?>
                            </figure>
                           <div class="promotion-content-block">
                            <h3 class="promotion-content-block_title">
                                <?php echo esc_html($header); ?>
                            </h3>
                            <div class="promotion-content-block-info">
                                <?php echo wp_kses_post($text); ?>
                            </div>
                            <div class="promotion-content-block-button">
                            <?php if ($button) : ?>
                                <a href="<?php echo esc_url($button); ?>"><?php _e('READ MORE', 'text-domain'); ?></a>
                            <?php else : ?>
                                <a href="#"><?php _e('No Link', 'text-domain'); ?></a>
                            <?php endif; ?>
                            </div>
                           </div>
                        </div>

                    <?php else : ?>
                        <div class="swiper-slide promotion-slide">
                            <p><?php _e('Invalid promotion data', 'text-domain'); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <div class="swiper-navigation-component">
                <!-- Add Navigation -->
            <div class="swiper-button-next">
                <svg width="19" height="30" viewBox="0 0 19 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4L14.6364 15.0304L4.00634 25.6208" stroke="#F5F5F5" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="swiper-button-prev">
                <svg width="19" height="30" viewBox="0 0 19 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 26L4.36357 14.9696L14.9937 4.3792" stroke="#F5F5F5" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            </div>
        </div>
    <?php else : ?>
        <p><?php _e('No promotions available.', 'text-domain'); ?></p>
    <?php endif; ?>
</div>
