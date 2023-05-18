// Обработчик отправки формы авторизации
$('#login-form').submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(form[0]);
    $.ajax({
        url: './vendor/login.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success (data) {
            data = JSON.parse(data);
            if (data.status) {
                document.location.href = '/pages/profile.php';
            } else {
                if (data.type === 1) {
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax request failed. Status: ' + xhr.status + ' ' + error);
        }
    });
});

let avatar = false;

$('input[name="avatar"]').change(function (e) {
    avatar = e.target.files[0];
    console.log(avatar)
});
// Обработчик отправки формы регистрации
$('#register-form').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(form[0]);
    $.ajax({
        url: './vendor/register.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success (data) {
            data = JSON.parse(data);
            if (data.status) {
                document.location.href = '/index.php';
            } else {
                if (data.type === 1) {
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Ajax request failed. Status: ' + xhr.status + ' ' + error);
        }
    });
});