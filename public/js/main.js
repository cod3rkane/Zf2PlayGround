/**
 * Created by Cod3r Kane on 10/09/2016.
 */

function search(str) {
    if (str.length == 0) {
        document.getElementById("search").innerHTML = "";
        return;
    } else {
        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result").innerHTML = '<h2>Result</h2><pre>' + this.responseText + '</pre>';
            }
        };
        req.open('GET', '/api/sintegra/' + str, true);
        req.send();
    }
}

function deleteIntegra(id) {
    if (!id) {
        document.getElementById("search").innerHTML = "";
        return;
    } else {
        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        };
        req.open('GET', '/api/sintegra/delete/' + id, true);
        req.send();
    }
}