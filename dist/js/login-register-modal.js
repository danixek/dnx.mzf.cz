const toggle = document.getElementById('toggleForm');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const title = document.getElementById('modalTitle');

toggle.addEventListener('click', e => {
    e.preventDefault();

    const isLogin = !loginForm.classList.contains('d-none');

    loginForm.classList.toggle('d-none');
    registerForm.classList.toggle('d-none');

    title.textContent = isLogin ? 'Registrace' : 'Přihlášení';
    toggle.textContent = isLogin
        ? 'Už máš účet? Přihlásit'
        : 'Nemáš účet? Registrovat';
});