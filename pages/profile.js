// Функция обратного отсчета
function countdown(element, seconds) {
    var timer = setInterval(function() {
      var hours = Math.floor(seconds / 3600);
      var minutes = Math.floor((seconds % 3600) / 60);
      var remainingSeconds = seconds % 60;
  
      element.text(pad(hours) + ':' + pad(minutes) + ':' + pad(remainingSeconds));
  
      if (seconds <= 0) {
        clearInterval(timer);
        // Дополнительные действия при истечении времени (например, установка статуса задачи)
      }
  
      seconds--;
    }, 1000);
  }
  
  // Функция для добавления ведущего нуля к числу меньше 10
  function pad(number) {
    return number < 10 ? '0' + number : number;
  }
  
  $(document).ready(function() {
    // Обработчик нажатия на кнопку "Задача выполнена"
    $('.complete-btn').click(function() {
      $('.popup-overlay').fadeIn();
    });
  
    // Обработчик нажатия на кнопку "Закрыть" в попапе
    $('.close-btn').click(function() {
      $('.popup-overlay').fadeOut();
    });
  
    // Обработчик отправки формы в попапе
    $('.submit-btn').click(function() {
      var description = $('textarea').val();
      // Дополнительные действия при отправке формы (например, сохранение описания задачи)
      $('.popup-overlay').fadeOut();
    });
  
    // Инициализация обратного отсчета для каждой задачи
    $('.countdown').each(function() {
      var element = $(this);
      var time = element.text();
      var hours = parseInt(time.slice(0, 2));
      var minutes = parseInt(time.slice(3, 5));
      var seconds = parseInt(time.slice(6, 8));
      var totalSeconds = hours * 3600 + minutes * 60 + seconds;
      countdown(element, totalSeconds);
    });
});
let tasks = document.querySelectorAll('.tasks li');
tasks.forEach(element => {
    element.addEventListener('click', (e) => {
        console.log(e.target.classList.contains('complete-btn'))
        if(e.target.classList.contains('complete-btn')){
            document.querySelector('.popup h3').innerHTML = `Отчет о задаче "${element.querySelector('.task-title').innerHTML}"`;
        }
    });
});