// menu
const hamburger = document.querySelector(".topbar .hamburger");
const sidebar = document.querySelector(".sidebar");

function showSidebar() {
  //   sidebar.style.display = "block";
  sidebar.style.left = "0";
}
function hideSidebar() {
  //   sidebar.style.display = "none";
  sidebar.style.left = "-400px";
}

document.addEventListener("mouseup", function (event) {
  if (!sidebar.contains(event.target)) {
    hideSidebar();
  }
});

// modal gabung kelas
const modal = document.querySelector(".wrapper-modal");
const filterBackground = document.querySelector(".filter-background");

function showModal() {
  modal.classList.add("active");
  filterBackground.style.display = "block";
}

function hideModal() {
  modal.classList.remove("active");
  filterBackground.style.display = "none";
}

// modal user create
const modal1 = document.querySelector(".wrapper-modal1");

function showSecondModal() {
  modal1.classList.add("active");
  filterBackground.style.display = "block";
}

function hideSecondModal() {
  modal1.classList.remove("active");
  filterBackground.style.display = "none";
}

document.addEventListener("mouseup", function (event) {
  if (!modal.contains(event.target) && !modal1.contains(event.target)) {
    hideModal();
    hideSecondModal();
  }
});

// scroll daftar tugas
const forums = document.querySelectorAll(".wrapper-forum .forums .forum");

// function scrollHere(e) {
//   forums.forEach((forum) => {
//     if (forum.classList.contains(e)) {
//       forum.scrollIntoView();
//       console.log(forum.scrollIntoView);
//     }
//   });
// }

function scrollHere(e) {
  forums.forEach((forum) => {
    if (forum.classList.contains(e)) {
      var headerOffset = 110;
      var elementPosition = forum.getBoundingClientRect().top;
      var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

      window.scrollTo({
        top: offsetPosition,
        behavior: "smooth",
      });
    }
  });
}

// Add event listener to the form
document.getElementById("modalForm").addEventListener("keyup", function (event) {
  event.preventDefault();
  if (event.keyCode === 13) {
    document.getElementById("submitBtn").click();
  }
});

// Add event listener to the form
// document.getElementById("search").addEventListener("keyup", function (event) {
//   event.preventDefault();
//   if (event.keyCode === 13) {
//     document.getElementById("submitBtn").click();
//   }
// });
