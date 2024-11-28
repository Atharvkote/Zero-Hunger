// Initialize odometers dynamically
document.querySelectorAll(".odometer").forEach((el) => {
  const value = parseInt(el.getAttribute("data-value"), 10) || 0;

  const odometer = new Odometer({
    el: el,
    value: 0, // Start from zero
    format: '(,ddd)', // Format with commas
  });

  // Observer for scrolling into view
  let hasRun = false;
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !hasRun) {
          odometer.update(value);
          hasRun = true;
        }
      });
    },
    { threshold: 0.7 }
  );

  observer.observe(el);
});
