$('#form').submit(function(){
    event.preventDefault();
    const $form =$(this);
    const serijalizacija = $form.serialize();
    console.log(serijalizacija);
    
    if (activeItem){
        urediAjax(serijalizacija);
        return;
    }

    req = $.ajax({
        url: 'handler/add.php',
        type:'post',
        data: serijalizacija
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
            location.reload(true);
        }else console.log("Zadatak nije dodat "+res);
        console.log(res);
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeca greska se desila> '+textStatus, errorThrown)
    });
});



var activeItem = false;

function ponisti(){
    activeItem = false;
}

function uredi(id, naslov, prioritet, opis){
    activeItem = true;
    document.getElementById('id').value =id;
    document.getElementById('title').value =naslov;
    document.getElementById('priority').value = prioritet;
    document.getElementById('description').value = opis;
    
}

function urediAjax(serijalizacija){

    req = $.ajax({
        url: 'handler/update.php',
        type:'post',
        data: serijalizacija,
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
            location.reload(true);
        }else console.log("Zadatak nije uredjen "+res);
        console.log(res);
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeca greska se desila> '+textStatus, errorThrown)
    });

    activeItem = false;
}

function obrisi(id1){
    req = $.ajax({
        url: 'handler/delete.php',
        type:'post',
        data: {id:id1},
    });

    req.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
            location.reload(true);
        }else console.log("Zadatak nije obrisan "+res);
        console.log(res);
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.error('Sledeca greska se desila> '+textStatus, errorThrown)
    });

    activeItem = false;
}

function sortByPriority() {
    event.preventDefault();

    var toSort = document.getElementById('sort').children;
    toSort = Array.prototype.slice.call(toSort, 0);
    toSort.sort(function(a, b) {
        var aord = +a.children[1].innerHTML;
        var bord = +b.children[1].innerHTML;
        return aord - bord;
    });

    var parent = document.getElementById('sort');
    parent.innerHTML = "";

    for(l = toSort.length-1; l>=0; l--) {
        parent.appendChild(toSort[l]);
    }
  }