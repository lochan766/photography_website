// tiny navbar darkening on scroll
document.addEventListener("scroll", () => {
  const nav = document.querySelector(".navbar");
  if (!nav) return;
  nav.style.background = window.scrollY > 40 ? "rgba(10,10,10,.82)" : "rgba(10,10,10,.60)";
});
