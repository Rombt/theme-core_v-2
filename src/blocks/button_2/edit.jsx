import { useBlockProps, RichText } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

export default function Edit( { attributes, setAttributes } ) {
    // Хук useBlockProps автоматически вешает нужные обертки и ID блока
    const blockProps = useBlockProps();

    return (
        <div { ...blockProps }>
            <RichText
                tagName="button_2"
                value={ attributes.content }
                onChange={ ( val ) => setAttributes( { content: val } ) }
                placeholder="Заголовок блока..."
            />
        </div>
    );
}