document.querySelectorAll('.progress-ring').forEach(ring => {
    const percentage = ring.getAttribute('data-percentage');
    ring.style.setProperty('--percentage', percentage);
});
