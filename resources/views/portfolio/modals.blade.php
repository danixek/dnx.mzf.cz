<!-- Modal -->
<div class="modal fade" id="loginRegisterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content bg-dark text-light custom-dark">

      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Přihlášení</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- LOGIN -->
        <form id="loginForm" class="w-75 mx-auto" method="post" action="{{ route('login') }}">
          @csrf

          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control mb-2" placeholder="Email">
          @error('email')
            <div class="text-danger">{{ $message }}</div>
          @enderror

          <label for="password">Heslo:</label>
          <input type="password" name="password" class="form-control mb-2" placeholder="Heslo">
          @error('password')
            <div class="text-danger">{{ $message }}</div>
          @enderror

          <button class="btn btn-primary w-100" style="filter: invert(1)">Přihlásit</button>
        </form>

        <!-- REGISTER -->
        <form id="registerForm" class="w-75 mx-auto d-none" method="post" action="{{ route('register') }}">
          @csrf

          <label for="username">Uživatelské jméno:</label>
          <input type="username" name="username" value="{{ old('username') }}" class="form-control mb-2" placeholder="Username" required>
          @error('username')
            <div class="text-danger">{{ $message }}</div>
          @enderror

          <label for="email">Email:</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control mb-2" placeholder="Email" required>
          @error('email')
            <div class="text-danger">{{ $message }}</div>
          @enderror

          <label for="password">Heslo:</label>
          <input type="password" name="password" class="form-control mb-2" placeholder="Heslo" required>
          @error('password')
            <div class="text-danger">{{ $message }}</div>
          @enderror

          <label for="confirmedPassword">Heslo znovu:</label>
          <input type="password" name="confirmedPassword" class="form-control mb-2" placeholder="Heslo znovu" required>

          <button class="btn btn-success w-100">Registrovat</button>
        </form>
      </div>

      <div class="modal-footer justify-content-center">
        <a href="#" id="toggleForm">Nemáš účet? Registrovat</a>
      </div>

    </div>
  </div>
</div>

<script src="js/login-register-modal.js"></script>
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