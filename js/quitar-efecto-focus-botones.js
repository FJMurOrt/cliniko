var botones = document.getElementsByClassName('btn');

for (var i = 0; i < botones.length; i++) {
    botones[i].addEventListener('click', function() {
        this.blur();
    });
}