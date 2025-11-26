
function validatePhone(number) {
  const regex = /^09[0-9]{9}$/;  // must start with 09 and have 11 digits
  return regex.test(number);
}

function handleLogin(e) {
  e.preventDefault();
  const form = e.target;
  const phone = form.querySelector("input[placeholder='09xxxxxxxxx']").value;
  const role = form.querySelector("select").value; // get role

  if (!validatePhone(phone)) {
    alert("❌ Invalid phone number. It must start with 09 and be 11 digits long.");
    return false;
  }

  // ✅ Save session
  localStorage.setItem("loggedIn", "true");
  localStorage.setItem("role", role);

  alert("✅ Login successful!");

  // Redirect based on role
  if (role === "user") {
    window.location.href = "dashboard.html"; 
  } else if (role === "rider") {
    window.location.href = "rider_dashboard.html";
  } else if (role === "admin") {
    window.location.href = "admin_dashboard.html";
  }
  return false;
}

function handleSignup(e) {
  e.preventDefault();
  const form = e.target;
  const phone = form.querySelector("input[placeholder='09xxxxxxxxx']").value;
  const role = form.querySelector("select").value; // get role

  if (!validatePhone(phone)) {
    alert("❌ Invalid phone number. It must start with 09 and be 11 digits long.");
    return false;
  }

  // ✅ Save session
  localStorage.setItem("loggedIn", "true");
  localStorage.setItem("role", role);

  alert("✅ Signup successful!");

  // Redirect after signup based on role
  if (role === "user") {
    window.location.href = "dashboard.html"; 
  } else if (role === "rider") {
    window.location.href = "rider_dashboard.html";
  } else if (role === "admin") {
    window.location.href = "admin_dashboard.html";
  }
  return false;
}

// ✅ Logout function
function logout() {
  localStorage.removeItem("loggedIn");
  localStorage.removeItem("role");
  window.location.href = "login.html";
}

// ✅ Protect dashboards
document.addEventListener("DOMContentLoaded", () => {
  const path = window.location.pathname;

  if (path.includes("dashboard.html") || path.includes("rider_dashboard.html") || path.includes("admin_dashboard.html")) {
    const loggedIn = localStorage.getItem("loggedIn");
    const role = localStorage.getItem("role");

    if (!loggedIn) {
      alert("⚠️ Please log in first!");
      window.location.href = "login.html";
    }

    // Optional: prevent role mismatch
    if (path.includes("dashboard.html") && role !== "user") {
      window.location.href = "login.html";
    }
    if (path.includes("rider_dashboard.html") && role !== "rider") {
      window.location.href = "login.html";
    }
    if (path.includes("admin_dashboard.html") && role !== "admin") {
      window.location.href = "login.html";
    }
  }
});

// Google handler
function handleGoogleResponse(response) {
  const data = jwt_decode(response.credential);
  alert("Welcome " + data.name);
  console.log(data);

  // ✅ Save session as customer by default
  localStorage.setItem("loggedIn", "true");
  localStorage.setItem("role", "user");

  window.location.href = "dashboard.html";
}

// Attach Google button clicks
document.getElementById("googleBtn").addEventListener("click", function() {
  google.accounts.id.prompt();
});
document.getElementById("googleBtn2").addEventListener("click", function() {
  google.accounts.id.prompt();
});

// Facebook handler
window.fbAsyncInit = function() {
  FB.init({
    appId      : 'YOUR_FACEBOOK_APP_ID',
    cookie     : true,
    xfbml      : true,
    version    : 'v16.0'
  });
};

function loginWithFacebook() {
  FB.login(function(response) {
    if (response.authResponse) {
      FB.api('/me?fields=id,name,email', function(user) {
        alert("Welcome " + user.name);
        console.log(user);

        // ✅ Save session as customer by default
        localStorage.setItem("loggedIn", "true");
        localStorage.setItem("role", "user");

        window.location.href = "dashboard.html";
      });
    }
  }, {scope: 'public_profile,email'});
}

