const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('tc-1/paragraph', {
    edit: ({ attributes, setAttributes }) => {
        return (
            <RichText
                tagName="p"
                className="tc-1-paragraph"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Текст абзаца..."
            />
        );
    },
    save: ({ attributes }) => {
        return <RichText.Content tagName="p" value={attributes.content} className="tc-1-paragraph" />;
    },
    attributes: {
        content: { type: 'string', default: 'Текст абзаца' }
    }
});
