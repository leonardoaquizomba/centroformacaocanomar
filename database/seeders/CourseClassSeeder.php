<?php

namespace Database\Seeders;

use App\Enums\DayOfWeek;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Schedule;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CourseClassSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 teachers with profiles
        $teachers = collect([
            ['name' => 'Prof. António Silva', 'email' => 'antonio.silva@canomar.ao', 'spec' => 'Tecnologias de Informação'],
            ['name' => 'Prof. Maria Fernandes', 'email' => 'maria.fernandes@canomar.ao', 'spec' => 'Desenvolvimento Web'],
            ['name' => 'Prof. Carlos Lopes', 'email' => 'carlos.lopes@canomar.ao', 'spec' => 'Gestão de Empresas'],
            ['name' => 'Prof. Ana Rodrigues', 'email' => 'ana.rodrigues@canomar.ao', 'spec' => 'Língua Inglesa'],
            ['name' => 'Prof. João Baptista', 'email' => 'joao.baptista@canomar.ao', 'spec' => 'Construção Civil'],
        ])->map(function (array $data): User {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole('professor');

            TeacherProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => 'Docente com vasta experiência na área de '.$data['spec'].'. Comprometido com a formação prática e o desenvolvimento profissional dos alunos.',
                    'specialization' => $data['spec'],
                    'phone' => '+244 9'.rand(10000000, 99999999),
                ]
            );

            return $user;
        });

        [$tec1, $tec2, $gestao, $ingles, $civil] = $teachers;

        // Map: course slug => [teacher, schedule pairs, past/ongoing/future]
        $classDefinitions = [
            'informatica-basica' => [
                ['teacher' => $tec1, 'label' => 'Turma A', 'start' => '-4 months', 'end' => '-1 month', 'schedules' => [[DayOfWeek::Segunda, '08:00', '11:00'], [DayOfWeek::Quarta, '08:00', '11:00']]],
                ['teacher' => $tec1, 'label' => 'Turma B', 'start' => 'now',       'end' => '+3 months', 'schedules' => [[DayOfWeek::Terca, '14:00', '17:00'], [DayOfWeek::Quinta, '14:00', '17:00']]],
                ['teacher' => $tec1, 'label' => 'Turma C', 'start' => '+2 months', 'end' => '+5 months', 'schedules' => [[DayOfWeek::Sexta,  '17:00', '20:00'], [DayOfWeek::Sabado, '09:00', '12:00']]],
            ],
            'desenvolvimento-web' => [
                ['teacher' => $tec2, 'label' => 'Turma A', 'start' => '-3 months', 'end' => '+1 month',  'schedules' => [[DayOfWeek::Segunda, '17:00', '20:00'], [DayOfWeek::Quarta, '17:00', '20:00'], [DayOfWeek::Sexta, '17:00', '20:00']]],
                ['teacher' => $tec2, 'label' => 'Turma B', 'start' => '+1 month',  'end' => '+5 months', 'schedules' => [[DayOfWeek::Terca, '08:00', '11:00'], [DayOfWeek::Quinta, '08:00', '11:00']]],
            ],
            'redes-seguranca-informatica' => [
                ['teacher' => $tec1, 'label' => 'Turma A', 'start' => 'now',       'end' => '+2 months', 'schedules' => [[DayOfWeek::Sabado, '08:00', '13:00']]],
            ],
            'gestao-empresas' => [
                ['teacher' => $gestao, 'label' => 'Turma A', 'start' => '-5 months', 'end' => '-1 month',  'schedules' => [[DayOfWeek::Segunda, '17:00', '20:00'], [DayOfWeek::Quarta, '17:00', '20:00']]],
                ['teacher' => $gestao, 'label' => 'Turma B', 'start' => 'now',       'end' => '+3 months', 'schedules' => [[DayOfWeek::Terca, '17:00', '20:00'], [DayOfWeek::Quinta, '17:00', '20:00']]],
            ],
            'contabilidade-fiscalidade' => [
                ['teacher' => $gestao, 'label' => 'Turma A', 'start' => '+1 month', 'end' => '+3 months', 'schedules' => [[DayOfWeek::Sabado, '08:00', '12:00']]],
            ],
            'primeiros-socorros' => [
                ['teacher' => $civil, 'label' => 'Turma A', 'start' => '-2 months', 'end' => '-1 month',  'schedules' => [[DayOfWeek::Sabado, '08:00', '16:00']]],
                ['teacher' => $civil, 'label' => 'Turma B', 'start' => '+1 month',  'end' => '+2 months', 'schedules' => [[DayOfWeek::Domingo, '08:00', '16:00']]],
            ],
            'ingles-negocios' => [
                ['teacher' => $ingles, 'label' => 'Turma A', 'start' => '-2 months', 'end' => '+1 month',  'schedules' => [[DayOfWeek::Segunda, '07:00', '08:30'], [DayOfWeek::Quarta, '07:00', '08:30'], [DayOfWeek::Sexta, '07:00', '08:30']]],
                ['teacher' => $ingles, 'label' => 'Turma B', 'start' => '+1 month',  'end' => '+4 months', 'schedules' => [[DayOfWeek::Terca, '18:30', '20:00'], [DayOfWeek::Quinta, '18:30', '20:00']]],
            ],
            'frances-basico' => [
                ['teacher' => $ingles, 'label' => 'Turma A', 'start' => '+2 months', 'end' => '+5 months', 'schedules' => [[DayOfWeek::Sabado, '09:00', '12:00']]],
            ],
            'electricidade-industrial' => [
                ['teacher' => $civil, 'label' => 'Turma A', 'start' => 'now',       'end' => '+3 months', 'schedules' => [[DayOfWeek::Segunda, '08:00', '12:00'], [DayOfWeek::Quarta, '08:00', '12:00']]],
            ],
            'design-grafico-adobe' => [
                ['teacher' => $tec2, 'label' => 'Turma A', 'start' => '-1 month',  'end' => '+3 months', 'schedules' => [[DayOfWeek::Terca, '14:00', '17:00'], [DayOfWeek::Quinta, '14:00', '17:00']]],
            ],
        ];

        foreach ($classDefinitions as $courseSlug => $classes) {
            $course = Course::where('slug', $courseSlug)->first();

            if (! $course) {
                continue;
            }

            foreach ($classes as $def) {
                $startDate = new \DateTime($def['start'] === 'now' ? 'today' : $def['start']);
                $endDate = new \DateTime($def['end'] === 'now' ? 'today' : $def['end']);

                $isPast = $endDate < new \DateTime('today');
                $isActive = ! $isPast;

                $class = CourseClass::firstOrCreate(
                    ['course_id' => $course->id, 'name' => $def['label']],
                    [
                        'teacher_id' => $def['teacher']->id,
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'max_students' => 20,
                        'is_active' => $isActive,
                    ]
                );

                foreach ($def['schedules'] as [$day, $start, $end]) {
                    Schedule::firstOrCreate(
                        ['course_class_id' => $class->id, 'day_of_week' => $day->value],
                        ['start_time' => $start, 'end_time' => $end, 'location' => 'Sala '.$this->sala($day)]
                    );
                }
            }
        }
    }

    private function sala(DayOfWeek $day): string
    {
        return match ($day) {
            DayOfWeek::Segunda, DayOfWeek::Terca => '101',
            DayOfWeek::Quarta, DayOfWeek::Quinta => '102',
            default => '201',
        };
    }
}
