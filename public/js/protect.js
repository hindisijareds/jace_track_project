
document.addEventListener("DOMContentLoaded", () => {
  const loggedIn = localStorage.getItem("loggedIn");
  const role = localStorage.getItem("role");

  // if not logged in → back to login
  if (!loggedIn) {
    alert("⚠️ Please log in first!");
    window.location.href = "login.html";
  }

  // extra: role check (optional)
  if (window.location.pathname.includes("dashboard.html") && role !== "user") {
    window.location.href = "login.html";
  }
  if (window.location.pathname.includes("rider_dashboard.html") && role !== "rider") {
    window.location.href = "login.html";
  }
  if (window.location.pathname.includes("admin_dashboard.html") && role !== "admin") {
    window.location.href = "login.html";
  }
});
