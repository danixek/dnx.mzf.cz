fetch('portfolio/quotes.json')
  .then(response => response.json())
  .then(quotes => {
    const quoteBox = document.getElementById('quote-box');
    const quoteText = document.getElementById('quote-text');
    const quoteAuthor = document.getElementById('quote-author');

    let phase = 'initial'; // "initial" → prvních 3
    let initialIndex = 0;
    let lastQuoteIndex = -1;

    function getInitialQuote() {
      const quote = quotes[initialIndex];
      initialIndex++;

      if (initialIndex >= 4 || initialIndex >= quotes.length) {
        phase = 'random';
      }

      return quote;
    }

    function getRandomQuote() {
      let newIndex;
      do {
        newIndex = Math.floor(Math.random() * quotes.length);
      } while (newIndex === lastQuoteIndex && quotes.length > 1);

      lastQuoteIndex = newIndex;
      return quotes[newIndex];
    }

    function showQuote() {
      quoteBox.classList.add('fade-out');

      setTimeout(() => {
        const quote = (phase === 'initial') ? getInitialQuote() : getRandomQuote();
        const formattedText = quote.text.replace(/\n/g, "<br>");
        quoteText.innerHTML = `"${formattedText}"`;
        quoteAuthor.textContent = `– ${quote.author}`;
        quoteBox.classList.remove('fade-out');
      }, 500);
    }

    showQuote(); // první citát
    setInterval(showQuote, 10000);
  })
  .catch(error => {
    console.error('Chyba při načítání citátů:', error);

    // fallback při selhání
    const quoteBox = document.getElementById('quote-box');
    const quoteText = document.getElementById('quote-text');
    const quoteAuthor = document.getElementById('quote-author');

    quoteText.innerHTML = `"Think different."`;
    quoteAuthor.textContent = "– Steve Jobs";
  });
