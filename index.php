<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Авторизация и регистрация</title>
  <link rel="stylesheet" href="./fonts/fonts.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <form id="login-form" class="visible">
        <h2>Авторизация</h2>
        <input name="login" type="text" placeholder="Логин" required>
        <input name="password" type="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
      </form>
      <form id="register-form">
        <h2>Регистрация</h2>
        <input name="name" type="text" placeholder="Имя" required>
        <input name="surname" type="text" placeholder="Фамилия" required>
        <input name="login" class="loginRegister" type="text" placeholder="Логин" required>
        <label for="avatar">Фотография</label>
        <input type="file" name="avatar">
        <input name="password" class="passwordRegister" type="password" placeholder="Пароль" required>
        <input name="password_confirm" type="password" placeholder="Повторите пароль" required>
        <div class="isAdminBlocks">
          <div class="isAdminBlock">
            <label for="isAdmin">Админ</label>
            <input type="radio" name="isAdmin" value="1">
          </div>
          <div class="isAdminBlock">
            <label for="isAdmin">Работник</label>
            <input type="radio" name="isAdmin" value="0">
          </div>
        </div>
        <button type="submit">Зарегистрироваться</button>
      </form>
      <div class="msg"></div>
      <div class="toggle-forms">
        <button id="login-toggle">Авторизация</button>
        <button id="register-toggle">Регистрация</button>
      </div>
    </div>
  </div>

  <script src="./js/jQuery.min.js"></script>
  <script src="script.js"></script>
  <script src="ajax.js"></script>
</body>
</html>