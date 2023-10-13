document.addEventListener('DOMContentLoaded', function() {
    var activeCollapse = document.querySelector('.nav-item.has-submenu .collapse.show');

    if (activeCollapse) {
        activeCollapse.closest('.collapse').classList.add('show');
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const sidebarToggle = document.getElementById("sidebarToggleTop");
    const sidebarWrapper = document.querySelector(".sidebar-wrapper");
    const overlay = document.querySelector(".sidebar-overlay");
    const content = document.getElementById("content");
    const body = document.body;
    const collapseChildElements = document.querySelectorAll(".sidebar-wrapper .collapse");
    const liElements = document.querySelectorAll(".sidebar-wrapper li");
  
    sidebarToggle.addEventListener("click", function() {
      body.classList.toggle("sidebar-active");
  
      if (!body.classList.contains("sidebar-active")) {
        collapseChildElements.forEach(function(collapseElement) {
          collapseElement.classList.remove("show");
        });
      }
    });
  
    overlay.addEventListener("click", function() {
      body.classList.remove("sidebar-active");
  
      collapseChildElements.forEach(function(collapseElement) {
        collapseElement.classList.remove("show");
      });
    });
  
    liElements.forEach(function(liElement) {
      liElement.addEventListener("click", function(event) {
        if (window.innerWidth <= 990) {
          const isParentCollapse = event.target.closest(".collapse");
  
          if (!isParentCollapse) {
            collapseChildElements.forEach(function(collapseElement) {
              collapseElement.classList.remove("show");
            });
          }
        }
      });
    });
  
    // Collapse child elements by default on mobile
    if (window.innerWidth <= 990) {
      collapseChildElements.forEach(function(collapseElement) {
        collapseElement.classList.remove("show");
      });
    }
  });

  $(document).ready(function(){
    $("#menu_toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  })