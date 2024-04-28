function includeHTML() {
    const elements = document.querySelectorAll("[data-include]");
    elements.forEach((element) => {
      const file = element.getAttribute("data-include");
      fetch(file)
        .then((response) => response.text())
        .then((html) => {
          element.innerHTML = html;
        });
    });
  }
  window.addEventListener("load", includeHTML);