<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Centro de Formação Canomar</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; }
        .header { background: #171847; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .header span { color: #EC671C; }
        .body { padding: 32px 40px; color: #333333; line-height: 1.6; }
        .body h2 { color: #171847; margin-top: 0; }
        .info-box { background: #f9f9f9; border-left: 4px solid #EC671C; padding: 16px 20px; border-radius: 4px; margin: 20px 0; }
        .info-box p { margin: 6px 0; font-size: 14px; }
        .info-box strong { color: #171847; }
        .btn { display: inline-block; background: #EC671C; color: #ffffff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 16px; }
        .footer { background: #f5f5f5; padding: 20px 40px; text-align: center; font-size: 12px; color: #999999; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Centro de Formação <span>Canomar</span></h1>
        </div>
        <div class="body">
            <h2>Bem-vindo(a), {{ $user->name }}!</h2>
            <p>
                A sua conta foi criada com sucesso. Já pode aceder ao portal do aluno e inscrever-se
                nos nossos cursos.
            </p>
            <div class="info-box">
                <p><strong>Nome:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Data de registo:</strong> {{ $user->created_at->format('d/m/Y \à\s H:i') }}</p>
            </div>
            <p>Se não criou esta conta, por favor contacte-nos imediatamente.</p>
            <a href="{{ config('app.url') }}/aluno" class="btn">Aceder ao Portal do Aluno</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Centro de Formação Canomar. Todos os direitos reservados.</p>
            <p>Este email foi enviado automaticamente. Por favor, não responda a esta mensagem.</p>
        </div>
    </div>
</body>
</html>
