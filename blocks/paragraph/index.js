import './style.scss';
const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('mytheme/paragraph', {
    edit: ({ attributes, setAttributes }) => {
        return (
            <RichText
                tagName="p"
                className="mytheme-paragraph"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Текст абзаца..."
            />
        );
    },
    save: ({ attributes }) => {
        return <RichText.Content tagName="p" value={attributes.content} className="mytheme-paragraph" />;
    },
    attributes: {
        content: { type: 'string', default: 'Текст абзаца' }
    }
});
