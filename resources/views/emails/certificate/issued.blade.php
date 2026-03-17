<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Disponível</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; }
        .header { background: #171847; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .header span { color: #EC671C; }
        .badge { display: inline-block; background: #22c55e; color: #ffffff; border-radius: 20px; padding: 4px 16px; font-size: 13px; margin-top: 10px; }
        .body { padding: 32px 40px; color: #333333; line-height: 1.6; }
        .body h2 { color: #171847; margin-top: 0; }
        .info-box { background: #f9f9f9; border-left: 4px solid #EC671C; padding: 16px 20px; border-radius: 4px; margin: 20px 0; }
        .info-box p { margin: 6px 0; font-size: 14px; }
        .info-box strong { color: #171847; }
        .code-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 16px 20px; margin: 20px 0; text-align: center; }
        .code-box .code { font-size: 20px; font-weight: bold; color: #171847; letter-spacing: 2px; }
        .btn { display: inline-block; background: #EC671C; color: #ffffff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 16px; }
        .footer { background: #f5f5f5; padding: 20px 40px; text-align: center; font-size: 12px; color: #999999; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Centro de Formação <span>Canomar</span></h1>
            <div class="badge">Certificado Emitido</div>
        </div>
        <div class="body">
            <h2>O seu certificado está disponível!</h2>
            <p>Olá, <strong>{{ $certificate->user->name }}</strong>,</p>
            <p>
                Parabéns pela conclusão do curso! O seu certificado foi emitido e está disponível para download no Portal do Aluno.
            </p>
            <div class="info-box">
                <p><strong>Curso:</strong> {{ $certificate->course->name }}</p>
                <p><strong>Emitido em:</strong> {{ $certificate->issued_at->format('d/m/Y') }}</p>
            </div>
            <div class="code-box">
                <p style="margin: 0 0 6px; font-size: 13px; color: #666;">Código do Certificado</p>
                <div class="code">{{ $certificate->code }}</div>
            </div>
            <a href="{{ config('app.url') }}/aluno" class="btn">Aceder ao Portal do Aluno</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Centro de Formação Canomar. Todos os direitos reservados.</p>
            <p>Este email foi enviado automaticamente. Por favor, não responda a esta mensagem.</p>
        </div>
    </div>
</body>
</html>
