/**
 * @Author: Gwengann LE CORVIC
 * @Company: ISEN Yncréa Ouest
 * @Email: gwengann.le-corvic@isen-ouest.yncrea.fr
 * @Created Date: 02-Apr-2024 - 09:14:00
 * @Last Modified: 11-Apr-2024 - 10:00:00
 */

'use strict';

//Création d'un chat
let websocket;
document.getElementById('message').addEventListener('click',sendMessage);
createWebSocket();

function createWebSocket() {
    websocket=new WebSocket('ws://localhost:12345');

    websocket.onmessage=(event)=>{
        let textArea;
        textArea=document.getElementById('chat-room');
        textArea.value+=event.data+'\n';
        textArea.scrollTop =textArea.scrollHeight;
    };
}
//Envoie d'un message dans le chat
function sendMessage(event) {
    event.preventDefault();
    let message=document.getElementById('chat-message').value;
    websocket.send(login+' : '+message);
    document.getElementById('chat-message').value='';
}