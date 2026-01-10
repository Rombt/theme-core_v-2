import './style.scss';
const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('mytheme/heading', {
    edit: ({ attributes, setAttributes }) => {
        return (
            <RichText
                tagName="h2"
                className="mytheme-heading"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Введите заголовок..."
            />
        );
    },
    save: ({ attributes }) => {
        return <RichText.Content tagName="h2" value={attributes.content} className="mytheme-heading" />;
    },
    attributes: {
        content: {
            type: 'string',
            default: 'Заголовок H2'
        }
    }
});
