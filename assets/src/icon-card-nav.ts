
import {initCarousel} from "./carousel"
import "./card/card.css"
import "./card/icon-card.css"
import "./icon-card-nav.css"

addEventListener("DOMContentLoaded", () => {
	const sliders = document.querySelectorAll<HTMLElement>(".icon-card-nav");
	sliders.forEach((slider) => {
		initCarousel(slider, {slidesToScroll: 3});
	});
})
