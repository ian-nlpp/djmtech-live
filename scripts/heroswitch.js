const heroData = [
    {
        subtitle: "Hot Products",
        title: "Find devices that’s right for you",
        description: "Shop the latest and top-tier tech —all in one place. Upgrade your experience today!",
        buttonLink: "#",
    },
    {
        subtitle: "New Arrivals",
        title: "Upgrade Your Tech Game",
        description: "Discover the newest gadgets and innovations handpicked for you!",
        buttonLink: "#",
    },
    {
        subtitle: "Limited Time Offers",
        title: "Best Deals on Your Favorite Tech",
        description: "Grab exclusive discounts before they’re gone! Shop now.",
        buttonLink: "#",
    }
];

let currentIndex = 0;

function changeHero(index) {
    const heroContent = document.querySelector(".hero-content");

    // Fade out before changing content
    heroContent.style.opacity = "0";

    setTimeout(() => {
        // Update text content only (not images)
        document.querySelector(".hero-subtitle").textContent = heroData[index].subtitle;
        document.querySelector(".hero-title").textContent = heroData[index].title;
        document.querySelector(".hero-description").textContent = heroData[index].description;
        document.querySelector(".hero-button").setAttribute("onclick", `window.location.href='${heroData[index].buttonLink}'`);

        // Update pagination dots
        document.querySelectorAll(".hero-pagination span").forEach((dot, i) => {
            dot.classList.toggle("active", i === index);
        });

        // Fade in updated content
        heroContent.style.opacity = "1";
    }, 300);

    currentIndex = index;
}

// Auto-change text every 7 seconds
function autoChangeHero() {
    currentIndex = (currentIndex + 1) % heroData.length;
    changeHero(currentIndex);
}

setInterval(autoChangeHero, 7000);
