import "./base.css";

import "./card/card.css";
import "./card/icon-card.css";
import "./card/session-card.css";
import "./card/essentials-card.css";
import "./card/resource-card.css";

import "./profile.css";

import { initCarousel } from "./carousel";

addEventListener("DOMContentLoaded", () => {
	const sliders = document.querySelectorAll<HTMLElement>(".lolole-slider");
	sliders.forEach((slider) => {
		initCarousel(slider);
	});
})
