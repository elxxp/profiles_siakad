function directing(server, order){
    document.getElementById('o1').classList.add('hidden');
    document.getElementById('o2').classList.add('hidden');
    document.getElementById('o3').classList.add('hidden');
    document.getElementById('o4').classList.add('hidden');
    document.getElementById('o5').classList.add('hidden');
    document.getElementById('o6').classList.add('hidden');
    document.getElementById('o7').classList.add('hidden');

    document.getElementById('overlay').classList.remove('hidden');
    document.getElementById('loading').classList.remove('hidden');

    setTimeout(function(){
        document.getElementById('o1').classList.remove('hidden');
    }, 500);

    setTimeout(function(){
        document.getElementById('o1').classList.add('hidden');
        document.getElementById('o2').classList.remove('hidden');
    }, 2000);

    setTimeout(function(){
        document.getElementById('o2').classList.add('hidden');
        document.getElementById('o3').classList.remove('hidden');
    }, 3000);

    setTimeout(function(){
        document.getElementById('o3').classList.add('hidden');
        document.getElementById('o4').classList.remove('hidden');
    }, 6000);

    setTimeout(function(){
        document.getElementById('o4').classList.add('hidden');
        document.getElementById('o5').classList.remove('hidden');
    }, 7000);

    setTimeout(function(){
        document.getElementById('o5').classList.add('hidden');
        document.getElementById('o6').classList.remove('hidden');
    }, 11000);

    setTimeout(function(){
        document.getElementById('o6').classList.add('hidden');
        document.getElementById('o7').classList.remove('hidden');
    }, 12000);

    setTimeout(function(){
        if(server == 'local'){
            let profile = 'profileLocal' + order
            document.getElementById(profile).submit();
        } else {
            let profile = 'profileServer' + order
            document.getElementById(profile).submit();
        }
    }, 14000);
    
    setTimeout(function(){
        document.getElementById('overlay').classList.add('hidden');
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('o7').classList.add('hidden');
    }, 16000);
}

setTimeout(function(){
    document.getElementById('error').classList.add('hidden');
}, 2000);