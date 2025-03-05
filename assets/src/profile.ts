import "./base.css";
import "./profile.css";
import { initCarousel } from "./carousel";

addEventListener("DOMContentLoaded", () => {
	const sliders = document.querySelectorAll<HTMLElement>(".lolole-slider");
	sliders.forEach((slider) => {
		initCarousel(slider);
	});
})
