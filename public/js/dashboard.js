document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("toggleSidebar");
  const container = document.getElementById("mainContainer");

  toggleBtn.addEventListener("click", () => {
    container.classList.toggle("collapsed");
  });
});
