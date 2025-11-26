  // Preloader hide logic
  function hidePreloader() {
    const preloader = document.getElementById("preloader");
    if (preloader) {
      preloader.classList.add("hidden");
    }
  }

  // Hide when page finishes loading
  window.addEventListener("load", hidePreloader);

  // Fallback: force hide after 3 seconds max
  setTimeout(hidePreloader, 3000);
  function logout() {
  localStorage.removeItem("loggedIn");
  localStorage.removeItem("role");
  alert("✅ You have been logged out.");
  window.location.href = "login.html";
}