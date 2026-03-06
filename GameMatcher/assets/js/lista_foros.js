document.addEventListener('DOMContentLoaded', () => {
    initForos();
});

function initForos() {
    document.addEventListener('click', (e) => {
        const header = e.target.closest('.foro-header');
        if (header) {
            handleForoToggle(header);
        }
    });
}

function handleForoToggle(header) {
    const item = header.closest('.foro-item');
    const content = item.querySelector('.foro-content');
    const icon = header.querySelector('i.fa-chevron-down');

    if (content && icon) {
        const isHidden = window.getComputedStyle(content).display === "none";

        if (isHidden) {
            content.style.display = "block";
            icon.style.transform = "rotate(180deg)";
            header.classList.add('active-header'); 
        } else {
            content.style.display = "none";
            icon.style.transform = "rotate(0deg)";
            header.classList.remove('active-header');
        }
    }
}