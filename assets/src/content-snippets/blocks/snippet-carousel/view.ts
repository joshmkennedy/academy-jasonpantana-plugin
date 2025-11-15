import metadata from './block.json';
import {initCarousel as createSnippetCarousel} from "../../../snippet-carousel"
import './view.css';

addEventListener("DOMContentLoaded", () => {
	const sliders = document.querySelectorAll<HTMLElement>(`${createClassnameFromBlockName(metadata.name)}:has(.snippet__embla-viewport)`);
	sliders.forEach((slider) => {
		createSnippetCarousel(slider);
	});
})

function createClassnameFromBlockName(blockName:string){
  return `.wp-block-${blockName.replace(/\//g, '-')}`;
}
