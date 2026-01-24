const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('tc-1/heading', {
    attributes: {
        content: {
            type: 'string',
            default: 'Заголовок H2'
        }
    },



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


    save: () => {
        return null; // dynamic block
    },
});
