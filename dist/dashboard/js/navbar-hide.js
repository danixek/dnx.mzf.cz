// Skrývání navbaru
// Funguje na mobilním principu
// --> při scrollování dolů se schová,
// --> a při scrollování nahoru se objeví.
//     A navíc při načtení stránky zůstává chvilku vidět,
//     aby návštěvníka informoval, že tam vůbec nějaký je.
(() => {
  const navbar = document.querySelector('nav');
  let hideTimeout;
  let lastScrollY = window.scrollY;
  let startY = 0;

  // Nastavení plynulé animace v JS (dají se dát i v CSS)
  navbar.style.transition = 'transform 0.3s ease';

  // Funkce pro skrytí navbaru
  function hideNavbar() {
    navbar.style.transform = 'translateY(100%)';
  }

  // Funkce pro zobrazení navbaru
  function showNavbar() {
    navbar.style.transform = 'translateY(0)';
    resetHideTimeout();
  }

  // Timeout, který po chvíli navbar schová
  function resetHideTimeout() {
    clearTimeout(hideTimeout);
    hideTimeout = setTimeout(hideNavbar, 5000);
  }

  // Po načtení se navbar zobrazí a po 2,5 s schová
  showNavbar();

  // Detekce kolečka / touchpadu
  window.addEventListener('wheel', (e) => {
    if (e.deltaY > 0) {
      // Scroll dolů - schovej navbar
      hideNavbar();
    } else if (e.deltaY < 0) {
      // Scroll nahoru - ukaž navbar
      showNavbar();
    }
  });

  // Dotyková obrazovka - začátek dotyku
  window.addEventListener('touchstart', (e) => {
    startY = e.touches[0].clientY;
    showNavbar();
  });

  // Dotyková obrazovka - pohyb prstu
  window.addEventListener('touchmove', (e) => {
    const currentY = e.touches[0].clientY;
    const deltaY = startY - currentY;

    if (deltaY > 10) {
      // Posun dolů - schovej navbar
      hideNavbar();
    } else if (deltaY < -10) {
      // Posun nahoru - ukaž navbar
      showNavbar();
    }
    startY = currentY;
  });

  // Po ukončení scrollu a dotyku se navbar po chvíli skryje
  ['wheel', 'touchend', 'touchcancel'].forEach(evt =>
    window.addEventListener(evt, resetHideTimeout)
  );
})();
