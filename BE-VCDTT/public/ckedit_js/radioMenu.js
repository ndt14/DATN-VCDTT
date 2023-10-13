const tabButtons = document.querySelectorAll('[name="tab"]');
const tabContents = document.querySelectorAll(".tab-pane");

tabButtons.forEach((button) => {
  button.addEventListener("change", () => {
    const targetId = button.getAttribute("data-bs-target").replace("#", "");
    tabContents.forEach((content) => {
      content.classList.remove("show", "active");
    });
    document.getElementById(targetId).classList.add("show", "active");

    // Deselect other radio buttons
    tabButtons.forEach((otherButton) => {
      if (otherButton !== button) {
        otherButton.checked = false;
      }
    });
  });
});
