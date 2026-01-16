const { registerBlockType } = wp.blocks;
const { RichText, useBlockProps } = wp.blockEditor;

registerBlockType('tc-1/button', {
    attributes: {
        content: {
            type: 'string',
            default: 'Button block',
        },
    },

    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <RichText
                {...blockProps}
                tagName="div"
                className="tc-1-button"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Текст кнопки…"
            />
        );
    },

    save: () => {
        return null; // dynamic block
    },
});
