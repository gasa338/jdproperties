document.addEventListener("DOMContentLoaded", () => {

    const links = document.querySelectorAll(".toc-link");

    const headings = [];

    links.forEach(link => {

        const id = link.getAttribute("href").replace("#", "");
        const el = document.getElementById(id);

        if (el) {
            headings.push(el);
        }

    });

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                links.forEach(link => {
                    link.classList.remove("text-accent", "font-medium");
                    link.classList.add("text-primary");
                });

                const id = entry.target.id;

                const active = document.querySelector('.toc-link[href="#' + id + '"]');

                if (active) {
                    active.classList.remove("text-primary");
                    active.classList.add("text-accent", "font-medium");
                }

            }

        });

    }, {
        rootMargin: "-30% 0px -60% 0px"
    });

    headings.forEach(h => {
        observer.observe(h);
    });

});