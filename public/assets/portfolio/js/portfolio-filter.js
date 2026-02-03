
document.addEventListener("DOMContentLoaded", () => {

    // Trojstavové přepínání (null → true → false → null)
    document.querySelectorAll('.filter-tristate-wrapper').forEach(el => {
        el.addEventListener('click', (event) => {
            event.preventDefault(); // zabrání výchozímu chování
            event.stopPropagation();

            const current = el.getAttribute('data-filter-state');
            let next;
            if (current === 'null') next = 'true';
            else if (current === 'true') next = 'false';
            else next = 'null';
            // logika přepínání stavu

            el.setAttribute('data-filter-state', next);
            el.setAttribute('aria-checked', getAriaChecked(next));


            // applyFilter(); // Volitelné: filtr se může aplikovat hned
        });
    });


    // Tlačítko "OK" - id musí být shodné s tlačítkem v HTML
    const applyBtn = document.getElementById('apply-filter');
    if (applyBtn) {
        applyBtn.addEventListener('click', (event) => {
            event.preventDefault(); // zabrání reloadu formuláře
            applyFilter(); // spustí filtrování
        });
    }

    // Tlačítko Reset
    document.getElementById('reset-filter')?.addEventListener('click', () => {
        document.querySelectorAll('.filter-tristate-wrapper').forEach(el => {
            el.setAttribute('data-filter-state', 'null');
            el.setAttribute('aria-checked', 'mixed');
        });
        applyFilter(); // Aplikuje prázdné filtry = zobrazí vše
    });
});

// Pomocná funkce pro ARIA přepínání
function getAriaChecked(state) {
    if (state === 'true') return 'true';
    if (state === 'false') return 'false';
    return 'mixed';
}

function applyFilter() {
    const techFilters = {};
    const versionFilters = {};
    const activeFilters = [];

    // Rozřadit filtry podle tech a version
    document.querySelectorAll('.filter-tristate-wrapper').forEach(el => {
        const state = el.getAttribute('data-filter-state');
        const tech = el.getAttribute('data-tech');
        const version = el.getAttribute('data-version');

        if (state === 'true') {
            const label = el.getAttribute('data-label') || tech || version;
            activeFilters.push(label);
        }

        if (tech) techFilters[tech.toLowerCase()] = state;
        if (version) versionFilters[version.toLowerCase()] = state;
    });

    let visibleCount = 0;

    document.querySelectorAll('.project').forEach(proj => {
        const techsAttr = proj.getAttribute('data-tech') || '';
        const versionAttr = proj.getAttribute('data-version') || '';

        const techs = techsAttr.toLowerCase().split(',').map(t => t.trim());
        const versions = versionAttr.toLowerCase().split(',').map(v => v.trim());

        let show = true;

        // --- AND logika pro tech ---
        for (const [filterTech, filterState] of Object.entries(techFilters)) {
            const hasTech = techs.includes(filterTech);
            if (filterState === 'true' && !hasTech) {
                show = false;
                break;
            }
            if (filterState === 'false' && hasTech) {
                show = false;
                break;
            }
        }

        if (!show) {
            proj.style.setProperty('display', 'none', 'important');
            return;
        }

        // --- OR logika pro verze ---
        const activeTrueVersions = Object.entries(versionFilters)
            .filter(([_, state]) => state === 'true')
            .map(([ver]) => ver);

        if (activeTrueVersions.length > 0) {
            const hasAtLeastOneTrueVersion = activeTrueVersions.some(v => versions.includes(v));
            if (!hasAtLeastOneTrueVersion) {
                show = false;
            }
        }

        for (const [filterVersion, filterState] of Object.entries(versionFilters)) {
            const hasVersion = versions.includes(filterVersion);
            if (filterState === 'false' && hasVersion) {
                show = false;
                break;
            }
        }

        proj.style.setProperty('display', show ? 'flex' : 'none', 'important');
        if (show) visibleCount++;
    });

    // --- Zpětná vazba ---
    const summary = document.getElementById('filter-summary');
    const countElem = document.getElementById('project-count');
    const activeElem = document.getElementById('active-filters');
    const noResultsElem = document.getElementById('no-results');

    if (summary) {
        summary.style.display = 'block';
        countElem.textContent = visibleCount;
        activeElem.textContent = activeFilters.length > 0 ? activeFilters.join(', ') : 'žádné';
        noResultsElem.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

