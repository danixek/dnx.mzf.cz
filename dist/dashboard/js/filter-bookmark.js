const filterButtons = document.querySelectorAll(".filter-btn");
const bookmarks = document.querySelectorAll(".bookmark");
const searchInput = document.querySelector(".search-input");

// autocomplete box navázaný na input
const autocompleteList = document.createElement("div");
autocompleteList.classList.add("autocomplete-list");
searchInput.parentNode.appendChild(autocompleteList);

let activeFilter = "all"; // výchozí

// Filtrace podle kategorie
function applyCategoryFilter() {
    bookmarks.forEach(bookmark => {
        const category = bookmark.getAttribute("data-category");
        if (activeFilter === "all" || category === activeFilter) {
            bookmark.classList.remove("hide");
        } else {
            bookmark.classList.add("hide");
        }
    });
}

// Fulltext hledání + autocomplete
function applyFulltextFilter(query) {
    query = query.trim().toLowerCase();
    let matches = [];

    bookmarks.forEach(bookmark => {
        const text = bookmark.textContent.toLowerCase();
        const tags = (bookmark.getAttribute("data-tags") || "").toLowerCase();
        const category = bookmark.getAttribute("data-category");

        const match = (text.includes(query) || tags.includes(query)) &&
                      (activeFilter === "all" || category === activeFilter);

        if (match) {
            bookmark.classList.remove("hide");
            matches.push(bookmark);
        } else {
            bookmark.classList.add("hide");
        }
    });

    autocompleteList.innerHTML = "";
    if (query && matches.length > 0) {
        matches.forEach(bookmark => {
            const item = document.createElement("div");
            item.classList.add("autocomplete-item");
            item.textContent = bookmark.textContent;
            item.addEventListener("click", () => {
                window.location.href = bookmark.getAttribute("href") || "#";
            });
            autocompleteList.appendChild(item);
        });
        autocompleteList.style.display = "block";
    } else {
        autocompleteList.style.display = "none";
    }
}

// Kliknutí na tlačítka filtrů
filterButtons.forEach(button => {
    button.addEventListener("click", () => {
        const clickedFilter = button.getAttribute("data-filter");
        activeFilter = clickedFilter;

        // zvýrazni aktivní tlačítko
        filterButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        // přefiltruj podle nového filtru + input
        applyFulltextFilter(searchInput.value);
    });
});

// Psaní do inputu
searchInput.addEventListener("input", () => {
    applyFulltextFilter(searchInput.value);
});

// Klik mimo autocomplete skryje
document.addEventListener("click", e => {
    if (!searchInput.contains(e.target) && !autocompleteList.contains(e.target)) {
        autocompleteList.style.display = "none";
    }
});
