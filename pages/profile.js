// Функция обратного отсчета
function countdown(element, seconds) {
  var timer = setInterval(function () {
    var hours = Math.floor(seconds / 3600);
    var minutes = Math.floor((seconds % 3600) / 60);
    var remainingSeconds = seconds % 60;
    element.text(pad(hours) + ':' + pad(minutes) + ':' + pad(remainingSeconds));
    if (seconds <= 0) {
      clearInterval(timer);
      // Дополнительные действия при истечении времени (например, установка статуса задачи)
    }
    document.querySelectorAll('.deadline').forEach(block => {
      if (block.querySelector('.countdown') === element[0]) {
        if (block.querySelector('.minus').innerHTML === '-') {
          block.classList.add('late');
          seconds = seconds + 1;
        } else {
          seconds--;
        }
      }
    });
  }, 1000);
}

// Функция для добавления ведущего нуля к числу меньше 10
function pad(number) {
  return number < 10 ? '0' + number : number;
}

$(document).ready(function () {
  // Обработчик нажатия на кнопку "Задача выполнена"
  $('.complete-btn').click(function () {
    $('.popup-overlay').fadeIn();
  });

  // Обработчик нажатия на кнопку "Закрыть" в попапе
  $('.close-btn').click(function () {
    $('.popup-overlay').fadeOut();
  });
  $('.popup-container').click(function (e) {
    if (e.target == this) $('.popup-overlay').fadeOut();
  });
  $('.popup-overlay').click(function (e) {
    if (e.target == this) $('.popup-overlay').fadeOut();
  });

  // Инициализация обратного отсчета для каждой задачи
  $('.countdown').each(function () {
    var element = $(this);
    var time = element.text();
    var match = time.split(':');
    var hours = Number(match[0]);
    var minutes = Number(match[1]);
    var seconds = Number(match[2]);
    var totalSeconds = hours * 3600 + minutes * 60 + seconds;
    countdown(element, totalSeconds);
  });
});
//Обрабатываем событие нажатия на "задачу"
let tasks = document.querySelectorAll('.tasks li');
tasks.forEach(element => {
  element.addEventListener('click', (e) => {
    console.log(e.target.classList.contains('complete-btn'))
    if (e.target.classList.contains('complete-btn')) {
      document.querySelector('.popup h3').innerHTML = `Отчет о задаче "${element.querySelector('.task-title').innerHTML}"`;
    }
  });
});

//Обрабатываем событие нажатия на "задачу"
let buttons = document.querySelectorAll('.task');
for(let i=0; i < buttons.length; i++) {
  buttons[i].addEventListener('click', (e)=>{
    if(e.target.classList.contains('complete-btn')){
      document.getElementById('my-task').value = document.querySelectorAll('.task')[i].getAttribute('dataid');
      document.getElementById('minus-task').value = document.querySelectorAll('.task')[i].querySelector('.minus').innerHTML;
      console.log(document.querySelectorAll('.task')[i])
      document.getElementById('time-task').value = document.querySelectorAll('.task')[i].querySelector('.countdown').innerHTML;
    }
  });
}

//Отправка формы "сотрудника"
$('#review-form').submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  $.ajax({
      url: '../vendor/review.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success (data) {
        location.reload();
        console.log(data)
      },
      error: function(xhr, status, error) {
          console.error('Ajax request failed. Status: ' + xhr.status + ' ' + error);
      }
  });
});