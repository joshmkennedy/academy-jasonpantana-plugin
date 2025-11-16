import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';
import './edit.css';
import './view.css';
import save from './save';

registerBlockType( metadata.name, {
	attributes: metadata.attributes,
	category: metadata.category,
	title: metadata.title,

	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
} );
