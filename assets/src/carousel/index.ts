import EmblaCarousel from "embla-carousel";

import "./carousel.css";
import { addPrevNextBtnsClickHandlers } from "./buttons";
import { addDotBtnsAndClickHandlers } from "./dots";

const OPTIONS = { loop: false };
export function initCarousel(emblaNode: HTMLElement) {
	const viewportNode = emblaNode.querySelector<HTMLElement>(".embla__viewport");
	const prevBtnNode = emblaNode.querySelector<HTMLElement>(
		".embla__button--prev",
	);
	const nextBtnNode = emblaNode.querySelector<HTMLElement>(
		".embla__button--next",
	);
	const dotsNode = emblaNode.querySelector<HTMLElement>(".embla__dots");

	if (!viewportNode) {
		console.log("no viewport node");
		return;
	}

	const emblaApi = EmblaCarousel(viewportNode, OPTIONS);
	if (prevBtnNode && nextBtnNode) {
		const removePrevNextBtnsClickHandlers = addPrevNextBtnsClickHandlers(
			emblaApi,
			prevBtnNode,
			nextBtnNode,
		);
		emblaApi.on("destroy", removePrevNextBtnsClickHandlers);
	}
	if (dotsNode) {
		const removeDotBtnsAndClickHandlers = addDotBtnsAndClickHandlers(
			emblaApi,
			dotsNode,
		);

		emblaApi.on("destroy", removeDotBtnsAndClickHandlers);
	}
}
