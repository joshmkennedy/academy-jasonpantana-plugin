window.addEventListener("DOMContentLoaded", noticeActions)

const actions = {

  "open-aim-100-days": function openAim100DaysModal() {
    const modal = document.querySelector<HTMLDialogElement>("#aim-100-days")
    if (!modal) return;
    modal.showModal()
  },

}

function noticeActions() {

  const actionButtons = document.querySelectorAll<HTMLButtonElement>(".notice-action[data-action]");
  actionButtons.forEach((actionButton) => {
    actionButton.addEventListener("click", (e) => {
      console.log("action button clicked");
      const action = actionButton.getAttribute("data-action");
      console.log(`action: ${action}`);
      if (!action || !(action in actions)) return;
      actions[action as keyof typeof actions]?.();
    })
  })
}

