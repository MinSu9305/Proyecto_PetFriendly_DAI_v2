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
            padding: 0;
            box-sizing: border-box;
        }
        .certificate {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }
        .content {
            margin-bottom: 40px;
        }
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            margin-right: 10px;
        }
        .value {
            font-size: 16px;
        }
        .signature {
            text-align: center;
            margin-top: 50px;
        }
        .signature-line {
            width: 200px;
            margin: 0 auto;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }
        .signature-name {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="Pet Friendly Logo" class="logo">
            <h1>PET FRIENDLY</h1>
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
            
            <div class="field">
                <span class="label">Medio de Pago:</span>
                <span class="value">Transferencia Bancaria</span>
            </div>
        </div>
        
        <div class="signature">
            <div class="signature-line"></div>
            <div class="signature-name">Organización PetFriendly</div>
        </div>
    </div>
</body>
</html>
