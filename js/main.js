window.onload = init;


const handleFormSubmit = event => {

    event.preventDefault();

    const data = formToJSON(form.elements);

    sendToServer(data);

};


function init() {
    //add form submit handle, prevent default
    form = document.getElementById('messageForm');
    form.addEventListener('submit', handleFormSubmit);
}

const formToJSON = elements => [].reduce.call(elements, (data, element) => {

    data[element.name] = element.value;

    return data;
}, {});


function sendToServer(data) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("messageForm").innerHTML = this.responseText;
            refreshList();
        }
    };
    xhttp.open("POST", "./MessageForm.php");
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify(data));

}

function refreshList() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("messageList").innerHTML = this.responseText;
        }
    };
    var page = location.search.split('page=')[1];
    xhttp.open("GET", "./MessageList.php" + (page ? "?page=" + page : ''));
    xhttp.send();
}


