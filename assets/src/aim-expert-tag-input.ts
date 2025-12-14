import { mountAimExpertTagInput } from "./aim-expert-tag-input/app";
// Aim Expert Tag Input functionality
document.addEventListener('DOMContentLoaded', async function () {
  await new Promise(r => setTimeout(r, 1000));
  const element = document.querySelector<HTMLElement>('[data-mount="expert-in-tags-mount"]');
  if (!element) return;
  const allTags = window.AIMEXPERTINTAGS;
  const userTags = JSON.parse(element.getAttribute('data-tags') ?? '[]');
  mountAimExpertTagInput(element, "expert-in-tag", allTags, userTags);
});
document.addEventListener('DOMContentLoaded', async function () {
  await new Promise(r => setTimeout(r, 1000));
  const element = document.querySelector<HTMLElement>('[data-mount="expert-with-tags-mount"]');
  if (!element) return;
  
  const allTags = window.AIMEXPERTWITHTAGS;
  console.log(allTags);
  const userTags = JSON.parse(element.getAttribute('data-tags') || '[]');
  mountAimExpertTagInput(element, "expert-with-tag", allTags, userTags);
});
//
//
//
