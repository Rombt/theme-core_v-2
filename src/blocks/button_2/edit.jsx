import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps({
        className: 'tc-1-button'
    });

    return (
        <div {...blockProps}>
            <RichText
                tagName="div"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Текст кнопки…"
            />
        </div>
    );
}