<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<body>
    <div style="background-color: #eaeaea; text-align: -webkit-center; padding: 35px 0;">
        <div style="padding: 20px; background-color: white; border-radius: 25px; width: 576px;">
            {{-- <div style="padding: 5px;">
                <img src="{{ $message->embed(storage_path() . '/app/img/icon-PositiveID.png') }}"
                    style="width: 70px; height: auto;" alt="positive-logo">
            </div> --}}

            <hr style="height: 4px; background-color: #fb5404; opacity: 1; margin: 20px 0px; border:none">

            <div style="text-align: left">
                Dobrý deň!
            </div> <br>

            <div style="text-align: left">
                <div>
                    Pre overenie Vašej emailovej adresy kliknite na tlačidlo nižšie.
                </div>

                <div style="margin-top: 15px; margin-bottom: 15px; text-align: -webkit-center;">
                    <a href="{{ $actionUrl }}"
                        style="  color: #fff; background-color: #fb5404; text-align: center; text-decoration: none; border: none; padding: 8px 16px; font-size: 1rem; 
                        border-radius: 5px;">{{ $actionText }}</a>
                </div>

                <div>
                    Ak ste si účet nevytvárali, nie sú potrebné žiadne ďalšie kroky.
                </div> <br>

                <div>
                    <div>S pozdravom,</div>
                    <div>{{ config('app.name') }}</div>
                </div>
            </div>

            <hr style="height: 4px; background-color: #fb5404; opacity: 1; margin: 20px 0px; border:none">

            <div style="text-align: left">
                <strong>
                    Ak máte problémy s kliknutím na tlačidlo, skopírujte a vložte webovú adresu
                    <em>{{ $actionUrl }}</em> do svojho prehliadača.
                </strong>
            </div>
        </div>
    </div>
</body>

</html>
