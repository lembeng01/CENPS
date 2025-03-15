// login.js

async function login(e) {
  e.preventDefault();
  
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  
  console.log("Attempting login with:", { username, password });
  
  // Create a FormData object for the POST request
  const formData = new FormData();
  formData.append('username', username);
  formData.append('password', password);
  
  try {
    const response = await fetch('http://api.crystalenaps.com/login.php', {
      method: 'POST',
      body: formData
    });
    
    console.log("Response received:", response);
    
    if (!response.ok) {
      console.error("Network response was not ok", response.statusText);
      alert("Network error: " + response.statusText);
      return;
    }
    
    const result = await response.json();
    console.log("Result from login.php:", result);
    
    if (result.success) {
      window.location.href = "admin.html";
    } else {
      alert("Login failed: " + result.message);
    }
  } catch (error) {
    console.error("Error during fetch:", error);
    alert("An error occurred while trying to log in.");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener("submit", login);
    console.log("Login form event listener attached");
  } else {
    console.error("Login form not found in the DOM");
  }
});
