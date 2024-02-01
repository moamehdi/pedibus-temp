gsap.registerPlugin(ScrollTrigger);
const howItWorks = document.querySelector(".how-container");
const natureWrapper = document.querySelector(".nature-wrapper");
const firstFlower = document.getElementById("first-flower");
const firstTree = document.getElementById("first-tree");
const flowersBottom = document.getElementById("flowers-bottom");

gsap.from('.how-container div', {
    scrollTrigger: {
        trigger: howItWorks,
        start: "top center",
        end: "bottom center",
        toggleActions: "play none play reverse",
        markers: true,
    }, 
    opacity: 0,
    x: -100,
    duration: 0.3,
    stagger: 0.3,
});



gsap.from(firstFlower, {
    scrollTrigger: {
        trigger: natureWrapper,
        start: "top 20%",
        end: "bottom center",
        toggleActions: "play reverse play reverse",
        // markers: true,
    },
    x: -200,
    y: 100,
    duration: 1,
    stagger: 0.3,
    delay: 0.5
});

gsap.from(firstTree, {
    scrollTrigger: {
        trigger: natureWrapper,
        start: "top 20%",
        end: "bottom center",
        toggleActions: "play reverse play reverse",
        // markers: true,
    },
    x: 200,
    y: 100,
    duration: 1,
    stagger: 0.3,
    delay: 0.8
});

gsap.from('.flowers-bottom img', {
    scrollTrigger: {
        trigger: natureWrapper,
        start: "top 20%",
        end: "bottom center",
        toggleActions: "play reverse play reverse",
        // markers: true,
    },
    y: 400,
    duration: 1,
    stagger: 0.3,
    delay: 0.8

})

// gsap.from('.nature-wrapper img', {
//     scrollTrigger: {
//         trigger: natureWrapper,
//         start: 'top center',
//         toggleActions: "play none none reverse",
//     },
//     x: -200, 
//     y: 100,
//     duration: 1,
//     stagger: 0.3,
//     delay: 0.8
// })

// howItWorks.addEventListener('mouseenter', () => {
//     flowers.forEach(flower => {
//         flower.style.transform = 'scale(1.1)';
//     });
// })