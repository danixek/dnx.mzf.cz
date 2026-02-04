<!-- Sekce hero -->
<section id="hero" class="{{ $bgClass }} text-center text-white">
  <div class="container pt-5">
    <h1 id="typewriter" class="typing-js display-4"></h1>
    <p class="lead mt-4">Vytvářím řešení pomocí C#, ASP.NET; zajímám se i o WPF<br>- od backendu po rozhraní</p>
  </div>
  <noscript>
    <p class="text-warning fw-bold">! Pro správné fungovnání stránky si zapněte Javascript !</p>
  </noscript>

  <div id="quote-box">
    <blockquote id="quote-text" style="font-size: 22px; color: rgb(200,200,200)"></blockquote>
    <cite id="quote-author"></cite>
  </div>
  <style>
    .typing-js {
      font-family: 'Courier New', Courier, monospace;
      font-size: calc(1.475rem + 2.7vw);
      font-weight: 300;
      line-height: 1.2;
      white-space: nowrap;
    }

    .cursor {
      display: inline-block;
      width: 10px;
      background-color: #eee;
      margin-left: 3px;
      animation: blink 0.7s steps(1) infinite;
      vertical-align: bottom;
    }

    @keyframes blink {
      50% {
        background-color: transparent;
      }
    }
  </style>
  <script>
    const text = "Hello, I'm a Programmer";
    const container = document.getElementById('typewriter');
    const cursor = document.createElement('span');
    cursor.classList.add('cursor');
    container.appendChild(cursor);

    let index = 0;

    function type() {
      if (index < text.length) {
        container.textContent += text.charAt(index);
        container.appendChild(cursor);
        index++;
        setTimeout(type, 100); // rychlost psaní (ms)
      }
    }

    type();
  </script>
</section>