import "./instructors.css";
import { fetchIcon } from "../utils/fetch-icon";


export type Instructor = {
  id: number;
  name: string;
  img: string;
  focus_description: string;
  tags: string[];
  calendlyLink: string;
}

const icons: { [key: string]: string } = {};



window.addEventListener("DOMContentLoaded", async () => {
  const el = document.querySelector<HTMLElement>(".profile-instructors-list")
  if (el) {
    initInstructors(el)
  }
  icons.close = await fetchIcon("close");
});
function initInstructors(parentEl: HTMLElement) {
  parentEl.addEventListener("click", handleInstructorButtonClick)
}

function handleInstructorButtonClick(e: MouseEvent) {
  if (!(e.target instanceof HTMLButtonElement && e.target.classList.contains("profile-instructor-trigger"))) {
    return;
  }
  const instructorId = e.target.getAttribute("data-user-id");
  const data = window.aimInstructorsData.find((instructor) => instructor.id.toString() === instructorId);
  if (!data) return;
  openInstructorProfile(data);
}

let modal: HTMLElement | undefined = undefined;

function openInstructorProfile(instructor: Instructor) {
  modal = document.createElement("div");
  modal.classList.add("instructor-profile__modal-container");
  modal.innerHTML = modalTemplate(instructor);
  document.body.appendChild(modal);
  modal.querySelector<HTMLButtonElement>(".instructor-profile__close-button")?.addEventListener("click", () => {
    console.log("close button clicked");
    modal?.remove();
    modal = undefined;
  }, { once: true });
}

const modalTemplate = (instructor: Instructor) => `
<div class="instructor-profile__modal-container ">
  <div class="instructor-profile__modal-content">
        <button class="instructor-profile__close-button ">
          Close
        </button>
      <div class="instructor-profile__header">
        <div class="instructor-profile__header-img">
          <img src="${instructor.img}" alt="${instructor.name}" width="100" height="100" />
        </div>
        <div class="instructor-profile__header-title">
          <div class="profile-instructors__label"> <span>AiM</span> Expert</div>
          <h3>${instructor.name}</h3>
        </div>
      </div>
      <div class="instructor-profile__body">
          <div class="instructor-profile__body-section">
              <ul class="instructor-profile__tags">
                  ${Object.values(instructor.tags).map((tag) => `<li>${tag}</li>`).join("")}
              </ul>
          </div>
          <div class="instructor-profile__body-section">
            <p>${instructor.focus_description}</p>
          </div>
      </div>
      <div class="instructor-profile__footer">
        <div class="modal-actions">
          <a href="${instructor.calendlyLink}" class="button instructor-profile__modal-action instructor-profile__modal-action--primary" target="_blank">Book Instructor</a>
        </div>
      </div>
  </div>
</div>
`;
