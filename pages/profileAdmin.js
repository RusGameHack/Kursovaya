let workmans = document.querySelectorAll('.addTask');
for(let i = 0; i < workmans.length; i++) {
    workmans[i].addEventListener('click', ()=>{
        $('.popup-overlay').fadeIn();
        document.querySelectorAll('.admin-form').forEach(element => {
            element.style.display = 'none';
        });
        document.querySelector('#addTask').style.display = '';

        document.getElementById('workingId').value = document.querySelectorAll('.workman')[i].getAttribute('dataId');
        document.querySelector('.popup-up h3').innerHTML = document.querySelectorAll('.workman')[i].querySelector('.workman-name').innerHTML;
    });
}
let task = document.querySelectorAll('.task');
for (let i = 0; i < task.length; i++) {
    task[i].addEventListener('click', (e)=> {
        if(e.target.classList.contains('delete-btn')) {
            $.ajax({
                url: '../vendor/deleteTask.php',
                type: 'POST',
                data: {idTask: task[i].getAttribute('dataid')},
                success (data) {
                    // console.log(data)
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Ajax request failed. Status: ' + xhr.status + ' ' + error);
                }
            });
        }
        if(e.target.classList.contains('change-btn')) {
            $('.popup-overlay').fadeIn();
            document.querySelectorAll('.admin-form').forEach(element => {
                element.style.display = 'none';
            });
            let form = document.querySelector('#changeTask');
            form.style.display = '';
            let inputForms = form.querySelectorAll('input');
            inputForms[0].value = task[i].querySelector('.task-title').innerHTML;
            inputForms[3].value = task[i].getAttribute('dataid');
            form.querySelector('textarea').value = task[i].querySelector('.task-descr').innerHTML;
        }
    });
}
//Отправка формы "изменение задачи"
$('#changeTask').submit(function(e) {
    e.preventDefault();
    let formBlock = document.querySelector('#changeTask');
    let inputForms = formBlock.querySelectorAll('input');
    if(inputForms[0].value == '' || inputForms[1].value == '' || inputForms[2].value == '' || formBlock.querySelector('textarea').value == ''){
        document.querySelector('.form-message-changeTask').innerHTML = 'Вы ввели не все данные!';
    }
    else {
        var form = $(this);
        var formData = new FormData(form[0]);
        console.log(formData)
        $.ajax({
            url: '../vendor/changeTask.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success (data) {
                console.log(data);
                $('.popup-overlay').fadeOut();
                location.reload();
            },
        });
    }
});
//Отправка формы "Добавление задачи"
$('#addTask').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(form[0]);
    console.log(formData)
    $.ajax({
        url: '../vendor/addTask.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success (data) {
            $('.popup-overlay').fadeOut();
            console.log(data);
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Ajax request failed. Status: ' + xhr.status + ' ' + error);
        }
    });
});

document.querySelectorAll('input').forEach(element => {
    element.addEventListener('input', ()=> {
        document.querySelector('.error').innerHTML = '';
    });
});
document.querySelectorAll('textarea').forEach(element => {
    element.addEventListener('input', ()=> {
        document.querySelector('.error').innerHTML = '';
    });
});