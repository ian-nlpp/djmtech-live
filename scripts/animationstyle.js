document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll("section");

    function revealSections() {
        sections.forEach((section) => {
            const sectionTop = section.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (sectionTop < windowHeight * 0.85) {
                section.classList.add("show");
            }
        });
    }

    // Run on scroll and on page load
    window.addEventListener("scroll", revealSections);
    revealSections(); // Ensure elements are checked when the page loads
});