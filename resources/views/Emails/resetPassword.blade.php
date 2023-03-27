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
                    Pre obnovenie svojho hesla klikni na tlačidlo nižšie.
                </div>

                <div style="margin-top: 15px; margin-bottom: 15px; text-align: -webkit-center;">
                    <a href="{{ $actionUrl }}"
                        style="  color: #fff; background-color: #5bc157; text-align: center; text-decoration: none; border: none; padding: 8px 16px; font-size: 1rem; 
                        border-radius: 5px;">{{ $actionText }}</a>
                </div>

                <div>
                    Platnosť linku na obnovenie hesla je 60 minút. <br>
                    Ak si nepožiadal/a o obnovenie hesla, nie sú potrebné žiadne ďalšie kroky.
                </div> <br>

                <div>
                    <div>S pozdravom,</div>
                    <div>{{ config('app.name') }}</div>
                </div>
            </div>

            <hr style="height: 4px; background-color: #5bc157; opacity: 1; margin: 20px 0px; border:none">

            <div style="text-align: left">
                <strong>
                    Ak máš problémy s kliknutím na tlačidlo, skopíruj a vlož webovú adresu
                    <em>{{ $actionUrl }}</em> do svojho prehliadača.
                </strong>
            </div>
        </div>
    </div>
</body>

</html>
