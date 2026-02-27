<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmar Cuenta</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F5F7FA;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        .btn {
            background: #6C63FF;
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
        }

        .btn:hover {
            background: #584fd6;
        }
    </style>

</head>

<body>

    <table width="100%">

        <!-- HEADER -->
        <tr>
            <td align="center" bgcolor="#2F4363">
                <table width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center" style="padding:40px; color:white;">


                            <h1 style="margin:0;">Social Serve Link</h1>
                            <p style="margin:5px 0;">Sistema de Gestión de Servicio Social</p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- CARD PRINCIPAL -->
        <tr>
            <td align="center">
                <table width="100%" bgcolor="white"
                    style="max-width:600px; margin-top:-30px; border-radius:10px; padding:30px;">

                    <tr>
                        <td align="center" style="font-family:Roboto, Arial, sans-serif;">
                            <h2 style="color:#2F4363; margin-top:20px; text-align:center;">
                                Confirmación de registro
                            </h2>

                            <p
                                style="color:#555; font-size:15px; line-height:24px; text-align:center; max-width:480px;">
                                Hola <strong>{{ $nombreCompleto }}</strong>,
                                <br><br>
                                Queremos agradecerte por registrarte en el sistema Social Serve Link y darte la mejor de
                                nuestras bienvenidas.
                            </p>
                            <p
                                style="color:#555; font-size:15px; line-height:24px; text-align:center; max-width:480px;">
                                A continuación te compartimos tus datos de acceso:
                            </p>
                        </td>
                    </tr>

                    <!-- CREDENCIALES -->
                    <tr>
                        <td align="center" style="padding-top:15px;">
                            <table width="90%" bgcolor="#F2F4F8"
                                style="padding:30px; border-radius:10px; font-size:15px; color:#333;">
                                <tr>
                                    <td align="left"
                                        style="border:1px solid #e0e0e0; border-radius:8px; padding:15px; width:350px; font-family:Arial, sans-serif; background:#f9f9f9;">
                                        <strong style="font-size:16px;">Datos de acceso:</strong>
                                        <br><br>

                                        <div style="margin-bottom:15px;">
                                            📧 <strong>Correo:</strong> {{ $email }}
                                        </div>

                                        <div>
                                            🔐 <strong>Contraseña:</strong> {{ $password }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- BOTON -->
                    <tr>
                        <td align="center" style="padding:30px;">
                            <a href="{{-- $url --}}" class="btn">
                                Ingresar al Sistema
                            </a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td align="center" style="padding:30px; color:#888; font-family:'Segoe UI', Roboto, Arial, sans-serif;">
                © 2026 Social Serve Link - Todos los derechos reservados
            </td>
        </tr>

    </table>

</body>

</html>
