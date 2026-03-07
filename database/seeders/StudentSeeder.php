<?php

namespace Database\Seeders;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@canomar.ao')->first();

        // ─── 1. Update the single test student from RoleSeeder ───────────────
        $testStudent = User::where('email', 'aluno@canomar.ao')->first();
        if ($testStudent) {
            StudentProfile::firstOrCreate(
                ['user_id' => $testStudent->id],
                [
                    'bi_number' => 'AB12345678',
                    'date_of_birth' => '1995-06-15',
                    'address' => 'Rua da Samba, Luanda',
                    'phone' => '+244 923000001',
                ]
            );
        }

        // ─── 2. Create 30 students covering every lifecycle scenario ──────────
        $scenarios = [
            // [status, paid, has_certificate, notes]
            [EnrollmentStatus::Pendente,    false, false, 'Inscrição recebida, aguarda revisão.'],
            [EnrollmentStatus::Pendente,    false, false, null],
            [EnrollmentStatus::Pendente,    false, false, null],
            [EnrollmentStatus::Aprovado,    false, false, 'Documentos verificados, aguarda pagamento.'],
            [EnrollmentStatus::Aprovado,    false, false, null],
            [EnrollmentStatus::Aprovado,    true,  false, 'Pagamento recebido, aguarda início da turma.'],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Matriculado, true,  false, 'Frequência irregular — contactar aluno.'],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Concluido,   true,  false, 'Certificado em preparação.'],
            [EnrollmentStatus::Rejeitado,   false, false, 'Documentos incompletos.'],
            [EnrollmentStatus::Rejeitado,   false, false, 'Pré-requisitos não satisfeitos.'],
            [EnrollmentStatus::Cancelado,   false, false, 'Cancelado a pedido do aluno.'],
            [EnrollmentStatus::Cancelado,   true,  false, 'Cancelado — reembolso processado.'],
            // Extra matriculated students for variety
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
            [EnrollmentStatus::Pendente,    false, false, null],
            [EnrollmentStatus::Aprovado,    false, false, null],
            [EnrollmentStatus::Matriculado, true,  false, null],
            [EnrollmentStatus::Concluido,   true,  true,  null],
        ];

        $courses = Course::where('is_active', true)->get();
        $courseCount = $courses->count();

        foreach ($scenarios as $index => [$status, $paid, $hasCertificate, $notes]) {
            $user = User::create([
                'name' => $this->angolangName(),
                'email' => 'aluno'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'@canomar.ao',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('aluno');

            StudentProfile::create([
                'user_id' => $user->id,
                'bi_number' => strtoupper(chr(rand(65, 90)).chr(rand(65, 90)).rand(10000000, 99999999)),
                'date_of_birth' => now()->subYears(rand(18, 45))->subDays(rand(0, 365))->format('Y-m-d'),
                'address' => $this->angolangAddress(),
                'phone' => '+244 9'.rand(10000000, 99999999),
            ]);

            $course = $courses[$index % $courseCount];

            // Prefer a past or active class for completed/ongoing enrollments
            $class = CourseClass::where('course_id', $course->id)->first();

            $approvedAt = in_array($status, [
                EnrollmentStatus::Matriculado,
                EnrollmentStatus::Concluido,
                EnrollmentStatus::Aprovado,
            ]) ? now()->subDays(rand(30, 90)) : null;

            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'course_class_id' => $class?->id,
                'status' => $status,
                'notes' => $notes,
                'approved_at' => $approvedAt,
                'approved_by' => $approvedAt ? $admin?->id : null,
                'created_at' => now()->subDays(rand(1, 120)),
            ]);

            if ($paid) {
                Payment::create([
                    'enrollment_id' => $enrollment->id,
                    'amount' => $course->price,
                    'method' => rand(0, 1) ? PaymentMethod::Transferencia : PaymentMethod::Multicaixa,
                    'status' => PaymentStatus::Pago,
                ]);
            }

            if ($hasCertificate) {
                $year = now()->year;
                $seq = str_pad((string) ($index + 1), 6, '0', STR_PAD_LEFT);
                Certificate::create([
                    'enrollment_id' => $enrollment->id,
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'code' => "CAN-{$year}-{$seq}",
                    'issued_at' => now()->subDays(rand(1, 30)),
                    'file_path' => null,
                ]);
            }
        }
    }

    private function angolangName(): string
    {
        $first = ['Ana', 'Maria', 'João', 'Pedro', 'Luísa', 'Carlos', 'Filomena', 'Eduardo', 'Beatriz', 'Simão', 'Fernanda', 'António', 'Rosa', 'Manuel', 'Isabel', 'Augusto', 'Conceição', 'Francisco', 'Margarida', 'Domingos'];
        $last = ['Silva', 'Santos', 'Ferreira', 'Costa', 'Nzinga', 'Lopes', 'Rodrigues', 'Martins', 'Pereira', 'Sousa', 'Cardoso', 'Teixeira', 'Mendonça', 'Capita', 'Lufunga', 'Baptista', 'Quiala', 'Tavares', 'Gomes', 'Monteiro'];

        return $first[array_rand($first)].' '.$last[array_rand($last)];
    }

    private function angolangAddress(): string
    {
        $streets = ['Rua da Samba', 'Av. 4 de Fevereiro', 'Rua Direita', 'Av. Comandante Valódia', 'Bairro Miramar', 'Bairro Rangel', 'Rua do Tchizo', 'Av. 21 de Janeiro', 'Rua Major Kanhangulo'];
        $cities = ['Luanda', 'Luanda', 'Luanda', 'Viana', 'Cacuaco'];

        return $streets[array_rand($streets)].', '.$cities[array_rand($cities)];
    }
}
