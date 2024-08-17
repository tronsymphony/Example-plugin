import { useBlockProps } from '@wordpress/block-editor';
const { __ } = wp.i18n;
export default function save({ attributes }) {
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
         
                {Array.isArray(attributes.promotions) && attributes.promotions.length > 0 ? (
                    attributes.promotions.map((promotion, index) => (
                        promotion && promotion.title && promotion.content ? (
                            <div key={promotion.id || index} className="promotion-slide">
                                <h3>
                                    {promotion.title.rendered || 'No Title'}
                                </h3>
                                <div dangerouslySetInnerHTML={{ __html: promotion.content.rendered || '<p>No Content</p>' }} />
                            </div>
                        ) : (
                            <div key={promotion.id || index} className="promotion-slide">
                                <p>{__('Invalid promotion data', 'text-domain')}</p>
                            </div>
                        )
                    ))
                ) : (
                    <p>{__('No promotions available.', 'text-domain')}</p>
                )}
        </div>
    );
}
