
import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody } from "@wordpress/components";
import { SelectLessonForm } from './select-lesson-form';
import type { Post } from '@wordpress/core-data';



export default function Edit({ clientId }: { clientId: string }) {
  return <div {...useBlockProps()}>

    <InspectorControls>
      <PanelBody
        title="Use Content From Lesson"
        initialOpen={true}
      >
        <SelectLessonForm
          onSubmit={(post) => postDataForContent(clientId, post)}
        />
      </PanelBody>
    </InspectorControls>
    <InnerBlocks

    />

  </div>;
}

async function postDataForContent(clientId: string, post: Post) {
  const heading = post.title.rendered.trim();
  const description = (post.excerpt?.raw || post.content?.raw.substring(0, 10))?.trim();

  const headingBlock = findHeadingBlock(clientId);
  if (headingBlock && heading) {
    updateBlockContent(headingBlock.clientId, heading);
  }

  const descriptionBlock = findParagraphBlock(clientId);
  if (descriptionBlock && description) {
    updateBlockContent(descriptionBlock.clientId, description);
  }

  const buttonBlock = findButtonBlock(clientId);
  if (buttonBlock) {
    updateButtonLink(buttonBlock.clientId, post.link);
  }

  const imageBlock = findImageBlock(clientId);
  if (imageBlock) {
		const url = await getLessonImage(post.id);
		if (!url) return;
    await updateImageURL(imageBlock.clientId, url);
  } else {
    const rootGroup = findGroupWithBGImage(clientId);
    if (rootGroup) {
      const url = await getLessonImage(post.id);
			console.log(url);
      if (!url) return;
			console.log("url", url);
      updateBGImageURl(rootGroup.clientId, url, rootGroup);
    }
  }
}

function findHeadingBlock(clientId: string) {
  return findBlock(clientId, 'core/heading');
}

function findParagraphBlock(clientId: string) {
  return findBlock(clientId, 'core/paragraph');
}

function findButtonBlock(clientId: string) {
  return findBlock(clientId, 'core/button');
}

function findImageBlock(clientId: string) {
  return findBlock(clientId, 'core/image');
}

async function updateImageURL(clientId: string, url: string) {
  wp.data.dispatch('core/block-editor').updateBlock(clientId, { attributes: { url } });
}

function updateButtonLink(clientId: string, url: string) {
  wp.data.dispatch('core/block-editor').updateBlock(clientId, { attributes: { url } });
}

function findBlock(parentId: string, blockName: string): { clientId: string; attributes: { content: string } } | undefined {
  const block = wp.data.select('core/block-editor').getBlock(parentId);
  if (block.name === blockName) {
    return block;
  }
  if (block.innerBlocks) {
    for (const innerBlock of block.innerBlocks) {
      const found = findBlock(innerBlock.clientId, blockName);
      if (found) {
        return found;
      }
    }
  }
  return undefined;
}

function updateBlockContent(clientId: string, content: string) {
  wp.data.dispatch('core/block-editor').updateBlock(clientId, { attributes: { content } });
}

async function getLessonImage(postId: number) {
  const url = await wp.apiFetch({ path: "/jp/v1/lesson-video-url?id=" + postId })
    .then(data => data.url)
    .catch(err => {
      console.error(err);
      return '';
    });
  return url;
}

function findGroupWithBGImage(clientId: string) {
  const block = wp.data.select('core/block-editor').getBlock(clientId)?.innerBlocks?.[0];
  console.log(block)
  if (block.name !== "core/group") return undefined;
	console.log(block.attributes.style.background.backgroundImage)
  if (!block.attributes.style.background.backgroundImage) return undefined;
	console.log("found image")
  return block;
}

function updateBGImageURl(clientId: string, url: string, block) {
  console.log("Updating image url", url);
  wp.data.dispatch('core/block-editor').updateBlock(clientId, {
		attributes: {
			...block.attributes,
			style: {
				...block.attributes.style,
				background: {
					...block.attributes.style.background,
					backgroundImage: {
						...block.attributes.style.background.backgroundImage,
						url,
					},
				},
			},
		},
	});
}
