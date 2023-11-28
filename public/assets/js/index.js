
// cards
// =================
(function () {
    let cards = document.querySelectorAll(".card"),
      moved = 0,
      interval;
  
    cards.forEach(function (card) {
      card.addEventListener("click", function (event) {
        clearInterval(interval);
        card.style.transform = "";
  
        // Do not flip the card if the user is trying to
        // tap a link.
        if (event.target.nodeName === "A") {
          return;
        }
  
        let cName = card.getAttribute("data-toggle-class");
        let toggled = card.classList.contains(cName);
        card.classList[toggled ? "remove" : "add"](cName);
      });
    });
  
    interval = setInterval(function () {
      moved = moved ? 0 : 10;
      cards.forEach(function (card) {
        card.style.transform = "translateY(" + moved + "px)";
      });
    }, 1500);
  })();
  