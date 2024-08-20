<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Attendance - absen hadir</title>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <style>

        html {
            background-color: darkgreen;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        #reader {
            width: 400px;
        }

        #result {
            text-align: center;
            font-size: 1.5rem;
        }
    </style>

    <button id="buttonTest">open camera</button>
    <main>
        <div id="reader" width="600px" height="600px" style="background-color: red; color: red;"></div>
        <div id="result"></div>

        <form action="/test" method="POST" target="dummyframe">
            <input type="text" name="tes" id="">
            <button type="submit">isiiiii</button>
        </form>

        <a href="../guru/">asasdasd</a>

        <iframe name="dummyframe" id="" style="display: none;"></iframe>
    </main>

    <script>
        const html5QrCode = new Html5Qrcode("reader");

        document.querySelector("#buttonTest").addEventListener("click", function scanner() {

            document.getElementById('result').innerHTML = ``;

            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                /* handle success */
                document.getElementById('result').innerHTML = `
                <h2>Success!</h2>
                <p><a href="${decodedText}">${decodedText}</a></p>
                `;

                html5QrCode.stop().then((ignore) => {
                    // QR Code scanning is stopped.
                }).catch((err) => {
                    // Stop failed, handle it.
                });

                document.getElementById('reader').style('display: none;');
                // Removes reader element from DOM since no longer needed

            };
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };

            // If you want to prefer back camera
            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
        });

        //IDK WHY DID I USE JQUERY
        $(document).ready(function () {
            // Function to toggle the modal
            $('#button').click(function () {


            });
        });
    </script>
</body>

</html> 