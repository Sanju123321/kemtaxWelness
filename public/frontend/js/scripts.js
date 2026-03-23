/* KemtexWellness Frontend JavaScript */

// Sidebar toggle (bootstrap sb-admin style)
window.addEventListener("DOMContentLoaded", () => {
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById("sidebarToggle");
    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", (e) => {
            e.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled"),
            );
        });
    }

    // Persist sidebar state
    if (localStorage.getItem("sb|sidebar-toggle") === "true") {
        document.body.classList.add("sb-sidenav-toggled");
    }
});
