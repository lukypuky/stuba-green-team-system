<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
</head>

<body>
    <div style="background-color: #eaeaea; text-align: -webkit-center; padding: 35px 0;">
        <div style="padding: 20px; background-color: white; border-radius: 25px; width: 576px;">
            <hr style="height: 4px; background-color: #5bc157; opacity: 1; margin: 20px 0px; border:none">

            <div style="text-align: left">
                Ahoj!
            </div> <br>

            <div style="text-align: left">
                <div>
                    bol Ti vytvorený účet v systéme STUBA Green Team.<br>
                    Zároveň ťa prosíme, aby si si zmenil svoje heslo po prvom prihlásení.<br><br>
                </div>
                <div>
                    <div style="font-weight: bold;">
                        Prihlasovacie údaje:
                    </div>
                    <div>
                        Email: {{ $email }} <br>
                        Heslo: {{ $password }}
                    </div>
                </div> <br>

                <div>
                    <div>S pozdravom,</div>
                    <div>STUBA Green Team</div>
                </div>
            </div>

            <hr style="height: 4px; background-color: #5bc157; opacity: 1; margin: 20px 0px; border:none">
        </div>
    </div>
</body>

</html>
