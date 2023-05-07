// menu
const hamburger = document.querySelector(".topbar .hamburger");
const sidebar = document.querySelector(".sidebar");

function showSidebar() {
  //   sidebar.style.display = "block";
  sidebar.style.left = "0";
  document.addEventListener("mouseup", function (event) {
    if (!sidebar.contains(event.target)) {
      hideSidebar();
    }
  });
}
function hideSidebar() {
  //   sidebar.style.display = "none";
  sidebar.style.left = "-400px";
}

// menu home
const menu = document.querySelector(".topbar .right");
const xBtn = document.querySelector(".topbar .close");
function showMenu() {
  menu.style.display = "flex";
  xBtn.style.display = "block";
}
function hideMenu() {
  menu.style.display = "none";
  xBtn.style.display = "none";
}

if (screen.width >= 900) {
  menu.style.display = "flex";
  xBtn.style.display = "none";
} else {
  menu.style.display = "none";
  xBtn.style.display = "none";
}

window.addEventListener("resize", function () {
  let screenWidth = screen.width;
  // console.log(screenWidth);

  if (screenWidth >= 900) {
    menu.style.display = "flex";
    xBtn.style.display = "none";
  } else {
    menu.style.display = "none";
    xBtn.style.display = "none";
  }
});
