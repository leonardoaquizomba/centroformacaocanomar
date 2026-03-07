<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Luísa Mendonça',
                'role' => 'Técnica de Informática — Sonangol',
                'content' => 'O curso de Redes e Segurança Informática foi determinante para a minha carreira. Os professores são altamente qualificados e as aulas são muito práticas. Recomendo a qualquer pessoa que queira crescer na área tecnológica.',
                'order' => 1,
            ],
            [
                'name' => 'Eduardo Teixeira',
                'role' => 'Designer Gráfico Freelancer',
                'content' => 'Fiz o curso de Design Gráfico com Adobe e foi a melhor decisão que tomei. Em menos de três meses após a certificação já tinha os meus primeiros clientes. O Canomar abre mesmo portas.',
                'order' => 2,
            ],
            [
                'name' => 'Beatriz Nzinga',
                'role' => 'Gestora Financeira — PME Luanda',
                'content' => 'O curso de Contabilidade e Fiscalidade deu-me as ferramentas que precisava para gerir as finanças da minha empresa com confiança. Conteúdo actualizado, com foco na realidade angolana.',
                'order' => 3,
            ],
            [
                'name' => 'Simão Cardoso',
                'role' => 'Desenvolvedor Web Júnior — StartupAO',
                'content' => 'Vim ao Canomar sem saber nada de programação. Saí com um portfólio e um emprego. O apoio dos professores faz toda a diferença — nunca me senti perdido durante o curso.',
                'order' => 4,
            ],
            [
                'name' => 'Fernanda Quiala',
                'role' => 'Enfermeira — Hospital Geral de Luanda',
                'content' => 'O curso de Primeiros Socorros é obrigatório para qualquer profissional de saúde. Muito bem estruturado, com simulações realistas. Saí preparada para agir em situações de emergência.',
                'order' => 5,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['photo_path' => null, 'is_active' => true])
            );
        }
    }
}
