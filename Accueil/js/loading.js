let login = prompt("Enter your name :")
if (login==null) {
    login="cir2"
}
//fonction de chargement des photos
function loadPhotos(photos) {
    for (let photo of photos) {
        document.getElementById('photo').innerHTML += `<div class="col-xs-2 col-md-2"><a href="#"><img id="${photo.id}" photoid="${photo.small}" src="${photo.small}" class="img-thumbnail"></a></div>`
    }


    document.getElementById('photo').addEventListener('click', (event) => {
        ajaxRequest("GET", "php/request.php/photos/" + event.target.id, (event) => {
            document.getElementById('photoplusgrand').innerHTML = `<div class="card col-xs-12 col-md-12"><div class="card-body"><h4>${event.title}</h4><img id="showed_photo" src="${event.large}" class="img-thumbnail" photoid="${event.id}"></div></div>`;
            ajaxRequest('GET', 'php/request.php/comment/' + event.id, displayComments);
        });
        // On affiche la barre des commentaires
        let comment_add = document.getElementById("comments-add");
            comment_add.style.display = 'block';
    },false);
}

//Chargement des photos
ajaxRequest("GET", "php/request.php/photos/", loadPhotos)

//Commentaire sou la photo
document.getElementById("comment-send").addEventListener('click', (event) => {
    event.preventDefault();
    let textInput = document.getElementById("comment-input").value;
    
    let photo_id = document.getElementById('showed_photo').getAttribute('photoid')
    let data = 'login=' + login + '&comment=' + textInput + '&photoId=' + photo_id
    
    ajaxRequest('POST', 'php/request.php/comment/', ()=> 
    {
        ajaxRequest('GET', 'php/request.php/comment/' + photo_id, displayComments);
    }, data)
    document.getElementById("comment-input").value = "";
})


//Affichage commentaire sous la photo
function displayComments(comms)
{
    document.getElementById('comments').innerHTML = '<div id="comments" class="container col-md-8"><h3>Commentaires</h3></div>'
    for (let comm of comms){
        document.getElementById('comments').innerHTML += '<div class="card">' + '<div class="card-body">' + comm.userLogin + ' : ' + comm.comment + '<div class="btn-group float-end" role="group">' + '<button type="button" class="btn btn-light float-end mod"' + ' value="' + comm.id + '"><i class="fa fa-edit"></i></button>' +'<button type="button" class="btn btn-light float-end del"' +' value="' + comm.id + '"><i class="fa fa-trash"></i></button>' + '<div></div></div>';
    }
    //Modification du commentaire
    modif_buttons = document.getElementsByClassName("btn btn-light float-end mod")
    for(let button of modif_buttons){
        console.log(button)
        button.addEventListener('click', (event) => {
            let id = event.target.closest('.mod').value
            ajaxRequest('PUT', 'php/request.php/comment/' + id, () => 
            {
                ajaxRequest('GET', 'php/request.php/comment/' + document.getElementById('showed_photo').getAttribute('photoid'), displayComments);
            },
            'login=' + login + "&text=" + prompt("Modification : ")
            )
        })
    }
    //Suppression du commentaire
    delete_buttons = document.getElementsByClassName("btn btn-light float-end del")
    for(let del_but of delete_buttons){
        del_but.addEventListener('click', (event) => {
            let id = event.target.closest('.del').value
            let data = '?login=' + login
            ajaxRequest('DELETE', 'php/request.php/comment/' + id + data, () => {
                ajaxRequest('GET', 'php/request.php/comment/' + document.getElementById('showed_photo').getAttribute('photoId'), displayComments)
            }
            )
        })
    }
}
