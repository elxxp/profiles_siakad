function directing(){
    document.getElementById('overlay').classList.remove('hidden');
    document.getElementById('dialog').classList.remove('hidden');

    setTimeout(function(){
        document.getElementById('overlay').classList.add('hidden');
        document.getElementById('dialog').classList.add('hidden');
    }, 7000);
}