import EmblaCarousel from "embla-carousel";
import AutoPlay from "embla-carousel-autoplay";

import "../carousel/carousel.css";
import "./carousel.css";
import { addPrevNextBtnsClickHandlers } from "./buttons";
import { addDotBtnsAndClickHandlers } from "./dots";

const OPTIONS = { loop: false };
export function initCarousel(emblaNode: HTMLElement, options = {}) {
	options = { ...OPTIONS, ...options };
	const viewportNode = emblaNode.querySelector<HTMLElement>(".snippet__embla-viewport");
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

	const emblaApi = EmblaCarousel(viewportNode, {
    loop:true,
    align:"center",
    duration:50,
    axis:"x",
    slidesToScroll:1,
    containScroll:"trimSnaps",
  },[
    AutoPlay({
      active:true,
      delay:10000,
      playOnInit:true,
      stopOnMouseEnter:true,
      stopOnLastSnap:false,
    })
  ]);
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
  emblaApi.on('autoplay:stop', ()=>{
    setTimeout(()=>emblaApi.plugins().autoplay.play(),3000)
  });
}
