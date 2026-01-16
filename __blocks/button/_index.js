const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;
const { useBlockProps } = wp.blockEditor;

registerBlockType("tc-1/button", {
    edit() {
        const blockProps = useBlockProps();

        return createElement(
            "div",
            blockProps,
            "Button block"
        );
    },
    save() {
        return null;
    }
});
