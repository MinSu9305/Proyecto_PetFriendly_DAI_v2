<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Donación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            background-color: #ffffff;
        }
        .certificate {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            border: 10px double #ffd30f;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #000000;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-style: italic;
            margin-top: 0;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
            position: relative;
        }
        .title:after {
            content: "";
            display: block;
            width: 100px;
            height: 3px;
            background: #ffd30f;
            margin: 10px auto;
        }
        .content {
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        .content p {
            text-align: center;
            margin-bottom: 25px;
        }
        .field {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
        }
        .label {
            font-weight: bold;
            margin-right: 10px;
            min-width: 160px;
            color: #000000;
        }
        .value {
            font-size: 16px;
            flex: 1;
        }
        .impact {
            font-style: italic;
            text-align: center;
            margin: 25px 0;
            padding: 15px;
            background-color: #fffdf0;
            border-left: 4px solid #ffd30f;
        }
        .thank-you {
            text-align: center;
            font-weight: bold;
            color: #f8cb03;
            margin: 25px 0;
            font-size: 18px;
        }
        .signature {
            text-align: center;
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }
        .signature-line {
            width: 250px;
            margin: 0 auto;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }
        .signature-name {
            font-size: 16px;
            font-weight: bold;
        }
        .signature-title {
            font-size: 14px;
            color: #666;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .signature-image {
    display: block;
    max-width: 200px; /* Ajusta según el tamaño de tu imagen */
    height: auto;
    margin: 0 auto 15px; /* Centra la imagen y añade espacio debajo */
}
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <img src="{{ public_path('images/sloganphoto.png') }}" alt="Pet Friendly Logo" class="logo" style="display: block;">
            <h1>PET FRIENDLY</h1>
            <p>Protegiendo a los animales desde 2020</p>
        </div>
        
        <div class="title">
            CERTIFICADO Nº {{ $certificateNumber }}
        </div>
        
        <div class="content">
            <p>Por medio del presente, se hace constar que:</p>
            
            <div class="field">
                <span class="label">Nombre del Donante:</span>
                <span class="value">{{ $donation->donor_name }}</span>
            </div>
            
            <div class="field">
                <span class="label">Fecha de la Donación:</span>
                <span class="value">{{ $formattedDate }}</span>
            </div>
            
            <div class="field">
                <span class="label">Monto Donado:</span>
                <span class="value">{{ $formattedAmount }}</span>
            </div>
            
            <div class="impact">
                "Su generosa contribución ayudará a proporcionar alimento, atención veterinaria 
                y un hogar temporal a animales necesitados."
            </div>
            
            <div class="thank-you">
                ¡Gracias por su apoyo y confianza!
            </div>
        </div>
        
        <div class="signature">
            <img src="{{ public_path('images/firmaPet.png') }}" alt="Firma" class="signature-image">
            <div class="signature-line"></div>
            <div class="signature-name">Organización PetFriendly</div>
            <div class="signature-title">Asociación sin fines de lucro</div>
        </div>
        
        <div class="footer">
            Pet Friendly | Avenida 001, Miraflores. Lima - Perú | Tel: +51 934 464 041 | petfriendly@gmail.com<br>
        </div>
    </div>
</body>
</html>