<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição Confirmada</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; }
        .header { background: #171847; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .header span { color: #EC671C; }
        .badge { display: inline-block; background: #EC671C; color: #ffffff; border-radius: 20px; padding: 4px 16px; font-size: 13px; margin-top: 10px; }
        .body { padding: 32px 40px; color: #333333; line-height: 1.6; }
        .body h2 { color: #171847; margin-top: 0; }
        .info-box { background: #f9f9f9; border-left: 4px solid #EC671C; padding: 16px 20px; border-radius: 4px; margin: 20px 0; }
        .info-box p { margin: 6px 0; font-size: 14px; }
        .info-box strong { color: #171847; }
        .welcome { background: #fff8f3; border: 1px solid #f0d0b8; border-radius: 6px; padding: 16px 20px; margin: 20px 0; font-size: 14px; }
        .btn { display: inline-block; background: #EC671C; color: #ffffff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 16px; }
        .footer { background: #f5f5f5; padding: 20px 40px; text-align: center; font-size: 12px; color: #999999; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Centro de Formação <span>Canomar</span></h1>
            <div class="badge">Inscrição Confirmada</div>
        </div>
        <div class="body">
            <h2>Bem-vindo(a) ao curso!</h2>
            <p>Olá, <strong>{{ $enrollment->user->name }}</strong>,</p>
            <p>
                A sua inscrição está <strong>confirmada</strong>. Estamos muito felizes em tê-lo(a) connosco
                e desejamos-lhe um excelente percurso formativo!
            </p>
            <div class="info-box">
                <p><strong>Curso:</strong> {{ $enrollment->course->name }}</p>
                @if ($enrollment->courseClass)
                    <p><strong>Turma:</strong> {{ $enrollment->courseClass->name }}</p>
                    @if ($enrollment->courseClass->start_date)
                        <p><strong>Início:</strong> {{ \Carbon\Carbon::parse($enrollment->courseClass->start_date)->format('d/m/Y') }}</p>
                    @endif
                    @if ($enrollment->courseClass->location)
                        <p><strong>Local:</strong> {{ $enrollment->courseClass->location }}</p>
                    @endif
                @endif
                <p><strong>Duração:</strong> {{ $enrollment->course->duration_hours }} horas</p>
            </div>
            <div class="welcome">
                <strong>O que fazer agora?</strong><br>
                Aceda ao Portal do Aluno para consultar os materiais do curso, horários, notas e muito mais.
                Se tiver dúvidas, a nossa equipa está disponível para ajudar.
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
