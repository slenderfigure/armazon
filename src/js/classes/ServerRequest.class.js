class ServerRequest {
    static XHLRequest (path, body) {
        let xhl = new XMLHttpRequest();

        xhl.open('POST', path, true);
        xhl.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhl.send(body);

        return xhl;
    }
}