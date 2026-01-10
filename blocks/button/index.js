import './style.scss';
const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('mytheme/button', {
    edit: ({ attributes, setAttributes }) => {
        return (
            <RichText
                tagName="a"
                className="mytheme-button"
                value={attributes.content}
                onChange={(content) => setAttributes({ content })}
                placeholder="Текст кнопки"
            />
        );
    },
    save: ({ attributes }) => {
        return <RichText.Content tagName="a" value={attributes.content} className="mytheme-button" />;
    },
    attributes: {
        content: { type: 'string', default: 'Нажми меня' }
    }
});
