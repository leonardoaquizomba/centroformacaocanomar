<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@canomar.ao')->first();

        $cat = fn (string $slug) => PostCategory::where('slug', $slug)->value('id');

        $posts = [
            // Notícias
            [
                'cat' => 'noticias',
                'title' => 'Centro de Formação Canomar inaugura novos laboratórios de informática',
                'slug' => 'canomar-inaugura-laboratorios-informatica',
                'excerpt' => 'Com investimento em equipamento de última geração, os novos laboratórios permitem aulas mais práticas e modernas.',
                'body' => '<p>O Centro de Formação Canomar deu mais um passo no reforço da qualidade do ensino com a inauguração de dois novos laboratórios de informática, totalmente equipados com computadores de alto desempenho e ligação à internet de banda larga.</p><p>Os novos espaços têm capacidade para 25 alunos cada e estarão disponíveis para os cursos de Informática Básica, Desenvolvimento Web e Redes e Segurança Informática, entre outros.</p><p>A directora do centro, Dra. Catarina Sousa, afirmou que este investimento é parte de uma estratégia de modernização que continuará ao longo do próximo ano, com a introdução de cursos de programação e inteligência artificial.</p>',
                'published_at' => now()->subDays(3),
            ],
            [
                'cat' => 'noticias',
                'title' => 'Parceria com empresas angolanas garante estágios aos nossos formandos',
                'slug' => 'parceria-empresas-estagios-formandos',
                'excerpt' => 'Protocolo assinado com 8 empresas parceiras abre portas a estágios remunerados para alunos certificados.',
                'body' => '<p>O Canomar assinou protocolos de cooperação com oito empresas de referência nos sectores de tecnologia, construção civil e serviços financeiros em Angola.</p><p>Os alunos que concluam os seus cursos com aproveitamento terão acesso prioritário a estágios remunerados com duração de três a seis meses, constituindo uma ponte essencial entre a formação e o mercado de trabalho.</p><p>"Queremos que os nossos diplomas tenham valor real no mercado", declarou a directora do centro. "Esta parceria é a prova disso."</p>',
                'published_at' => now()->subDays(12),
            ],
            [
                'cat' => 'noticias',
                'title' => 'Canomar entre os melhores centros de formação profissional de Luanda',
                'slug' => 'canomar-melhores-centros-formacao-luanda',
                'excerpt' => 'Reconhecimento do Ministério da Educação distingue o nosso centro pela qualidade dos cursos e taxa de empregabilidade.',
                'body' => '<p>O Centro de Formação Canomar foi distinguido pelo Ministério da Educação como um dos cinco melhores centros de formação profissional de Luanda, na cerimónia anual de reconhecimento de instituições de excelência.</p><p>O prémio foi atribuído com base em critérios como a qualidade pedagógica, a satisfação dos formandos e a taxa de empregabilidade dos certificados.</p>',
                'published_at' => now()->subDays(30),
            ],
            // Dicas de Carreira
            [
                'cat' => 'dicas-carreira',
                'title' => '5 competências digitais que toda a empresa angolana procura em 2025',
                'slug' => 'competencias-digitais-empresas-angola-2025',
                'excerpt' => 'Do domínio do Excel à segurança informática, descubra quais as habilidades mais valorizadas no mercado angolano.',
                'body' => '<p>O mercado de trabalho em Angola está em rápida transformação digital. As empresas procuram cada vez mais profissionais que combinem competências técnicas com capacidade de adaptação. Listamos as cinco mais procuradas:</p><ol><li><strong>Folha de Cálculo avançada (Excel/Google Sheets)</strong> – Essencial em finanças, logística e recursos humanos.</li><li><strong>Gestão de redes sociais e marketing digital</strong> – Com o crescimento do e-commerce, esta competência tornou-se indispensável.</li><li><strong>Segurança informática básica</strong> – Proteger dados da empresa é uma preocupação crescente.</li><li><strong>Programação e automatização</strong> – Python e JavaScript lideram as pesquisas de emprego.</li><li><strong>Inglês técnico e de negócios</strong> – A língua continua a ser a chave para oportunidades internacionais.</li></ol><p>O Centro Canomar oferece cursos em todas estas áreas. Consulte o nosso catálogo!</p>',
                'published_at' => now()->subDays(8),
            ],
            [
                'cat' => 'dicas-carreira',
                'title' => 'Como preparar um currículo que se destaque: guia para jovens angolanos',
                'slug' => 'preparar-curriculo-jovens-angolanos',
                'excerpt' => 'Erros comuns a evitar e truques para fazer o seu CV chegar às mãos do recrutador certo.',
                'body' => '<p>Um currículo bem construído é a sua primeira impressão junto de um recrutador. Antes de enviar o seu próximo CV, certifique-se de que segue estas boas práticas:</p><h3>Estrutura clara</h3><p>Use secções bem definidas: dados pessoais, formação académica, experiência profissional, competências e referências. Evite designs demasiado elaborados que dificultam a leitura.</p><h3>Personalize para cada vaga</h3><p>Não use o mesmo CV para todas as candidaturas. Adapte as competências destacadas ao perfil pedido.</p><h3>Inclua certificações</h3><p>Certificados de formação profissional, como os emitidos pelo Canomar, valorizam muito o seu perfil.</p>',
                'published_at' => now()->subDays(18),
            ],
            [
                'cat' => 'dicas-carreira',
                'title' => 'Empreendedorismo em Angola: como transformar a formação em negócio',
                'slug' => 'empreendedorismo-angola-formacao-negocio',
                'excerpt' => 'Histórias de ex-alunos que usaram as competências adquiridas no Canomar para criar os seus próprios negócios.',
                'body' => '<p>Vários ex-alunos do Canomar tomaram um caminho diferente após a certificação: em vez de procurar emprego, criaram o seu próprio. Partilhamos três histórias inspiradoras.</p><p><strong>Pedro Lufunga</strong> concluiu o curso de Design Gráfico em 2023 e abriu um estúdio criativo em Luanda que hoje trabalha com marcas de referência no sector alimentar.</p><p><strong>Filomena Capita</strong> formou-se em Informática Básica e lançou um serviço de suporte técnico ao domicílio que conta com cinco técnicos na equipa.</p>',
                'published_at' => now()->subDays(25),
            ],
            // Tecnologia
            [
                'cat' => 'tecnologia',
                'title' => 'Inteligência Artificial: o que os profissionais angolanos precisam de saber',
                'slug' => 'inteligencia-artificial-profissionais-angolanos',
                'excerpt' => 'A IA está a transformar o mercado de trabalho globalmente. Saiba como preparar-se para esta mudança.',
                'body' => '<p>A inteligência artificial (IA) deixou de ser ficção científica para se tornar uma realidade presente no dia-a-dia de empresas de todo o mundo — incluindo em Angola.</p><p>Ferramentas como o ChatGPT, Copilot e Gemini já são utilizadas em tarefas de escrita, programação, análise de dados e atendimento ao cliente. Profissionais que souberem usar estas ferramentas terão vantagem competitiva significativa.</p><p>No Canomar, já estamos a incorporar noções de IA nos cursos de Desenvolvimento Web e Informática, preparando os nossos alunos para este novo paradigma.</p>',
                'published_at' => now()->subDays(5),
            ],
            [
                'cat' => 'tecnologia',
                'title' => 'Cibersegurança em Angola: proteja a sua empresa dos ataques informáticos',
                'slug' => 'ciberseguranca-angola-proteja-empresa',
                'excerpt' => 'Os ataques informáticos aumentaram 300% em África nos últimos dois anos. Saiba como proteger o seu negócio.',
                'body' => '<p>Angola registou um aumento significativo de ciberataques nos últimos anos, com empresas de todos os sectores a ser alvo de ransomware, phishing e roubo de dados.</p><p>As boas notícias: a maioria destes ataques pode ser prevenida com formação adequada dos colaboradores e boas práticas de segurança informática.</p><p>O nosso curso de Redes e Segurança Informática aborda exactamente estas questões, capacitando profissionais para identificar e responder a ameaças digitais.</p>',
                'published_at' => now()->subDays(22),
            ],
            // Eventos
            [
                'cat' => 'eventos',
                'title' => 'Open Day Canomar: visite as nossas instalações e conheça os cursos',
                'slug' => 'open-day-canomar-visita-instalacoes',
                'excerpt' => 'No próximo sábado abrimos as portas a futuros alunos e famílias. Entrada gratuita, sem necessidade de inscrição.',
                'body' => '<p>O Centro de Formação Canomar convida-o a visitar as nossas instalações no próximo <strong>sábado, das 09h às 13h</strong>.</p><p>Durante o Open Day terá oportunidade de:</p><ul><li>Conhecer os laboratórios e salas de aula</li><li>Conversar com os nossos docentes</li><li>Esclarecer dúvidas sobre cursos, calendários e condições de pagamento</li><li>Assistir a demonstrações práticas dos cursos de Design e Programação</li></ul><p>A entrada é gratuita e não é necessária inscrição prévia. Traga a família!</p>',
                'published_at' => now()->subDays(2),
            ],
            [
                'cat' => 'eventos',
                'title' => 'Cerimónia de entrega de certificados — Março 2025',
                'slug' => 'cerimonia-entrega-certificados-marco-2025',
                'excerpt' => 'Mais de 60 formandos receberam os seus certificados numa cerimónia emotiva celebrada na sede do centro.',
                'body' => '<p>No passado mês de Março realizou-se a cerimónia de entrega de certificados a 64 formandos que concluíram com sucesso os cursos de Informática Básica, Gestão de Empresas, Inglês para Negócios e Primeiros Socorros.</p><p>A cerimónia contou com a presença de familiares, docentes e representantes das empresas parceiras do Canomar. A directora do centro destacou a dedicação dos formandos e desafiou-os a continuar a investir na sua formação.</p>',
                'published_at' => now()->subDays(45),
            ],
            [
                'cat' => 'eventos',
                'title' => 'Workshop gratuito: Introdução ao Excel para o dia-a-dia profissional',
                'slug' => 'workshop-gratuito-introducao-excel',
                'excerpt' => 'Inscrições abertas para o workshop gratuito de Excel — vagas limitadas a 20 participantes.',
                'body' => '<p>O Canomar promove um <strong>workshop gratuito de Excel</strong> com duração de 4 horas, direccionado a profissionais que pretendam melhorar a sua produtividade com folhas de cálculo.</p><p>O workshop cobrirá: funções básicas e avançadas, tabelas dinâmicas, gráficos e automatização com macros.</p><p>As vagas são limitadas a 20 participantes. Para se inscrever, envie um email para info@canomar.ao com o assunto "Workshop Excel".</p>',
                'published_at' => now()->subDays(10),
            ],
            [
                'cat' => 'noticias',
                'title' => 'Novos cursos online disponíveis a partir de Julho',
                'slug' => 'novos-cursos-online-julho',
                'excerpt' => 'O Canomar lança modalidade online para 4 cursos, tornando a formação acessível a todo o país.',
                'body' => '<p>A partir de Julho, o Centro de Formação Canomar passa a oferecer quatro cursos em modalidade online: Informática Básica, Inglês para Negócios, Contabilidade e Fiscalidade, e Design Gráfico com Adobe.</p><p>As aulas serão transmitidas ao vivo, com gravações disponíveis por 7 dias após cada sessão. Os alunos terão acesso a uma plataforma de suporte e poderão tirar dúvidas em tempo real.</p><p>O valor das propinas para a modalidade online é 20% inferior à presencial.</p>',
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($posts as $data) {
            Post::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'post_category_id' => $cat($data['cat']),
                    'user_id' => $admin->id,
                    'title' => $data['title'],
                    'slug' => $data['slug'],
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'image' => null,
                    'is_published' => true,
                    'published_at' => $data['published_at'],
                ]
            );
        }
    }
}
