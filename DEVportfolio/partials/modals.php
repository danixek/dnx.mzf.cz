<!-- Modal -->
<div class="modal fade" id="loginRegisterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content bg-dark text-light custom-dark">

      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Přihlášení</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <?php

        if (!isset($_SESSION['redirect_after_login'])) {
          $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        }
        ?>

        <!-- LOGIN -->
        <form id="loginForm" class="w-75 mx-auto" method="post" action="/auth/login.php">
          <input type="email" name="email" class="form-control mb-2" placeholder="Email">
          <input type="password" name="password" class="form-control mb-2" placeholder="Heslo">
          <button class="btn btn-primary w-100" style="filter: invert(1)">Přihlásit</button>
        </form>

        <!-- REGISTER -->
        <form id="registerForm" class="w-75 mx-auto d-none" method="post" action="/auth/register.php">
          <input type="username" name="username" class="form-control mb-2" placeholder="Username">
          <input type="email" name="email" class="form-control mb-2" placeholder="Email">
          <input type="password" name="password" class="form-control mb-2" placeholder="Heslo">
          <input type="password" name="confirmedPassword" class="form-control mb-2" placeholder="Heslo znovu">
          <button class="btn btn-success w-100">Registrovat</button>
        </form>

      </div>

      <div class="modal-footer justify-content-center">
        <a href="#" id="toggleForm">Nemáš účet? Registrovat</a>
      </div>

    </div>
  </div>
</div>

<?php if (isset($_SESSION['login_error'])): ?>
  <div class="modal fade" id="loginErrorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content bg-dark text-light custom-dark">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Chyba přihlášení</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <?= htmlspecialchars($_SESSION['login_error']);
          unset($_SESSION['login_error']); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Zavřít
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modal = new bootstrap.Modal(document.getElementById('loginErrorModal'));
      modal.show();
    });
  </script>
<?php endif; ?>

<script src="DEVportfolio/js/login-register-modal.js"></script>
<style>
  .modal-content.custom-dark .form-control,
  .modal-content.custom-dark .form-control::placeholder {
    background-color: #2a2a2a;
    color: #dbdbdb;
    border: 1px solid #444;
  }

  .modal-content.custom-dark a {
    color: #dbdbdb;
  }
</style>