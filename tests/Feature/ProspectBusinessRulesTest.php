<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Prospect;

class ProspectBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_crea_un_prospecto_con_estado_inicial_new(): void
    {
        $response = $this->postJson('/api/prospects', [
            'name'  => 'Juan Pérez',
            'phone' => '8341234567',
            'email' => 'juan@example.com',
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('status', 'new');

        $this->assertDatabaseHas('prospects', [
            'phone'  => '8341234567',
            'status' => 'new',
        ]);
    }

    public function test_el_primer_seguimiento_cambia_el_estado_de_new_a_contacted(): void
    {
        $prospect = Prospect::factory()->create(['status' => 'new']);

        $response = $this->postJson("/api/prospects/{$prospect->id}/follow-ups", [
            'type'  => 'call',
            'notes' => 'Llamada inicial de presentación.',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('prospects', [
            'id'     => $prospect->id,
            'status' => 'contacted',
        ]);
    }

    public function test_permite_conservar_el_telefono_propio_al_editar_pero_rechaza_el_de_otro(): void
    {
        $prospect1 = Prospect::factory()->create(['phone' => '1111111111']);
        $prospect2 = Prospect::factory()->create(['phone' => '2222222222']);

        // Conservar su propio teléfono
        $this->putJson("/api/prospects/{$prospect1->id}", [
            'name'  => 'Nombre Actualizado',
            'phone' => '1111111111',
        ])->assertStatus(200);

        // Intentar usar el teléfono del prospecto 2 (Debe fallar con 422)
        $this->putJson("/api/prospects/{$prospect1->id}", [
            'name'  => 'Nombre Actualizado',
            'phone' => '2222222222',
        ])->assertStatus(422);
    }

    public function test_no_permite_editar_ni_agregar_seguimientos_a_un_prospecto_cerrado(): void
    {
        $prospect = Prospect::factory()->create(['status' => 'closed']);

        // Intentar editar -> 409 Conflict
        $this->putJson("/api/prospects/{$prospect->id}", [
            'name'  => 'Nuevo Nombre',
            'phone' => $prospect->phone,
        ])->assertStatus(409);

        // Intentar agregar seguimiento -> 409 Conflict
        $this->postJson("/api/prospects/{$prospect->id}/follow-ups", [
            'type'  => 'whatsapp',
            'notes' => 'Intento de contacto a prospecto cerrado.',
        ])->assertStatus(409);
    }
}
