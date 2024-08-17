import { __ } from '@wordpress/i18n';
import { useEffect, useState } from '@wordpress/element';
import { RangeControl } from '@wordpress/components';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Swiper, SwiperSlide } from 'swiper/react';
import 'swiper/css/bundle';
import 'swiper/css/pagination';
import 'swiper/css/navigation'; // Import navigation styles
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
  const [promotions, setPromotions] = useState([]);

  useEffect(() => {
    const fetchPromotions = async () => {
      try {
        const response = await fetch('/wp-json/wp/v2/promotion');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Fetched promotions:', data);
        setPromotions(Array.isArray(data) ? data : []);
        setAttributes({ promotions: Array.isArray(data) ? data : [] });
      } catch (error) {
        console.error('Error fetching promotions:', error);
        setPromotions([]);
        setAttributes({ promotions: [] });
      }
    };
    fetchPromotions();
  }, [setAttributes]);

  const setTransitionTimer = (timer) => {
    setAttributes({ transition_timer: timer });
  }

  const blockProps = useBlockProps();

  return (
    <div {...blockProps}>
      <InspectorControls>
        <RangeControl
          label={__('Transition Timer (ms)', 'text-domain')}
          value={attributes.transition_timer}
          onChange={setTransitionTimer}
          min={1000}
          max={10000}
        />
      </InspectorControls>

      <Swiper
        loop={true}
        pagination={{ clickable: true }}
        navigation={{
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }}
        autoplay={{
          delay: attributes.transition_timer, 
          disableOnInteraction: false
        }}
        slidesPerView={'auto'}
        centeredSlides={true}
        slidesPerGroup={1}
        initialSlide={2}
        spaceBetween={0}
        breakpoints={{
          640: {
            slidesPerView: 1.5,
          },
          768: {
            slidesPerView: 'auto',
          },
          1024: {
            slidesPerView: 'auto',
          },
        }}
      >
        {promotions.map((promotion) => (
          promotion && promotion.title && promotion.content ? (
            <SwiperSlide className="promotion-slide" key={promotion.id}>
              <figure className="promotion-slide-image">
                {promotion.meta._promotion_image ? (
                  <img src={promotion.meta._promotion_image} alt={promotion.title.rendered || 'No Title'} />
                ) : (
                  <img src="/path/to/default-image.jpg" alt={__('Default image', 'text-domain')} />
                )}
              </figure>
              <div className="promotion-content-block">
                <h3 className='promotion-content-block_title'>{promotion.meta._promotion_header || 'No Title'}</h3>
                <div className="promotion-content-block-info">
                  {promotion.meta._promotion_text || 'No Title'}
                </div>
                <div className="promotion-content-block-button">
                  {promotion.meta._promotion_button ? (
                    <a href={promotion.meta._promotion_button}>{__('READ MORE', 'text-domain')}</a>
                  ) : (
                    <a href="#">{__('No Link', 'text-domain')}</a>
                  )}
                </div>
              </div>
            </SwiperSlide>
          ) : (
            <SwiperSlide key={promotion.id || Math.random()} className="promotion-slide">
              <p>{__('Invalid promotion data', 'text-domain')}</p>
            </SwiperSlide>

            
          )
        ))}
      </Swiper>
       {/* Custom Navigation Elements */}
       <div className="swiper-navigation-component">
          <div className="swiper-button-next">
            <svg width="19" height="30" viewBox="0 0 19 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4L14.6364 15.0304L4.00634 25.6208" stroke="#F5F5F5" strokeWidth="7" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </div>
          <div className="swiper-button-prev">
            <svg width="19" height="30" viewBox="0 0 19 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 26L4.36357 14.9696L14.9937 4.3792" stroke="#F5F5F5" strokeWidth="7" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </div>
        </div>
    </div>
  );
}
