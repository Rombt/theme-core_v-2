import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import metadata from './block.json'; // Импортируем конфиг из JSON

registerBlockType(metadata.name, {
    ...metadata,
    edit: Edit,
    // save: () => null для динамических блоков обычно указывается в JSON или здесь
    save: () => null,
});