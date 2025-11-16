
import {
	useBlockProps,
	InnerBlocks,
} from '@wordpress/block-editor';


export default function Edit() {
  return <div {...useBlockProps()}>
    <InnerBlocks
      allowedBlocks={['jp-content-snippets/snippet-section']}
    />

  </div>;
}
