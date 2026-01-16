const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('tc-1/heading', {
    edit: ({ attributes, setAttributes }) => {
        return (
            <RichText
                tagName="h2"
                className="tc-1-heading"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Введите заголовок..."
            />
        );
    },
    save: ({ attributes }) => {
        return <RichText.Content tagName="h2" value={attributes.content} className="tc-1-heading" />;
    },
    attributes: {
        content: {
            type: 'string',
            default: 'Заголовок H2'
        }
    }
});
