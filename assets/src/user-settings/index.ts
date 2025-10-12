import "./styles.css";


window.addEventListener("DOMContentLoaded", function (){
  const allDuhDamnButtons = document.querySelectorAll<HTMLButtonElement>("[data-action='unsubscribe']");
  allDuhDamnButtons.forEach(button => {
    button.addEventListener("click", async function (e) {
      e.preventDefault();
      const listId = button.dataset.listId;
      if(!listId){

        return;
      }
      await unsubscribe(listId);
    });
  });

});


async function unsubscribe(listId:string) {
  const res = await fetch(`/wp-json/vts/v1/learning-path/opt-out-user?cliplist_id=${listId}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      // @ts-ignore you mom is not defined
      "X-WP-Nonce": window.vtsPublic.nonce,
    },
  })
    
  const data = await res.json()
  if(data.status === "success"){
    console.log("success")
    window.location.href="/profile";
  } else {
    console.error("😭😭😭😭😭😭.");
  }
}

