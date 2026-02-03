const text = document.getElementById('logo-text');
const words = ['nx', 'ashboard'];
let i = 0;

function animateTextChange() {
  // Přerušíme animaci, pokud uživatel scrolluje více než 450px
  if (window.scrollY > 450) {
      text.classList.add('logo_text-hide');
      return;
  }

  text.classList.add('logo_text-hide');

  setTimeout(() => {
    i = (i + 1) % words.length;
    text.textContent = words[i];
    text.classList.remove('logo_text-hide');
    text.classList.add('logo_text-show');
  }, 2500);
}

setInterval(animateTextChange, 7500);
