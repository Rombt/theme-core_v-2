const { registerBlockType } = wp.blocks;
const { RichText, useBlockProps } = wp.blockEditor;

registerBlockType('tc-1/button', {
    attributes: {
        content: {
            type: 'string',
            source: 'text',
            selector: 'div',
        },
    },

    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <RichText
                {...blockProps}
                tagName="div"
                className="tc-1-button tes"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Текст кнопки…"
            />
        );
    },

    save: ({ attributes }) => {
        return <div>{attributes.content}</div>;
    },
});
