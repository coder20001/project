  // Function to open and close the sidebar, hide/show menu icon
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar').style.width = "200px";
    const menuIcon = document.getElementById('menu-toggle');
    const main = document.getElementById("main").style.marginLeft = "100px";
    
    sidebar.classList.toggle('open');
    
    // Hide the menu icon when the sidebar is open, show when closed
    if (sidebar.classList.contains('open')) {
        menuIcon.classList.add('hidden'); // Hide menu icon
    } else {
        menuIcon.classList.remove('hidden'); // Show menu icon
    }
}
// Close the sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar').style.width = "0";
    const menuIcon = document.getElementById('menu-toggle');
    const main = document.getElementById("main").style.marginLeft= "0";
    
    // Check if the click is outside the sidebar
    if (!sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
        if (sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            menuIcon.classList.remove('hidden'); // Show menu icon when sidebar is closed
        }
    }
});

// Add event listener for menu icon
document.getElementById("menu-toggle").addEventListener("click", function(event) {
    event.stopPropagation(); // Prevent click from closing sidebar
    toggleSidebar();
});

    document.getElementById("search-btn").addEventListener("click", function() {
        let searchValue = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#work-orders tr");

        rows.forEach(row => {
            let workOrderTitle = row.querySelector("td:nth-child(4)").innerText.toLowerCase();
            if (workOrderTitle.includes(searchValue)) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    });

    // Function to toggle notification dropdown on click
function toggleNotifications() {
    const notificationDropdown = document.getElementById('notificationDropdown');
    
    // Toggle the display property
    if (notificationDropdown.style.display === "block") {
        notificationDropdown.style.display = "none";
    } else {
        notificationDropdown.style.display = "block";
    }
}

// Close the dropdown if the user clicks outside
window.onclick = function(event) {
    const notificationDropdown = document.getElementById('notificationDropdown');
    const bellIcon = document.getElementById('bell-icon');
    
    // Close the dropdown if clicked outside
    if (!bellIcon.contains(event.target) && notificationDropdown.style.display === "block") {
        notificationDropdown.style.display = "none";
    }
}
