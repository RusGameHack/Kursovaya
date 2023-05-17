window.lastActivity = Date.now();
document.addEventListener('click', function(){
    window.lastActivity = Date.now();
})
var TIMEOUT = 600000 //10 mins
var activityChecker = setInterval(check, 600000);
function check() {
    var currentTime = Date.now();
    if (currentTime - window.lastActivity > TIMEOUT) {
        // console.log('Пользователь не активен')
        $.ajax({
            url: '../vendor/onlineUser.php',
            type: 'POST',
            data: {online: 0},
            success (data) {
                // console.log(data);
                location.reload();
            }
        });
    } else {
        // console.log('Пользователь активен');
        $.ajax({
            url: '../vendor/onlineUser.php',
            type: 'POST',
            data: {online: 1},
            success (data) {
                // console.log(data);
                location.reload();
            }
        });
    }
}