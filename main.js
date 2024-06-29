const scrollRevealOption = {
    distance : "50px",
    origin : "bottom",
    duration : 1000,
}

ScrollReveal().reveal(".headercontainer h1", {
    ...scrollRevealOption,
});
ScrollReveal().reveal(".headercontainer p", {
    ...scrollRevealOption,
    delay: 500,
});
ScrollReveal().reveal(".headercontainer form", {
    ...scrollRevealOption,
    delay: 1000,
});
ScrollReveal().reveal(".headercontainer a", {
    ...scrollRevealOption,
    delay: 1500,
});

document.addEventListener('DOMContentLoaded', function () {
    const userIcon = document.getElementById('user-icon');
    const overlay = document.getElementById('overlay');
    const closeBtn = document.getElementById('close-btn');
    const loginBtn = document.querySelector('.login-btn');
    const registerBtn = document.querySelector('.register-btn');
    const escBtn = document.querySelector('.esc-btn');

    userIcon.addEventListener('click', function () {
        overlay.style.display = 'flex';
    });

    closeBtn.addEventListener('click', function () {
        overlay.style.display = 'none';
    });

    loginBtn.addEventListener('click', function () {
        window.location.href = '/login.php';
    });

    escBtn.addEventListener('click', function () {
        window.location.href = '/index.php';
    });
});