document.addEventListener("DOMContentLoaded", () => {
    const togglePasswordButtons = document.querySelectorAll(".toggle-password");
  
    togglePasswordButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        const input = button.previousElementSibling;
  
        if (input.type === "password") {
          input.type = "text";
          button.textContent = "🙈";
        } else {
          input.type = "password";
          button.textContent = "👁️";
        }
      });
    });
  });
  