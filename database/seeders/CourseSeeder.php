<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat = fn (string $slug) => \App\Models\CourseCategory::where('slug', $slug)->value('id');

        $courses = [
            // Tecnologia
            [
                'course_category_id' => $cat('tecnologia'),
                'name' => 'Informática Básica',
                'slug' => 'informatica-basica',
                'description' => 'Introdução ao uso de computadores, sistemas operativos e aplicações de escritório. Ideal para quem nunca utilizou um computador ou deseja consolidar conhecimentos fundamentais.',
                'duration_hours' => 40,
                'modality' => 'presencial',
                'level' => 'básico',
                'price' => 15000,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'course_category_id' => $cat('tecnologia'),
                'name' => 'Desenvolvimento Web',
                'slug' => 'desenvolvimento-web',
                'description' => 'Aprenda HTML, CSS e JavaScript para criar websites modernos e responsivos. Inclui introdução a frameworks como Bootstrap e noções de alojamento web.',
                'duration_hours' => 120,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 35000,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'course_category_id' => $cat('tecnologia'),
                'name' => 'Redes e Segurança Informática',
                'slug' => 'redes-seguranca-informatica',
                'description' => 'Conceitos de redes locais, protocolos TCP/IP, configuração de routers e switches, e fundamentos de cibersegurança para ambientes empresariais.',
                'duration_hours' => 80,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 28000,
                'is_active' => true,
                'is_featured' => true,
            ],
            // Gestão
            [
                'course_category_id' => $cat('gestao'),
                'name' => 'Gestão de Empresas',
                'slug' => 'gestao-empresas',
                'description' => 'Fundamentos de administração, liderança e gestão estratégica de organizações. Aborda planeamento, controlo financeiro e gestão de equipas.',
                'duration_hours' => 80,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 25000,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'course_category_id' => $cat('gestao'),
                'name' => 'Contabilidade e Fiscalidade',
                'slug' => 'contabilidade-fiscalidade',
                'description' => 'Escrituração contabilística, demonstrações financeiras e obrigações fiscais em Angola. Prático e orientado para PMEs e empreendedores.',
                'duration_hours' => 60,
                'modality' => 'presencial',
                'level' => 'básico',
                'price' => 20000,
                'is_active' => true,
                'is_featured' => false,
            ],
            // Saúde
            [
                'course_category_id' => $cat('saude'),
                'name' => 'Primeiros Socorros e Emergências',
                'slug' => 'primeiros-socorros',
                'description' => 'Técnicas de reanimação cardiopulmonar (RCP), tratamento de feridas, imobilizações e actuação em situações de emergência médica.',
                'duration_hours' => 24,
                'modality' => 'presencial',
                'level' => 'básico',
                'price' => 12000,
                'is_active' => true,
                'is_featured' => true,
            ],
            // Línguas
            [
                'course_category_id' => $cat('linguas'),
                'name' => 'Inglês para Negócios',
                'slug' => 'ingles-negocios',
                'description' => 'Comunicação profissional em inglês: reuniões, emails, apresentações e negociações. Nível intermédio a avançado com foco no contexto empresarial angolano.',
                'duration_hours' => 60,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 22000,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'course_category_id' => $cat('linguas'),
                'name' => 'Francês Básico',
                'slug' => 'frances-basico',
                'description' => 'Introdução à língua francesa para comunicação do dia-a-dia e viagens. Vocabulário essencial, gramática básica e expressão oral.',
                'duration_hours' => 40,
                'modality' => 'presencial',
                'level' => 'básico',
                'price' => 18000,
                'is_active' => true,
                'is_featured' => false,
            ],
            // Construção Civil
            [
                'course_category_id' => $cat('construcao-civil'),
                'name' => 'Electricidade Industrial',
                'slug' => 'electricidade-industrial',
                'description' => 'Instalações eléctricas industriais, normas de segurança, leitura de esquemas e manutenção de quadros eléctricos.',
                'duration_hours' => 80,
                'modality' => 'presencial',
                'level' => 'médio',
                'price' => 30000,
                'is_active' => true,
                'is_featured' => false,
            ],
            // Artes e Design
            [
                'course_category_id' => $cat('artes-design'),
                'name' => 'Design Gráfico com Adobe',
                'slug' => 'design-grafico-adobe',
                'description' => 'Photoshop, Illustrator e InDesign aplicados à criação de identidades visuais, material publicitário e conteúdo para redes sociais.',
                'duration_hours' => 100,
                'modality' => 'presencial',
                'level' => 'básico',
                'price' => 32000,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($courses as $course) {
            \App\Models\Course::firstOrCreate(['slug' => $course['slug']], $course);
        }
    }
}
