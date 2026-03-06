<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Certificado – {{ $code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Serif', serif;
            background: #ffffff;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 3px solid #171847;
        }

        .border-inner {
            position: absolute;
            top: 11mm;
            left: 11mm;
            right: 11mm;
            bottom: 11mm;
            border: 1px solid #EC671C;
        }

        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 0 30mm;
        }

        .logo-header {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #EC671C;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 6mm;
        }

        .title {
            font-size: 32pt;
            color: #171847;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 6px;
            margin-bottom: 4mm;
        }

        .subtitle {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8mm;
        }

        .divider {
            width: 60mm;
            height: 2px;
            background: #EC671C;
            margin: 0 auto 8mm;
        }

        .certify-text {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #555555;
            margin-bottom: 4mm;
        }

        .student-name {
            font-size: 22pt;
            color: #171847;
            font-style: italic;
            margin-bottom: 4mm;
        }

        .course-text {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #555555;
            margin-bottom: 3mm;
        }

        .course-name {
            font-size: 14pt;
            color: #EC671C;
            font-weight: bold;
            margin-bottom: 3mm;
        }

        .duration {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #777777;
            margin-bottom: 10mm;
        }

        .footer-row {
            display: table;
            width: 100%;
            margin-top: 4mm;
        }

        .footer-col {
            display: table-cell;
            width: 33%;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            width: 45mm;
            height: 1px;
            background: #cccccc;
            margin: 0 auto 3mm;
        }

        .signature-label {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8pt;
            color: #777777;
        }

        .code-text {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 7pt;
            color: #aaaaaa;
            margin-top: 2mm;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="border-outer"></div>
        <div class="border-inner"></div>

        <div class="content">
            <div class="logo-header">Centro de Formação Canomar</div>

            <div class="title">Certificado</div>
            <div class="subtitle">de Participação e Aproveitamento</div>

            <div class="divider"></div>

            <div class="certify-text">Certifica-se que</div>
            <div class="student-name">{{ $enrollment->user->name }}</div>

            <div class="course-text">concluiu com aproveitamento o curso de</div>
            <div class="course-name">{{ $enrollment->course->name }}</div>

            <div class="duration">
                com a duração de {{ $enrollment->course->duration_hours }} horas
                &nbsp;·&nbsp;
                emitido em {{ $issuedAt->format('d \d\e F \d\e Y') }}
            </div>

            <div class="footer-row">
                <div class="footer-col">
                    <div class="signature-line"></div>
                    <div class="signature-label">Direcção Pedagógica</div>
                </div>
                <div class="footer-col">
                    <div class="code-text">Código de verificação</div>
                    <div class="signature-label">{{ $code }}</div>
                    <div class="code-text">centroformacaocanomar.test/verificar-certificado</div>
                </div>
                <div class="footer-col">
                    <div class="signature-line"></div>
                    <div class="signature-label">Direcção Executiva</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
