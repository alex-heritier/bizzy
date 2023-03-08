<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Business Details</title>

    @vite(['resources/css/style.css'])
    <style>
        #content {
            padding: 10px;
        }

        img {
            width: 100%;
            aspect-ratio: 16/9;
            border: 1px solid black;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div id="biz"></div>
    <script>
        //get the id value from the URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        function urlEncode(z) {
            return z.replaceAll(" ", "+");
        }

        //make a GET request to the server for the biz with the given id
        fetch('/svr/biz_get.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                // console.log("DATA", data);
                //if a biz with the given id exists, display it
                if (data !== null && data.name) {
                    let biz = `
                           <img src="${data.main_img}"/>

                           <div id="content">
                            <h1>${data.name} | ${data.trade}</h1>
                            <p>${data.descr}</p>

                            <br>
                            <a target="_blank" href="http://${data.url}">${data.url}</a>
                            ${data.email == null ? "" : `<p>${data.email}</p>`}
                            ${data.phone == null ? "" : `<p>${data.phone}</p>`}
                            <p>Zone: ${data.d_pretty}, ${data.w_pretty}</p>

                            <br>
                            <a id="google-btn" target="_blank" href="https://www.google.com/maps/dir//${urlEncode(data.w_pretty)},+${urlEncode(data.d_pretty)},+Ho+Chi+Minh+City">Get Directions</a>
                           </div>
                           
                           `;
                    document.getElementById("biz").innerHTML = biz;
                    document.title = `${data.name} | Business Details`;

                    let latlng = getCookie('my_latlng');
                    if (latlng) {
                        let lat = latlng.split(":")[0];
                        let lng = latlng.split(":")[1];
                        document.getElementById("google-btn").href = document.getElementById("google-btn").href.replace("dir//", `dir/${lat},${lng}/`);
                    }
                } else {
                    //if no biz with the given id exists, display an error message
                    document.getElementById("biz").innerHTML = "Business not found"; // data.error;
                }
            });

        // Function to get the value of a cookie
        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }
    </script>
</body>

</html>