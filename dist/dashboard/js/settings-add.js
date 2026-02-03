document.getElementById('add-bookmark').addEventListener('click', () => {
    const container = document.getElementById('bookmarks-container');
    const index = container.children.length;

    const div = document.createElement('div');
    div.className = 'bookmark-item';

    // vezme options z hidden selectu
    const optionsHtml = document.getElementById('category-template').innerHTML;

    div.innerHTML = `
        <input type="text" name="bookmarks[${index}][title]" placeholder="Název záložky" required>
        <input type="url" name="bookmarks[${index}][url]" placeholder="URL" required>
        <select name="bookmarks[${index}][category]">
            ${optionsHtml}
        </select>
        <button type="button" class="remove-bookmark delete-btn">Smazat</button>
    `;
    const select = div.querySelector("select");
    select.value = "";

    container.appendChild(div);
});


document.getElementById('bookmarks-container').addEventListener('click', e => {
    if (e.target.classList.contains('remove-bookmark')) {
        e.target.parentElement.remove();
        // Tady by se dalo přidat přečíslování indexů, ale PHP to zvládne i bez toho
    }
});

document.getElementById('add-rss').addEventListener('click', () => {
    const container = document.getElementById('rss-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'rss-item';
    div.innerHTML = `
        <input type="url" name="rss[${index}]" placeholder="RSS URL" required>
        <button type="button" class="remove-rss delete-btn">Smazat</button>
    `;
    container.appendChild(div);
});

document.getElementById('rss-container').addEventListener('click', e => {
    if (e.target.classList.contains('remove-rss')) {
        e.target.parentElement.remove();
    }
});