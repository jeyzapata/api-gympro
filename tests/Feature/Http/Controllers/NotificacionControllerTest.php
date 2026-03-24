<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NotificacionController
 */
final class NotificacionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $notificacions = Notificacion::factory()->count(3)->create();

        $response = $this->get(route('notificacions.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NotificacionController::class,
            'store',
            \App\Http\Requests\Notificacion\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $titulo = fake()->word();
        $cuerpo = fake()->text();
        $tipo = fake()->randomElement(/** enum_attributes **/);
        $leida = fake()->boolean();

        $response = $this->post(route('notificacions.store'), [
            'user_id' => $user->id,
            'titulo' => $titulo,
            'cuerpo' => $cuerpo,
            'tipo' => $tipo,
            'leida' => $leida,
        ]);

        $notificacions = Notificacion::query()
            ->where('user_id', $user->id)
            ->where('titulo', $titulo)
            ->where('cuerpo', $cuerpo)
            ->where('tipo', $tipo)
            ->where('leida', $leida)
            ->get();
        $this->assertCount(1, $notificacions);
        $notificacion = $notificacions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $notificacion = Notificacion::factory()->create();

        $response = $this->get(route('notificacions.show', $notificacion));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NotificacionController::class,
            'update',
            \App\Http\Requests\Notificacion\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $notificacion = Notificacion::factory()->create();
        $user = User::factory()->create();
        $titulo = fake()->word();
        $cuerpo = fake()->text();
        $tipo = fake()->randomElement(/** enum_attributes **/);
        $leida = fake()->boolean();

        $response = $this->put(route('notificacions.update', $notificacion), [
            'user_id' => $user->id,
            'titulo' => $titulo,
            'cuerpo' => $cuerpo,
            'tipo' => $tipo,
            'leida' => $leida,
        ]);

        $notificacion->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $notificacion->user_id);
        $this->assertEquals($titulo, $notificacion->titulo);
        $this->assertEquals($cuerpo, $notificacion->cuerpo);
        $this->assertEquals($tipo, $notificacion->tipo);
        $this->assertEquals($leida, $notificacion->leida);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $notificacion = Notificacion::factory()->create();

        $response = $this->delete(route('notificacions.destroy', $notificacion));

        $response->assertNoContent();

        $this->assertModelMissing($notificacion);
    }
}
