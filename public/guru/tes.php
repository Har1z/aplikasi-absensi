<?php
        include "../../library/phpqrcode/qrlib.php";
        // user input        
        $param = "hariss"; 
        $divider = ",";

        // Path where the images will be saved
        $filepath = '../resources/images/QRcode/qr-temp-image.png';
        // Image (logo) to be drawn
        $logopath = '../resources/images/logo.png';
        // we need to be sure ours script does not output anything!!!
        // otherwise it will break up PNG binary! 
        ob_start("callback");

        // text for the qr code
        $codeText = 'Projectname'.$divider.$param;

        // end of processing here
        $debugLog = ob_get_contents();
        ob_end_clean();

        // create a QR code and save it in the filepath
        QRcode::png($codeText, '../resources/images/QRcode/qr-temp-images.png', QR_ECLEVEL_H, 9, 2, true );
        // QRcode::png("haii");

        // Start DRAWING LOGO IN QRCODE

        $QR = imagecreatefrompng($filepath);

        // START TO DRAW THE IMAGE ON THE QR CODE
        $logo = imagecreatefromstring(file_get_contents($logopath));
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width/3;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;

        imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        // Save QR code again, but with logo on it
        imagepng($QR,$filepath);
        // outputs image directly into browser, as PNG stream
        readfile($filepath);
?>