
document.getElementById('authentication-send').addEventListener('click', (event) => {
        let login=document.getElementById("login").value;
        let password=document.getElementById("password").value;
        ajaxReq(login,password);
        //ajaxRequest("GET","php/request.php/photos/");
})
