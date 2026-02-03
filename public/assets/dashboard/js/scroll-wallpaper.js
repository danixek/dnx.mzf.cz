  const params = new URLSearchParams(window.location.search);
  const allowed = params.has('dash');
  const blocked = params.has('set') || params.has('rss');

  if (allowed && !blocked) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 100) {
        document.body.classList.add('scrolled');
      } else {
        document.body.classList.remove('scrolled');
      }
    });
  }