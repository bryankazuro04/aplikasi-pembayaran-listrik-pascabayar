import "./bootstrap";

const tabs = document.querySelectorAll("[data-tab]");
tabs.forEach((tab) => {
    tab.addEventListener("click", (e) => {
        e.preventDefault();

        tabs.forEach((t) => {
            t.setAttribute("data-active", "false");
            t.classList.remove("bg-blue-600", "text-white");
            t.classList.add("bg-white", "text-gray-600");
        });

        tab.setAttribute("data-active", "true");
        tab.classList.add("bg-blue-600", "text-white");
        tab.classList.remove("bg-white", "text-gray-600");

        // document.querySelectorAll('[role="tabpanel"]').forEach((panel) => {
        //     panel.classList.add("hidden");
        // });

        // const panelId = tab.getAttribute("data-tab");
        // document.getElementById(panelId).classList.remove("hidden");
    });
});

document.querySelector("[data-tab]").click();
